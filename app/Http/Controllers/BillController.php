<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\ItemType;
use App\Product;
use App\Stock;
use App\Bill;
use App\User;
use App\Shop;
use App\customer;
use App\Company;
use App\Batch;

// start sms api details
use \NotifyLk\Configuration;
use \NotifyLk\ApiClient;
use \NotifyLk\ApiException;
use \NotifyLk\ObjectSerializer;
use App\SmsApi;
// end sms api details

class BillController extends Controller
{
    public function GetBillCurrentTotal()
    {
        if (Auth::check() && Carbon::parse(Carbon::now())->diffInSeconds(Auth::user()->shop->expire_date) != 0){
            if(Auth::user()->shop->expire_date > Carbon::now() || Auth::user()->shop->payment_plan == 'life_time'){            
                
                $bill_total = Bill::where('state','not-settled')->where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->sum('total_price');

                return $bill_total;
            }
            else{
                return redirect('/')->with('error','Please renew your Account,Your Account has been suspended');
            }
        }
        else{
            return redirect('/');
        }
    }

    public function unsettledBillCount()
    {
        return Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->sum('qty');
    }

    public function GetBilling()
    {
        if (Auth::check() && Carbon::parse(Carbon::now())->diffInSeconds(Auth::user()->shop->expire_date) != 0){
            if(Auth::user()->shop->expire_date > Carbon::now() || Auth::user()->shop->payment_plan == 'life_time'){            
                $itemTypes = ItemType::where('shop_id',Auth::user()->shop_id)->get();
                $products = Product::where('shop_id',Auth::user()->shop_id)->where('product_state','Active')->get();
                $bill_data = Bill::where('shop_id',Auth::user()->shop_id)->orderBy('created_at','DSC')->get();
                $bill_no = Bill::where('shop_id',Auth::user()->shop_id)->distinct()->get(['transaction_id','state']);
                $bill_total = Bill::where('state','not-settled')->where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->sum('total_price');

                $user_shop = Auth::user()->shop_name;
                $bill_id_un = Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->distinct('transaction_id')->value('transaction_id');

                return view('Bill/bill',compact('itemTypes','products','bill_data','bill_total','bill_no','bill_id_un'));
            }
            else{
                return redirect('/')->with('error','Please renew your Account,Your Account has been suspended');
            }
        }
        else{
            return redirect('/home');
        }
    }

