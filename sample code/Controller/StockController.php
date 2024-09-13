<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DeleteProduct;
use Carbon\Carbon;
use Validator;  
use App\User;
use App\Bill;
use App\Company;
use App\ItemType;
use App\Product;
use App\Stock;
use App\DiscardItem;
use App\Batch;
use Session;

class StockController extends Controller
{
    public function testproduct()
    {
        return View('billing/test-product');
    }
    public function productJson()
    {
        $content = [];
        $itemType = ItemType::where('shop_id',Auth::user()->shop_id)->distinct()->get(); 
        foreach ($itemType as $value) {
            $products = Product::where('shop_id',Auth::user()->shop_id)->where('product_state','Active')->where('type_id',$value->id)->get();
            foreach ($products as $product){
                $content[] = array('title'=>$product->product_name.' '.$product->company->company_name,'id'=>$product->id,'selling_price' => $product->selling_price,'count_type'=>$product->stock->count_type,'type_id' => $product->type_id);
            }
        }  
        return $content;
    }

    public function cartTotal()
    {
        $total = Bill::where('shop_id',Auth::user()->shop_id)->where('state','not-settled')->where('user_id',Auth::user()->id)->sum('total_price');
        $bill_no = Bill::where('shop_id',Auth::user()->shop_id)->where('state','not-settled')->where('user_id',Auth::user()->id)->value('transaction_id');

        return array('total'=>$total,'bill_no'=>$bill_no);
    }
    public function yearcount()
    {
        $compact = [];
        $data = [];
        $itemType = ItemType::where('shop_id',Auth::user()->shop_id)->distinct()->get();
        foreach ($itemType as $value) {
            $products = Product::where('shop_id',Auth::user()->shop_id)->where('product_state','Active')->where('type_id',$value->id)->get();
            foreach ($products as $product){
                $receiveQty = Batch::where('shop_id',Auth::user()->shop_id)
                                    // ->where('expire_date','>',Carbon::now())
                                    // ->orWhere('expire_date','=',null)
                                    ->where('state','=',1)
                                    ->where('product_id',$product->id)
                                    ->sum('receive_qty');

                $soldQty = Batch::where('shop_id',Auth::user()->shop_id)
                                    // ->where('expire_date','>',Carbon::now())
                                    // ->orWhere('expire_date','=',null)
                                    ->where('state','=',1)
                                    ->where('product_id',$product->id)
                                    ->sum('sold_qty');
                $discardQty = Batch::where('shop_id',Auth::user()->shop_id)
                                    // ->where('expire_date','>',Carbon::now())
                                    // ->orWhere('expire_date','=',null)
                                    ->where('state','=',1)
                                    ->where('product_id',$product->id)
                                    ->sum('discard_qty');
                $availableQty = $receiveQty -($soldQty + $discardQty);
                $item_trigger = $product->stock_remainder;

                if($item_trigger >= $availableQty){
                    $alert = 'Stock About to end'; 
                }else{
                    $alert = 'Good to go';
                }
                $data[] =array(
                            'type_id' => $value->id,
                            'type' => $value->type,
                            'product_id' => $product->id,
                            'product' => $product->product_name,
                            'display_name' => $product->product_name.' '.$product->company->company_name,
                            'count_type'=>$product->stock->count_type,
                            'selling_price' => $product->selling_price,
                            'qty'=>$availableQty,
                            'alert'=>$alert,
                        );
            }
        }
       return $compact[] = array('type'=> $itemType,'products' => $data);
    }
    public function AddNewItem(Request $request)
    {
        // start expiredate check
        $today = Carbon::now();
        $expiresOn = Carbon::parse($request['expire_date']);
        $trigger = $today->diffInYears($expiresOn,false);

        if($trigger <= -1 || $trigger >= 10 || $today > $expiresOn){
            if($trigger <= -1 ){
                return response()->json(['error' => true,'data' => 'Cannot enter previous date']);
            }else if($trigger >= 10){
                return response()->json(['error' => true,'data' => 'Cannot Exeed 10 years from now']);
            }else{
                return response()->json(['error' => true,'data' => 'Cannot enter previous date']);
            }
        }else{
            $direction = $request['direction'];
            $row = $request['row'];
            $column = $request['column'];
            $size  = $request['size'];
            $subgroup  = $request['subgroup'];
            $product_name  = $request['product_name'];
            $item_type  = $request['item_type'];
            $count_type  = $request['count_type'];
            // --------------------------------------
            $company_name  = $request['company_name'];
            $listedCompanyId = Company::where('company_name',$company_name)->where('shop_id',Auth::user()->shop_id)->value('id');
            $listedTypeId = ItemType::where('type',$item_type)->where('shop_id',Auth::user()->shop_id)->value('id');
            $existCompany = Company::where('company_name',$company_name)->where('shop_id',Auth::user()->shop_id)->exists();
            $existType = ItemType::where('type',$item_type)->where('shop_id',Auth::user()->shop_id)->exists();
            // --------------------------------------
            $qty  = $request['qty'];
            $unit_price  = $request['unit_price'];
            $selling_price  = $request['selling_price'];
            // $expire_date  = Carbon::parse($request['expire_date']);
            // $expire_date  = Carbon::createFromFormat('d/m/Y', $request['expire_date']);
            $alert  = $request['alert'];
            $user_id = Auth::user()->id;
            $company_id_of_new_product = Company::where('company_name',$company_name)->value('id');
            if ((Product::where('product_name',$product_name.' '.$size)->where('shop_id',Auth::user()->shop_id)->where('product_state','Active')->where('company_id',$company_id_of_new_product)->count()) == 0) {
                // Create New Item Type
                if (empty($existType)) {
                    $product_type = new ItemType();
                    $product_type->type = $item_type;    
                    $product_type->user_id = Auth::user()->id;
                    $product_type->shop_id = Auth::user()->shop_id;
                    $product_type->save();
                }
            
    // Create New Company
                if (empty($existCompany)) {
                    $company = new Company();
                    $company->company_name = $company_name;  
                    $company->contact_no = $request['company_contact']; 
                    $company->address = $request['company_address'];  
                    $company->reg_no = $request['company_regno'];  
                    $company->user_id = Auth::user()->id;
                    $company->shop_id = Auth::user()->shop_id;
                    $company->save();
                }

    // Create New Product
            $product = new Product();
                if ($direction == 'e' ) {
                    $product->location_code = 'No Location Service';
                }else if($column == 'e'){
                    $product->location_code = 'No Location Service';
                }else if($row == 'e'){
                    $product->location_code = 'No Location Service';
                }else if($direction == ''){
                    $product->location_code = 'No Location Service';
                }else{
                    $product->location_code = $direction.'/'.$row.'/'.$column;
                }
            $product->product_name = $product_name.' '.$size;  
            $product->user_id = Auth::user()->id;    
            $product->shop_id = Auth::user()->shop_id;    
            $product->selling_price = $selling_price;    
            
                if (empty($existCompany)) {
                $product->company_id = DB::table('companies')->where('company_name', $company_name)->where('shop_id',Auth::user()->shop_id)->value('id');
                }else{
                $product->company_id = $listedCompanyId;
                }
                if (empty($existType)) {
                    $product->type_id = DB::table('item_types')->where('type', $item_type)->where('shop_id',Auth::user()->shop_id)->value('id');
                }else{
                    $product->type_id = $listedTypeId;
                }
            $product->stock_remainder = $alert;
            $product->save();

            // Create New Stock
            $stock_item = new Stock();
            $product_company_id = DB::table('companies')->where('company_name', $company_name)->where('shop_id',Auth::user()->shop_id)->value('id');
            $stock_item->user_id = Auth::user()->id;
            $stock_item->shop_id = Auth::user()->shop_id;
                if (empty($existType)) {
                    $stock_item->type_id = DB::table('item_types')->where('type', $item_type)->where('shop_id',Auth::user()->shop_id)->value('id');
                }else{
                    $stock_item->type_id = $listedTypeId;
                }
            $stock_item->product_id = DB::table('products')->where('product_name', $product_name.' '.$size)->where('product_state','Active')->where('company_id',$product_company_id)->where('shop_id',Auth::user()->shop_id)->value('id');
            $stock_item->count_type = $count_type;
            $stock_item->qty = $qty;
            $stock_item->unit_price = $unit_price;
            $stock_item->size = $size;
            $stock_item->sub_category = $subgroup;
                if ($request['expire_date']) {
                    $stock_item->expire_date = Carbon::parse($request['expire_date'])->format('Y-m-d');
                }
                else{
                    $stock_item->expire_date = null;
                }

            $stock_item->save();
            // ______________________________________
            $batch = new Batch();
            if (Batch::where('shop_id',Auth::user()->shop->id)->count() == 0) {
                $batchNo = 1;
            }else{
                $last = Batch::where('shop_id',Auth::user()->shop->id)->orderBy('created_at','DESC')->first();
                $batchNo = $last->batch_no + 1;
            }
            if($request['expire_date']){
                $batchExpireDate = Carbon::parse($request['expire_date']);
            }else{
                $batchExpireDate = NULL;
            }
            $productName = $product_name.' '.$size;
            $batch->batch_no = $batchNo;
            $batch->expire_date = $batchExpireDate;
            $batch->receive_qty = $qty;
            $batch->product_id = Product::where('shop_id',Auth::user()->shop->id)
                                        ->where('product_name',$productName)
                                        ->where('product_state','Active')
                                        ->where('company_id',Company::where('shop_id',Auth::user()->shop->id)->where('company_name',$company_name)->value('id'))
                                        ->value('id');
            $batch->user_id = Auth::user()->id;
            $batch->shop_id = Auth::user()->shop->id;
            $batch->stock_id = Stock::where('product_id',Product::where('product_name',$productName)->where('company_id',Company::where('shop_id',Auth::user()->shop->id)->where('company_name',$company_name)->where('shop_id',Auth::user()->shop->id)->value('id'))->value('id'))->value('id');
            $batch->save();
            // ______________________________________
            $message = 'Item Successfully Created!';
            return response()->json(['success' => true,'data' => 'New Item Add Successfull.Item <br><span class="badge badge-success">New Stock Batch NO: '.$batchNo.'</span>']);
            }//check exist product on same shop
            else{
                return response()->json(['error' => true,'data' => 'Cannot add products on same name on same conpany If you want to update existing product use "Product Update Option']);
            }
        }
        // end expiredate check
    }
    public function GetItemHistoryTest(Request $request)
    {
        if (Auth::check()) {
            $items = Stock::where('shop_id',Auth::user()->shop_id)->orderBy('created_at','DESC')->paginate(10);

            $products = Product::orderBy('product_name','DESC')->where('shop_id',Auth::user()->shop_id)->get();
            $delete_products = DeleteProduct::all();
            $itemtype = ItemType::all();
            $discard_items = DiscardItem::all();
            $avarage_sale = array();

            foreach ($products as $product) {
                $saleAVG = Bill::where('shop_id',Auth::user()->shop_id)->where('product_id',$product->id)->where('created_at','>',Carbon::now()->subDays(30))->sum('qty');
                $avg = $saleAVG/30;
                $avarage_sale[$product->id] = round($avg,2);
            }
           
            return view('stock/stock',compact('items','products','itemtype','discard_items','delete_products','avarage_sale'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function DeleteItem(Request $request)
    {
        $message = "Item Has Been Deleted";
        $delete_product_id  = $request['product_id'];
        $delete_product_quantity  = $request['product_quantity'];
        $delete_product_name = Product::where('id',$delete_product_id)->where('shop_id',Auth::user()->shop_id)->value('product_name');
        $delete_product_company_name = Company::where('id',Product::where('shop_id',Auth::user()->shop_id)->where('id',$delete_product_id)->value('company_id'))->value('company_name');
        
        $delete_product = new DeleteProduct();
        $delete_product->product_name = $delete_product_company_name.' '.$delete_product_name;
        $delete_product->user_id = Auth::user()->id;
        $delete_product->shop_id = Auth::user()->shop_id;
        $delete_product->save();
        $name = $delete_product_company_name.' '.$delete_product_name;
        $deleteProductID = DeleteProduct::where('product_name',$name)->where('shop_id',Auth::user()->shop_id)->value('id');

        Stock::where('product_id',$delete_product_id)->where('shop_id',Auth::user()->shop_id)
            ->update([
                'delete_product_id' => $deleteProductID,
                'state' => 0,
                ]);
        Batch::where('shop_id',Auth::user()->shop_id)->where('product_id',$delete_product_id)->update(['state' => 0,]);
        DiscardItem::where('product_id',$delete_product_id)->update(['delete_product_id' => $deleteProductID]);
        Bill::where('product_id',$delete_product_id)->where('shop_id',Auth::user()->shop_id)->update(['delete_product_id' => $deleteProductID]);
        Product::where('id',$delete_product_id)->where('shop_id',Auth::user()->shop_id)->update(['product_state' => 'Deleted']);
        // return redirect()->back()->with(['success' => $message]);
        return response()->json(['success' => true,'data' => $message]);
    }

    public function UpdateProduct(Request $request)
    {    
        $message = "Item Successfully Updated";
        $update_product_id = $request['update_product_id'];

        $updateProduct = Stock::where('product_id',$update_product_id)->where('shop_id',Auth::user()->shop_id)->first();

        $new_stock_entry = new Stock();
        $new_stock_entry->user_id = Auth::user()->id;
        $new_stock_entry->shop_id = Auth::user()->shop_id;
        $new_stock_entry->type_id = $updateProduct->type_id;
        $new_stock_entry->product_id = $updateProduct->product_id;
        $new_stock_entry->count_type = $updateProduct->count_type;
        $new_stock_entry->qty = $request['qty'];
        $new_stock_entry->unit_price = $request['unit_price'] ;
        $new_stock_entry->remark = 'Updated' ;
        if ($request['update_item_expireDate']) {
            $expireDateUpdated = Carbon::parse($request['update_item_expireDate']);
        }
        else{
            $expireDateUpdated = NULL;
        }
        $new_stock_entry->expire_date = $expireDateUpdated;
        $new_stock_entry->save();
        // ______________________________________
        $batch = new Batch();
        if (Batch::where('shop_id',Auth::user()->shop->id)->count() == 0) {
            $batchNo = 1;
        }else{
            $last = Batch::where('shop_id',Auth::user()->shop->id)->orderBy('created_at','DESC')->first();
            $batchNo = $last->batch_no + 1;
        }
        if($request['update_item_expireDate']){
            $batchExpireDate = Carbon::parse($request['update_item_expireDate']);
        }else{
            $batchExpireDate = NULL;
        }
        $stockIdForBatch = Stock::where('product_id',$update_product_id)
                                ->where('shop_id',Auth::user()->shop->id)
                                ->where('expire_date',$expireDateUpdated)
                                ->orderBy('created_at', 'desc')
                                ->first();
        $batch->batch_no = $batchNo;
        $batch->expire_date = $batchExpireDate;
        $batch->receive_qty = $request['qty'];
        $batch->product_id = $update_product_id;
        $batch->user_id = Auth::user()->id;
        $batch->shop_id = Auth::user()->shop->id;
        $batch->stock_id = $stockIdForBatch->id;
        $batch->save();
        // ______________________________________
         return response()->json(['success' => true,'data' => 'Item Successfully Updated,<br><span class="badge badge-success">New Stock Batch NO: '.$batchNo.'</span>']);
    }
    public function EditProduct(Request $request)
    {   
        $direction = $request['direction'];
        $row = $request['row'];
        $column = $request['column'];

        $message = 'Product Successfully Edited';
        $edit_product_id = $request['product_id'];
        $location_code = $request['direction'].'/'.$request['row'].'/'.$request['column'];
        $edit_product_name = $request['product_name'];
        $edit_product_count_type = $request['count_type'];
        $edit_item_type = $request['item_type'];
        $edit_item_type_id = $request['product_type_id'];
        $edit_product_selling_price = $request['selling_price'];
        $edit_product_company_name = $request['company_name'];
        $edit_product_remainder = $request['alert'];
        
        // location_code
        if ($location_code != Product::where('id',$edit_product_id)->where('shop_id',Auth::user()->shop_id)->value('location_code'))
        {
            if ($direction == 'e' ) {
                $new_location_code = 'No Location Service';
            }else if($row == 'e'){
                $new_location_code = 'No Location Service';
            }else if($column == 'e'){
                $new_location_code = 'No Location Service';
            }else{
                $new_location_code = $direction.'/'.$row.'/'.$column;
            }
            // $new_location_code = $location_code;
        }else{
                $new_location_code = Product::where('id',$edit_product_id)->where('shop_id',Auth::user()->shop_id)->value('location_code');
            }

        // item type id
        if ($edit_item_type !== ItemType::where('id',$edit_item_type_id)->where('shop_id',Auth::user()->shop_id)->value('type') ) 
        {
           if((ItemType::where('type',$edit_item_type)->where('shop_id',Auth::user()->shop_id)->value('type'))>0)
           {
                $edit_item_type_id = ItemType::where('type',$edit_item_type)->where('shop_id',Auth::user()->shop_id)->value('id');
           }
            else
            {
                $new_Item_type = new ItemType();
                $new_Item_type->type = $edit_item_type;
                $new_Item_type->user_id = Auth::user()->id;
                $new_Item_type->shop_id = Auth::user()->shop_id;
                $new_Item_type->save();

                $edit_item_type_id = ItemType::where('type',$edit_item_type)->where('shop_id',Auth::user()->shop_id)->value('id');
            }
        }

        // updation
        Product::where('id',$edit_product_id)->where('shop_id',Auth::user()->shop_id)->where('product_state','Active')
                    ->update([
                            'location_code' => $new_location_code,
                            'product_name' => $edit_product_name,
                            'selling_price' => $edit_product_selling_price,
                            'type_id' => $edit_item_type_id,
                            'stock_remainder' => $edit_product_remainder,
                        ]);
        Stock::where('product_id',$edit_product_id)->where('shop_id',Auth::user()->shop_id)->where('state',1)
                    ->update([
                            'count_type' => $edit_product_count_type,
                            'type_id' => $edit_item_type_id,
                        ]);
         return response()->json(['success' => true,'data' => $message]);
        // return redirect()->back()->with(['success' => $message]);
    }
    public function GetItemDiscard(Request $request)
    {
        $discard_product_id = $request['discard_product_id'];
        $discard_quantity   = ($request['qty'])*(-1);
        $discard_batch_no   = $request['batch_no'];
        $reason_for_discard = $request['reason'];
        $expire_date = Batch::where('batch_no',$discard_batch_no)->value('expire_date');
        $unit_price = $request['discard_item_unit_price'];

            $receiveQty = Batch::where('batch_no',$discard_batch_no)->where('product_id',$discard_product_id)->where('shop_id',Auth::user()->shop_id)->value('receive_qty');
            $soldQty = Batch::where('batch_no',$discard_batch_no)->where('product_id',$discard_product_id)->where('shop_id',Auth::user()->shop_id)->value('sold_qty');
            $discardQty = Batch::where('batch_no',$discard_batch_no)->where('product_id',$discard_product_id)->where('shop_id',Auth::user()->shop_id)->value('discard_qty');
            
            $availableQty = $receiveQty -($soldQty+$discardQty);
        $current_qty = Stock::where('id',Batch::where('batch_no',$discard_batch_no)->value('stock_id'))->first();
        if($discard_product_id){
            if($current_qty != null){
                   if($request['qty'] <= $availableQty){
                         // create new discard item
                        $new_discard_item = new DiscardItem();
                        $new_discard_item->reason = $reason_for_discard;
                        $new_discard_item->count_type = $current_qty->count_type;
                        $new_discard_item->quantity = $discard_quantity;
                        $new_discard_item->user_id = Auth::user()->id;
                        $new_discard_item->shop_id = Auth::user()->shop_id;
                        $new_discard_item->product_id = $discard_product_id;
                        $new_discard_item->batch_no = $discard_batch_no;
                        $new_discard_item->state = 'Not Approved';
                        $new_discard_item->save();


                        $new_stock_entry = new Stock();

                        $new_stock_entry->user_id = Auth::user()->id;
                        $new_stock_entry->shop_id = Auth::user()->shop_id;
                        $new_stock_entry->type_id = $current_qty->type_id;
                        $new_stock_entry->product_id = $current_qty->product_id;
                        $new_stock_entry->count_type = $current_qty->count_type;
                        $new_stock_entry->qty = $discard_quantity;
                        $new_stock_entry->unit_price = $current_qty->unit_price ;
                        $new_stock_entry->remark = 'Discarded Items';
                        if ($request['discard_item_expireDate']) {
                            $new_stock_entry->expire_date = Carbon::parse($request['discard_item_expireDate']);
                        }
                        else{
                            $new_stock_entry->expire_date = null;
                        }
                        $new_stock_entry->save();
                        $discardAmountToUpdate = $discardQty + $request['qty'];
                        Batch::where('batch_no',$discard_batch_no)
                                ->where('shop_id',Auth::user()->shop_id)
                                ->update([ 'discard_qty' => $discardAmountToUpdate, ]);

                        $message = $discard_quantity.' Items has been Discarded because of '.$reason_for_discard;

                        // return redirect()->back()->with(['success' => $message]);
                        return response()->json(['success' => true,'data' => $message]);
                   }else{
                        return response()->json(['error' => true,'data' => 'exceed discard quantity related to available batch Quantity']);
                   }
                }else{
                    return response()->json(['error' => true,'data' => 'Stock Empty related to this batch no']);   
                }
        }else{
            return response()->json(['error' => true,'data' => 'No Product Id Found']);
        }   
    }
    public function GetItemDiscardApprove(Request $request)
    {
        $discard_stock_id = $request['approve_id'];
        $disapprove_state = $request['disapprove_state'];

        if($disapprove_state == 0){
            DiscardItem::where('id',$discard_stock_id)
                    ->where('shop_id',Auth::user()->shop_id)
                    ->update([
                            'state' => 'Approved',
                            'approved_user' => Auth::user()->id,
                        ]);
            return response()->json(['success' => true,'data' => 'Item Approved Successfull']);
        }else if($disapprove_state == 1){
            
            $discard_Item_Data = DiscardItem::where('shop_id',Auth::user()->shop_id)->where('id',$discard_stock_id)->first();
            $batch_data = Batch::where('batch_no',$discard_Item_Data->batch_no)->where('shop_id',Auth::user()->shop_id)->first();
            $prevDiscardQty = $batch_data->discard_qty;
            $new_btch_qty = $prevDiscardQty + $discard_Item_Data->quantity;

            if($batch_data->state == 0){
                Batch::where('batch_no',$discard_Item_Data->batch_no)->where('shop_id',Auth::user()->shop_id)->update([
                    'state' => 1,
                    'discard_qty' => $new_btch_qty,
                ]);
            }else{
                Batch::where('batch_no',$discard_Item_Data->batch_no)->where('shop_id',Auth::user()->shop_id)->update([
                    'state' => 1,
                    'discard_qty' => $new_btch_qty,
                ]);
            }

            $product = Product::where('id',$discard_Item_Data->product_id)->where('shop_id',Auth::user()->shop_id)->first();

            $new_stock_entry = new Stock();

            $new_stock_entry->user_id = Auth::user()->id;
            $new_stock_entry->shop_id = Auth::user()->shop_id;
            $new_stock_entry->type_id = $product->type_id;
            $new_stock_entry->product_id = $product->id;
            $new_stock_entry->count_type = $product->stock->count_type;
            $new_stock_entry->qty = ($discard_Item_Data->quantity)*(-1);
            $new_stock_entry->unit_price = $product->stock->unit_price ;
            $new_stock_entry->remark = 'Newly Added';
            $new_stock_entry->expire_date = $product->stock->expire_date;
            $new_stock_entry->save();

            DiscardItem::where('id',$discard_stock_id)
                    ->where('shop_id',Auth::user()->shop_id)
                    ->update([
                            'state' => 'Rejected',
                            'approved_user' => Auth::user()->id,
                        ]);
            return response()->json(['success' => true,'data' => 'Item Restored Successfull']);
        }
    }
}
