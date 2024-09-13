<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Payment;
use App\Shop;
use Image;
use Carbon\Carbon;

// start sms api details
use \NotifyLk\Configuration;
use \NotifyLk\ApiClient;
use \NotifyLk\ApiException;
use \NotifyLk\ObjectSerializer;
use App\SmsApi;
// end sms api details

class PaymentController extends Controller
{
    public function GetPaymentPrices()
    {   
        if (Auth::check()) {
            return view('Payment/payment-prices');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function GetPayment()
    {	
    	if (Auth::check()) {
    		if(Auth::user()->shop->payment_plan !='demo'){
                $payments = Payment::orderBy('created_at','DESC')->take(10)->get();
                $shops = Shop::all();
                return view('Payment/payment',compact('payments','shops'));
            }else{
                return redirect()->back()->with('error','Please Select Payment Plan from profile page');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function PostPayment(Request $request)
    {	
    	if (Auth::check()){
    		$name = $request['name'];
    		$contact = $request['contact'];
            $amount = $request['paid_amount'];
            $pay_for = $request['payment_duration'];
            $payment_plan = $request['payment_plan'];
            $monthly_rate = $request['monthly_rate'];
    		$request_sender_id = $request['request_sender_id'];
            
    		$voucher = $request->file('voucher');
    		$filename = time().'.'. $voucher->getClientOriginalExtension();
    		Image::make($voucher)->insert('watermark/watermark.png')->save(public_path('/payment/'.$filename));
    		Image::make($voucher)->save(public_path('/payment/'.$filename));

    		$payment = new Payment();
    		$payment->customer_name = $name;
    		$payment->user_id = Auth::user()->id;
    		$payment->shop_id = Auth::user()->shop_id;
    		$payment->type = "Bank";
            if($request['due_payment']){
                $payment->state = "Due_Payment";
            }else{
                $payment->state = "Pending";
            }
            if($pay_for){
                switch ($pay_for) {
                    case '1M':
                        $payment->pay_for = "One Month";
                        break;

                    case '3M':
                        $payment->pay_for = "Three Month";
                        break;

                    case '6M':
                        $payment->pay_for = "Six Month";
                        break;

                    case '1Y':
                        $payment->pay_for = "One Year";
                        break;

                    case '5Y':
                        $payment->pay_for = "Five Year";
                        break;
                    case 'sender_id':
                        $payment->pay_for = "Request Sender ID";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            $payment->voucher = $filename;
            if($monthly_rate){
                $payment->monthly_rate = $monthly_rate;
            }

            if($contact){
                if(substr($contact,0,1) == 0){
                    $sender_no = substr_replace($contact,"94",0,1);
                }else if(substr($contact,0,2) == 94){
                    $sender_no = $contact;
                }
                $payment->contact = $sender_no;
            }
            if($request_sender_id){
                $payment->other = $request_sender_id;
            }
    		$payment->amount = $amount;

            if (Shop::where('id',Auth::user()->shop_id)->value('payment_plan') == 'demo' ) {
                // if($payment_plan){
                    $thisMonth = Carbon::now()->month;
                    if($payment_plan == 'advance'){
                        Shop::where('id',Auth::user()->shop_id)->update([ 'payment_plan' => $payment_plan, 'bulk' => 1,'bulk_month' => $thisMonth]);
                    }else if($payment_plan == 'economy'){
                        Shop::where('id',Auth::user()->shop_id)->update([ 'payment_plan' => $payment_plan, 'bulk' => 1, 'bulk_month' => $thisMonth]);
                    }else if($payment_plan == 'starter'){
                        Shop::where('id',Auth::user()->shop_id)->update([ 'payment_plan' => $payment_plan,]);
                    }
                // }
                if($monthly_rate){
                    Shop::where('id',Auth::user()->shop_id)->update([ 'monthly_rate' => $monthly_rate]);
                }
            }else if(Shop::where('id',Auth::user()->shop_id)->value('payment_plan') != $payment_plan ){
                $payment->change = $payment_plan;
                $payment->remark = "Request to change Payment plan to ".$payment_plan;
            }
            if(Payment::where('shop_id',Auth::user()->shop->id)->value('state') == 'Due_Payment'){
                @unlink('payment/'.$filename);
                return redirect()->back()->with('code_error','You already made a payment,Please wait untill it confirm,For more help contact customer support');
            }else{
                if($sender_no){
                    $payment->save();
                    // ==========send message===============
                    $api_instance = new \NotifyLk\Api\SmsApi();
                    $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                    $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                    $message ="Hi ".strtoupper($name)."\n\nThank for your payment.We'll get back to you as soon as it possible after confirm your payment,At the mean time if you want any assistance Please contact us"; 
                    $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                    $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
                    $contact_fname = Auth::user()->shop->shop_name; // string | Contact First Name - This will be used while saving the phone number in your Notify contacts.
                    $contact_lname = ""; // string | Contact Last Name - This will be used while saving the phone number in your Notify contacts.
                    $contact_email = ""; // string | Contact Email Address - This will be used while saving the phone number in your Notify contacts.
                    $contact_address = ""; // string | Contact Physical Address - This will be used while saving the phone number in your Notify contacts.
                    $contact_group = 0; // int | A group ID to associate the saving contact with

                    try {
                        $api_instance->sendSMS($user_id, $api_key, $message, $to, $sender_id, $contact_fname, $contact_lname, $contact_email, $contact_address, $contact_group);
                    } 
                    catch (Exception $e) {
                        echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
                    }
                    // ==========end send message=============== 
                    return redirect()->back()->with('success','Payment Updated successfull,This sent for aprove');
                }
                $payment->save();
                return redirect()->back()->with('success','Payment Updated successfull,This sent for aprove');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function ApprovePayment(Request $request)
    {	
    	if (Auth::check()) {
            $payment_id = $request['payment_id'];
    		$shop_id = $request['shop_id'];
    		$state = $request['state'];
            $remark = $request['remark'];
            $payment_duration = $request['payment_duration'];
            $senderidduration = $request['senderId'];
    		$due_payment_duration = $request['due_payment_duration'];
            $change_payment_plan = Payment::where('id',$payment_id)->value('change');
            $current_payment_plan = Shop::where('id',$shop_id)->value('payment_plan');
            $previous_payment_expire_date = Shop::where('id',$shop_id)->value('expire_date');
            
            if($senderidduration){
                $payment_duration = $senderidduration;
            }
            if ($payment_duration || $due_payment_duration ) {

                switch ($payment_duration) {
                    case '1M':
                        $new_expire_date = Carbon::parse(Shop::where('id',$shop_id)->value('expire_date'))->addMonths(1);
                        break;

                    case '3M':
                        $new_expire_date = Carbon::parse(Shop::where('id',$shop_id)->value('expire_date'))->addMonths(3);
                        break;

                    case '6M':
                        $new_expire_date = Carbon::parse(Shop::where('id',$shop_id)->value('expire_date'))->addMonths(6);
                        break;

                    case '1Y':
                        $new_expire_date = Carbon::parse(Shop::where('id',$shop_id)->value('expire_date'))->addYears(1);
                        break;

                    case '5Y':
                        $new_expire_date = Carbon::parse(Shop::where('id',$shop_id)->value('expire_date'))->addYears(5);
                        break;
                    case 'sender_id':
                        $new_expire_date = Carbon::parse(Shop::where('id',$shop_id)->value('expire_date'));
                        break;
                    
                    default:
                        if(Carbon::now() < Carbon::parse($due_payment_duration)){
                            $date = Carbon::parse(Carbon::now())->diffInDays($due_payment_duration);
                            $new_expire_date = Carbon::parse(Auth::user()->shop->expire_date)->addDays($date);

                        }
                        break;
                }
                $sender_no = Payment::where('id',$payment_id)->value('contact');
                if($state == 'Rejected' ){
                  Payment::where('id',$payment_id)
                    ->update([
                        'state' => $state,
                        'remark' => $remark,
                        'change' => 'Payment Rejected',
                    ]);
                    // ---------------------------------------------------
                    if($sender_no){
                        // ==========send message===============
                        $api_instance = new \NotifyLk\Api\SmsApi();
                        $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                        $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                        $message ="Hi ".strtoupper( Payment::where('id',$payment_id)->value('customer_name'))."\n\n We're Sorry to inform that your payment has been rejected,For more details visit your profile or contact us"; 
                        $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                        $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
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
                    // ---------------------------------------------------

                }else if( $state == 'Accepted' ){
                    if ($due_payment_duration) {
                        Payment::where('id',$payment_id)
                            ->update([
                                'state' => $state,
                                'aproved_by' => Auth::user()->id,
                                'remark' => $remark."new Expire Date ".$new_expire_date,
                                'change' => 'Payment Updated to'.$new_expire_date.' from'.$previous_payment_expire_date.' Requested for '.$due_payment_duration,
                            ]);
                        // // ---------------------------------------------------
                        // if($sender_no){
                        //     // ==========send message===============
                        //     $api_instance = new \NotifyLk\Api\SmsApi();
                        //     $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                        //     $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                        //     $message ="Hi ".strtoupper( Payment::where('id',$payment_id)->value('customer_name'))."\n\n We're Happy to inform that your payment has been Accepted,For more details visit your profile or contact us"; 
                        //     $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                        //     $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
                        //     $contact_fname = Auth::user()->shop->shop_name; // string | Contact First Name - This will be used while saving the phone number in your Notify contacts.
                        //     $contact_lname = ""; // string | Contact Last Name - This will be used while saving the phone number in your Notify contacts.
                        //     $contact_email = ""; // string | Contact Email Address - This will be used while saving the phone number in your Notify contacts.
                        //     $contact_address = ""; // string | Contact Physical Address - This will be used while saving the phone number in your Notify contacts.
                        //     $contact_group = 0; // int | A group ID to associate the saving contact with

                        //     try {
                        //         $api_instance->sendSMS($user_id, $api_key, $message, $to, $sender_id, $contact_fname, $contact_lname, $contact_email, $contact_address, $contact_group);
                        //     } catch (Exception $e) {
                        //         echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
                        //     }
                        //     // ==========end send message=============== 
                        // }
                        // // ---------------------------------------------------
                    }else if($payment_duration){
                        if($payment_duration != 'sender_id'){
                            Payment::where('id',$payment_id)
                            ->update([
                                'state' => $state,
                                'aproved_by' => Auth::user()->id,
                                'remark' => $remark."new Expire Date ".$new_expire_date,
                                'change' => 'Payment Updated to'.$new_expire_date.' from'.$previous_payment_expire_date.' Requested for '.$payment_duration,
                            ]);
                        }else if($payment_duration === 'sender_id'){
                            Payment::where('id',$payment_id)
                            ->update([
                                'state' => $state,
                                'aproved_by' => Auth::user()->id,
                                'remark' => $remark,
                                'change' => 'Approve Sender ID Payment',
                            ]);
                            Shop::where('id',$shop_id)->update([ 'sender_id' => Payment::where('id',$payment_id)->value('other') ]);
                        }
                    }
                    Shop::where('id',$shop_id)->update([ 'expire_date' => $new_expire_date ]);
                        // ---------------------------------------------------
                            if($sender_no){
                                // ==========send message===============
                                $api_instance = new \NotifyLk\Api\SmsApi();
                                $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                                $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                                $message ="Hi ".strtoupper( Payment::where('id',$payment_id)->value('customer_name'))."\n\n We're Happy to inform that your payment has been Accepted,For more details visit your profile or contact us"; 
                                $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                                $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
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
                            // ---------------------------------------------------
                    if (Shop::where('id',$shop_id)->value('payment_plan') != 'demo'){
                        if (isset($change_payment_plan) && $change_payment_plan != $current_payment_plan ) {
                         Shop::where('id',$shop_id)->update([ 'payment_plan' => $change_payment_plan ]);
                            Payment::where('id',$payment_id)
                                ->update([
                                    'change' => 'Change Payment Plan to '.$change_payment_plan.' from '.$current_payment_plan.',And Payment Updated to'.$new_expire_date.' from'.$previous_payment_expire_date,
                                ]); 
                            // ---------------------------------------------------
                            if($sender_no){
                                // ==========send message===============
                                $api_instance = new \NotifyLk\Api\SmsApi();
                                $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                                $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                                $message ="Hi ".strtoupper( Payment::where('id',$payment_id)->value('customer_name'))."\n\n We're Happy to inform that your payment has been Accepted,For more details visit your profile or contact us"; 
                                $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                                $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
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
                            // ---------------------------------------------------  
                        }
                    }
                }
            }

            return redirect()->back()->with('success','Payment Accepted successfull');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function DeletePayment(Request $request)
    {	
    	if (Auth::check()) {
    		$payment_id = $request['delete_id'];
    		@unlink('payment/'.Payment::where('id',$payment_id)->value('voucher'));
    		Payment::where('id',$payment_id)->delete();

            return redirect()->back()->with('success','Payment Deleted');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
}