    public function GetNewBillingInterface()
    {
        if (Auth::check() && Carbon::parse(Carbon::now())->diffInSeconds(Auth::user()->shop->expire_date) != 0){
            if(Auth::user()->shop->expire_date > Carbon::now() || Auth::user()->shop->payment_plan == 'life_time'){            
                
                return view('billing/bill');
            }
            else{
                return redirect('/')->with('error','Please renew your Account,Your Account has been suspended');
            }
        }
        else{
            return redirect('/');
        }
    }
        public function GetItemReturn(Request $request)
        {
            if (Auth::check()) {
                
                $return_bill_id = $request['return_item'];
                $return_qty = $request['qty'];
                $return_discount = $request['discount'];
                $reason = $request['reason'];

                $sold_batch_no = Bill::where('id',$return_bill_id)->where('state','settled')->where('shop_id',Auth::user()->shop_id)->value('batch_no');
                $sold_qty = Bill::where('id',$return_bill_id)->where('state','settled')->where('shop_id',Auth::user()->shop_id)->value('qty');
                $current_batch_sold_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->value('sold_qty');
                $new_batch_sold_qty = $current_batch_sold_qty - $return_qty;

                $batch_current_state = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->value('state');

                
                if ($batch_current_state == 0) {
                    Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->update(['state' => 1]);
                }

                if($reason != null){
                    if($return_qty == $sold_qty ){
                    Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->update(['sold_qty' => $new_batch_sold_qty]);
                    // _____________________________________
                    $voidBillDetails = Bill::where('shop_id',Auth::user()->shop_id)->where('id',$return_bill_id)->first();
                    $void_bill = new Bill();
                    $void_bill->user_id = Auth::user()->id;
                    $void_bill->shop_id = Auth::user()->shop_id;
                    $void_bill->product_id = $voidBillDetails->product_id;
                    $void_bill->transaction_id = $voidBillDetails->transaction_id;
                    $void_bill->qty = $voidBillDetails->qty;
                    $void_bill->selling_price = $voidBillDetails->selling_price;
                    $void_bill->total_price = $voidBillDetails->total_price;
                    $void_bill->serial_no = $voidBillDetails->serial_no;
                    $void_bill->batch_no = $voidBillDetails->batch_no;
                    $void_bill->discount = $voidBillDetails->discount;
                    $void_bill->discount_amount = $voidBillDetails->discount_amount;  
                    $void_bill->expire_date = $voidBillDetails->expire_date;
                    $void_bill->cash_credit = $voidBillDetails->cash_credit;
                    $void_bill->state = 'void';
                    $void_bill->remark = $reason;
                    $void_bill->save();
                    // _____________________________________
                    Bill::where('shop_id',Auth::user()->shop_id)->where('id',$return_bill_id)->delete();
                    // return redirect()->back()->with(['bill-success','Item Returned']);
                    return response()->json(['success' => true,'data' => 'Item Successfully Returned']);

                }else if($sold_qty > $return_qty){

                    Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->update(['sold_qty' => $new_batch_sold_qty]);

                    $bill_qty_after_return = $sold_qty - $return_qty;
                    $sold_discount = Bill::where('shop_id',Auth::user()->shop_id)->where('id',$return_bill_id)->where('shop_id',Auth::user()->shop_id)->first();
                    $new_discount_amount = (($bill_qty_after_return*$sold_discount->selling_price)/100)*($sold_discount->discount);

                    // _____________________________________
                    $voidBillDetails = Bill::where('shop_id',Auth::user()->shop_id)->where('id',$return_bill_id)->first();
                    $void_bill = new Bill();
                    $void_bill->user_id = Auth::user()->id;
                    $void_bill->shop_id = Auth::user()->shop_id;
                    $void_bill->product_id = $voidBillDetails->product_id;
                    $void_bill->transaction_id = $voidBillDetails->transaction_id;
                    $void_bill->qty = $return_qty;
                    $void_bill->selling_price = $voidBillDetails->selling_price;
                    $void_bill->total_price = ($return_qty*$voidBillDetails->selling_price);
                    $void_bill->serial_no = $voidBillDetails->serial_no;
                    $void_bill->batch_no = $voidBillDetails->batch_no;
                    $void_bill->discount = $voidBillDetails->discount;
                    $void_bill->discount_amount = (($return_qty*$voidBillDetails->selling_price)/100)*$voidBillDetails->discount;  
                    $void_bill->expire_date = $voidBillDetails->expire_date;
                    $void_bill->cash_credit = $voidBillDetails->cash_credit;
                    $void_bill->state = 'void';
                    $void_bill->remark = $reason;
                    $void_bill->save();
                    // _____________________________________

                     Bill::where('shop_id',Auth::user()->shop_id)->where('id',$return_bill_id)
                     ->where('shop_id',Auth::user()->shop_id)
                     ->update([
                        'qty' => $bill_qty_after_return,
                        'total_price' => ($bill_qty_after_return*$sold_discount->selling_price)-$new_discount_amount,
                        ]);
                     Stock::where('bill_id',$return_bill_id)
                     ->where('shop_id',Auth::user()->shop_id)
                     ->update([
                        'qty' => ($bill_qty_after_return)*(-1),
                        ]);

                     // return redirect()->back()->with(['bill-success','Successfully Item Returned']);
                    return response()->json(['success' => true,'data' => 'Item Successfully Returned']);                     
                }
                else{
                    return response()->json(['error' => true,'data' => 'cannot return']);
                    // return redirect()->back()->with(['bill-error','cannot return']);
                }
            }else{
                 return response()->json(['error' => true,'data' => 'Reason Required.....']);
            }


            }
            else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }
        }
    public function PostBillingItem(Request $request)
    {
        if (Auth::check()) {
            $bill_item_id = $request['bill_item_id'];
            // _____________________________________
            $previousBill = Bill::where('shop_id',Auth::user()->shop_id)
                        ->where('state','not-settled')
                        ->distinct('transaction_id')
                        ->orderBy('transaction_id','DESC')
                        ->first();

            if($previousBill != null){
                $UserCurrentBill = Bill::where('shop_id',Auth::user()->shop_id)
                        ->where('state','not-settled')
                        ->where('user_id',Auth::user()->id)
                        ->distinct('transaction_id')
                        ->orderBy('created_at','DESC')
                        ->first();
                    if($UserCurrentBill == null){
                        $transactionForUser = Bill::where('shop_id',Auth::user()->shop_id)
                                                ->distinct('transaction_id')
                                                ->orderBy('created_at','DESC')
                                                ->first();
                        $transaction_id = $transactionForUser->transaction_id + 1;
                    }else{
                        $transaction_id = $UserCurrentBill->transaction_id;
                    }
                
            }else{
                $previousBillsCheckNo = Bill::where('shop_id',Auth::user()->shop_id)
                        ->distinct('transaction_id')
                        ->orderBy('created_at','DESC')
                        ->first();

                if($previousBillsCheckNo == null){
                    $transaction_id = 1;
                }else{
                    $transaction_id = $previousBillsCheckNo->transaction_id + 1;
                }
                
            }
            // _____________________________________
            
            $selling_qty = $request['selling_qty'];
            $selling_price = $request['selling_price'];
            $selling_discount = $request['selling_discount'];
            $selling_batch = $request['selling_batch_no'];
            $batch_receive_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('receive_qty');
            $batch_sold_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('sold_qty');
            $batch_discard_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('discard_qty');
            $batch_available_qty = $batch_receive_qty - ($batch_discard_qty + $batch_discard_qty);
            $batch_product_id = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('product_id');
            $serial_no = $request['serial_no'];
            if ($selling_discount) {
                $total_price = (($selling_qty*$selling_price)/100)*(100-$selling_discount);
            }else{
                 $total_price = $selling_qty*$selling_price;
            }
            if (Carbon::now() == Carbon::parse($request['selling_item_expire_date']) ) {
             $selling_item_expire_date = '1111-01-01';  
            }else{
                $selling_item_expire_date = Carbon::parse($request['selling_item_expire_date']);
            }

            $new_salling_item = Stock::where('product_id',$bill_item_id)->where('shop_id',Auth::user()->shop_id)->orWhere('expire_date',$selling_item_expire_date)->first();

            // check_qty
            if(Stock::where('shop_id',Auth::user()->shop_id)->where('product_id',$bill_item_id)->sum('qty') >= $selling_qty){
                if($batch_available_qty >= $selling_qty){
                    if($batch_product_id == $bill_item_id){
                        
                        $new_bill = new Bill();
                        $new_bill->user_id = Auth::user()->id;
                        $new_bill->shop_id = Auth::user()->shop_id;
                        $new_bill->product_id = $bill_item_id;
                        $new_bill->transaction_id = $transaction_id;
                        $new_bill->qty = $selling_qty;
                        $new_bill->selling_price = $selling_price;
                        $new_bill->total_price = $total_price;
                        $new_bill->serial_no = $serial_no;
                        $new_bill->batch_no = $selling_batch;
                        if ($selling_discount) {
                        $new_bill->discount = $selling_discount;
                        $new_bill->discount_amount = (($selling_qty*$selling_price)/100)*($selling_discount);  
                        }
                        if ($selling_item_expire_date) {
                        $new_bill->expire_date = $selling_item_expire_date;   
                        }
                        $new_bill->save();
                        
                        $current_batch_sold_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('sold_qty');
                        $batch_receive_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('receive_qty');
                        $batch_discard_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->value('discard_qty');
                        $new_batch_sold_qty = $current_batch_sold_qty + $selling_qty;
                        Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->update(['sold_qty' => $new_batch_sold_qty]);
                        $consumtion = $new_batch_sold_qty + $batch_discard_qty;
                        if($batch_receive_qty == $consumtion){
                            Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$selling_batch)->update(['state' => 0]);
                        }

                        // create stock record
                        $new_sale = new Stock();
                        $new_sale->user_id = Auth::user()->id;
                        $new_sale->shop_id = Auth::user()->shop_id;
                        $new_sale->type_id = $new_salling_item->type_id;
                        $new_sale->product_id = $bill_item_id;
                        $new_sale->count_type = $new_salling_item->count_type;
                        $new_sale->qty = ($selling_qty)*(-1);
                        $new_sale->unit_price = $new_salling_item->unit_price;
                        $new_sale->expire_date = $new_salling_item->expire_date;
                        $new_sale->remark = 'sale';
                        $new_sale->bill_id = Bill::where('transaction_id',$transaction_id)->where('shop_id',Auth::user()->shop_id)->orderBy('created_at','DESC')->value('id');
                        $new_sale->save();

                        $bill_id_un = Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->distinct('transaction_id')->value('transaction_id');
                        // return redirect()->back()->with('bill-success','Item Successfully Billed');
                        // return redirect()->back()->with('billsuccess','Item Successfully Billed');
                        return response()->json(['success' => true,'data' => 'item Build Successfull','type_id' => Product::where('id',$bill_item_id)->where('shop_id',Auth::user()->shop_id)->value('type_id')]);
                        // return response()->json(['success' => true,'data' => 'item Build Successfull','bill_id' => $bill_id_un]);
                        // return Response::json(array('success' => true,'message' => 'item Build Successfull'));
                    
                    }else{
                        // return redirect()->back()->with('bill-error','Batch No Is Incorrect');
                        return response()->json(['error' => true,'data' => 'Batch No Is Incorrect']);
                    }
                }else{
                    // return redirect()->back()->with('bill-error','Batch available qty exceed');
                    return response()->json(['error' => true, 'data' => 'Batch No Is Incorrect']);
                }
            }else{
                // return redirect()->back()->with('bill-error','Stock Quantity exceeded,please Enter available quantity on stock');
                return response()->json(['error' => true,'data' => 'Stock Quantity exceeded,please Enter available quantity on stock']);
            }
            // end_check_qty

        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function RemoveBillingItem(Request $request)
    {
        $sold_batch_no = Bill::where('id',$request['bill_id'])->where('shop_id',Auth::user()->shop_id)->value('batch_no');
        $sold_qty = Bill::where('id',$request['bill_id'])->where('shop_id',Auth::user()->shop_id)->value('qty');
        $current_batch_sold_qty = Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->value('sold_qty');
        $new_batch_sold_qty = $current_batch_sold_qty - $sold_qty;
        Batch::where('shop_id',Auth::user()->shop_id)->where('batch_no',$sold_batch_no)->update(['sold_qty' => $new_batch_sold_qty]);
        $new_stock_entry = new Stock();


        Stock::where('bill_id',$request['bill_id'])->where('shop_id',Auth::user()->shop_id)->delete();
        Bill::where('id',$request['bill_id'])->where('shop_id',Auth::user()->shop_id)->delete();

        // return redirect()->back()->with('bill-success','Item Successfully Removed from the current Bill');
        return response()->json(['success' => true,'data' => 'Item Removed from the current Bill']);
    }
    public function FinishBill(Request $request)
    {
        $shopname = Shop::where('id',Auth::user()->shop_id)->value('shop_name');
        $address = Shop::where('id',Auth::user()->shop_id)->value('address');
        $city = Shop::where('id',Auth::user()->shop_id)->value('city');
        $contact_no = Shop::where('id',Auth::user()->shop_id)->value('contact_no');
        $customer_no = $request['customer_no'];
        $bill_no =$request['bill_no'];
        $cash_amount =$request['cash_amount'];
        $cash_credit =$request['cash_credit'];
        $bills = Bill::where('shop_id',Auth::user()->shop_id)->get();
        $products = Product::where('shop_id',Auth::user()->shop_id)->get();
        $types = ItemType::where('shop_id',Auth::user()->shop_id)->get();
        $grandtotal = Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->where('transaction_id',$bill_no)->sum('total_price');
        $dis = Bill::where('shop_id',Auth::user()->shop_id)->where('transaction_id',$bill_no)->sum('discount_amount');
        $balance = $cash_amount - $grandtotal;
        $shop = Shop::where('id',Auth::user()->shop_id)->get();
        $shopDetail = Shop::where('id',Auth::user()->shop_id)->first();

        if($grandtotal <= $cash_amount ){
            //start create customer contact
        if($customer_no){ //start check if provide customer number from form
            $new_customer = new customer();
            if(substr($customer_no,0,1) == 0){
                $saveCustomer = substr_replace($customer_no,"94",0,1);
            }else if(substr($customer_no,0,2) == 94){
                $saveCustomer = $customer_no;
            }

            //start check existing no
            if(customer::where('shop_id',Auth::user()->shop_id)->where('contact_no',$saveCustomer)->count() === 0){
                $new_customer->contact_no = $saveCustomer;
                $new_customer->shop_id = Auth::user()->shop_id;
                $new_customer->user_id = Auth::user()->id;
                $new_customer->save();
            }else{
                customer::where('shop_id',Auth::user()->shop_id)->update([ 'contact_no' => $saveCustomer ]);
            }
            //end check existing no
            if(Auth::user()->shop->notification == 1){
                // ==========send message===============
                $api_instance = new \NotifyLk\Api\SmsApi();
                $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                if($dis){
                $message = Auth::user()->shop->shop_name . "\n\nYour transaction amount is Rs.".$grandtotal."\n\n Discount Amount is Rs.".$dis."\n\nThank you for come,Please Provide us Your Valuable Comment for good service."; 
                }else{
                    $message = Auth::user()->shop->shop_name . "\n\nYour transaction amount is Rs.".$grandtotal."\n\nThank you for come,Please Provide us Your Valuable Comment for good service.";
                }
                 
                $to = $saveCustomer; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                $sender_id =Auth::user()->shop->sender_id; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
                $contact_fname = Auth::user()->shop->shop_name; // string | Contact First Name - This will be used while saving the phone number in your Notify contacts.
                $contact_lname = ""; // string | Contact Last Name - This will be used while saving the phone number in your Notify contacts.
                $contact_email = ""; // string | Contact Email Address - This will be used while saving the phone number in your Notify contacts.
                $contact_address = ""; // string | Contact Physical Address - This will be used while saving the phone number in your Notify contacts.
                $contact_group = 0; // int | A group ID to associate the saving contact with

                try {
                    $api_instance->sendSMS($user_id, $api_key, $message, $to, $sender_id, $contact_fname, $contact_lname, $contact_email, $contact_address, $contact_group);
                } catch (Exception $e) {
                    echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
                }
            // ==========end send message===============
            }
        }//end check if provide customer number from form
        //end create customer contact

        if(Auth::user()->print_type == 'invoice'){
            Bill::where('state','not-settled')
        ->where('shop_id',Auth::user()->shop_id)
        ->update(['state' => 'settled','cash_credit'=> $cash_credit,]);
            return view('Bill/print-bill',compact('bill_no','bills','products','types','grandtotal','shop'));
        }else if(Auth::user()->print_type == 'pos'){
            // $bill_data = Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->get();
            $billed_items = Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->distinct('product_id')->get();
            $itemCount = Bill::where('shop_id',Auth::user()->shop_id)->where('user_id',Auth::user()->id)->where('state','not-settled')->distinct('product_id')->count('product_id');
            $billItemArray = array();
            $data = array();
            foreach ($billed_items as $item) {
                $item_prodcut_id = $item->product_id;
                $product_name = Product::where('shop_id',Auth::user()->shop_id)
                                        ->where('user_id',Auth::user()->id)
                                        ->where('id',$item_prodcut_id)
                                        ->value('product_name');

                $company_name = Company::where('shop_id',Auth::user()->shop_id)
                                        ->where('id',$item_prodcut_id)
                                        ->value('company_name');

                $item_name = $product_name.' '.$company_name;

                $item_total_price = Bill::where('shop_id',Auth::user()->shop_id)
                                    ->where('user_id',Auth::user()->id)
                                    ->where('state','not-settled')
                                    ->where('product_id',$item_prodcut_id)
                                    ->sum('total_price');
                $item_total_qty = Bill::where('shop_id',Auth::user()->shop_id)
                                    ->where('user_id',Auth::user()->id)
                                    ->where('state','not-settled')
                                    ->where('product_id',$item_prodcut_id)
                                    ->sum('qty');
                $data['name'] = $item_name; 
                $data['qty'] = $item_total_qty; 
                $data['amount'] = $item_total_price;

                // start new edit for new billing interface
                $prod = str_split($item_name);
                $qtyd = str_split($item_total_qty);
                $priced = str_split($item_total_price);
                $item = array(56);

                for ($i=0; $i <= 56 ; $i++) { 
                    
                    if($i<35){
                        // start phase1
                        foreach ($prod as $key => $value) {
                            if($i <= $key){
                                if($i == $key){
                                    $item[$i] = $value;
                                }
                            }else{
                                $item[$i] = " "; 
                            }
                        }
                        // end phase1
                    }else if($i<42){
                        // start phase2
                        foreach ($qtyd as $key => $value) {
                            $key = $key + 35;
                            if($i <= $key){
                                if($i == $key){
                                    $item[$i] = $value;
                                }
                            }else{
                                $item[$i] = " "; 
                            }
                        }
                        // end phase2
                    }else if($i<56){
                        // start phase3
                        foreach ($priced as $key => $value) {
                            $key = $key + 42;
                            if($i <= $key){
                                if($i == $key){
                                    $item[$i] = $value;
                                }
                            }else{
                                $item[$i] = " "; 
                            }
                        }
                        // end phase3
                    }
                }
                // $receiptData = array();
                // end new edit for new billing interface

                // $billItemArray[$item_prodcut_id] = $data; 
                $billItemArray[$item_prodcut_id] = $item; 
            }

            Bill::where('state','not-settled')
            ->where('shop_id',Auth::user()->shop_id)
            ->update(['state' => 'settled', 'cash_credit' => $cash_credit,]);

            return response()->json([
                                        'success' => true,
                                        'data' => 'Item Successfully Billed',
                                        'items'=>$billItemArray,
                                        'bill_no'=> $bill_no,
                                        'address' => $address,
                                        'city' => $city,
                                        'contact_no' => $contact_no,
                                        'total' => $grandtotal,
                                        'cash' => $cash_amount,
                                        'dis' => $dis,
                                        'balance' => $balance,
                                        'shop' => $shopname,
                                    ]);
            
        }
    }else{
        return response()->json([
                                        'error' => true,
                                        'data' => 'Cash Amount does not suite for actual bill total',
                                    ]);
    }
    
    }
    public function PrintBill()
    {
        return view('Bill/print-bill');
    }
}
