<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Shop;
use App\Rate;
use App\ItemType;
use App\DiscardItem;
use App\Product;
use App\Stock;
use App\Expence;
use App\customer;
use App\Batch;
use App\Bill;
use App\Payment;
use App\User;
use App\RoomRate;
use App\Reservation;
use App\ReservationPayment;
use App\TravelAgent;
use App\GuestDetail;
use App\Booking;
use App\Room;
use App\Country;
use App\Attachment;

class DataFlowController extends Controller
{
    public function GetShops()
    {
        if (Auth::check()) {
            return Datatables::of(Shop::query())
            ->setRowId(function ($shop) {
                    return $shop->id;
                })
            ->editColumn('created_at',function(Shop $shop){
                return $shop->created_at->diffForHumans();
            })
            ->addColumn(
            'intro',
            '<button  class="mb-2 btn btn-sm btn-outline-light mr-1 actionModel"><i class="material-icons" style="font-size:20px;color:green;">add_circle</i></button>')
            ->addColumn('avarage_transaction_count',function($shop){
                $today = Carbon::now()->subDays(30);
                return Bill::where('shop_id',$shop->id)->where('created_at','>',$today)->distinct('transaction_id')->count();
            })
            ->addColumn('avarage_customer_count',function($shop){
                $today = Carbon::now()->subDays(180)->toDateString();
                return customer::where('shop_id',$shop->id)->where('updated_at','>',$today)->distinct('contact_no')->count();
            })
            ->addColumn('expire_state',function($shop){
                if($shop->expire_date > Carbon::now()){
                    return '<span class="badge badge-success">Active</span>';
                }else{
                    return '<span class="badge badge-danger">Expired</span>';
                }
            })
            ->addColumn(
            'users',
            '<button class="mb-2 btn btn-sm btn-outline-light mr-1 usersModel"><i class="material-icons" style="font-size:20px;color:blue;">group</i></button>')
            ->rawColumns(['users','intro','expire_state'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    
    public function rateData()
    {
      if (Auth::user()->role === 'super_admin') {
            $data = Rate::all();
            return $data;
        }else{
            return redirect()->back();
        }
    }

    public function GetCustomer()
    {
        if (Auth::check()) {
        
        $today = Carbon::now()->subDays(180)->toDateString();
        if(Auth::user()->role === 'super_admin'){
            $customers = Shop::distinct('contact_no')->get();
            return Datatables::of($customers)
            ->setRowId(function ($customer) {
                    return $customer->id;
                })
            ->editColumn('created_at',function($customer){
                return $customer->created_at->diffForHumans();
            })
            ->addColumn(
            'action',
            '<span>No Action</span>')
            ->rawColumns(['action'])
            ->make(true);

        }else{
          $customers = customer::where('shop_id',Auth::user()->shop_id)->where('created_at','>', $today)->distinct('contact_no')->get();
            return Datatables::of($customers)
            ->setRowId(function ($customer) {
                    return $customer->id;
                })
            ->editColumn('created_at',function($customer){
                return $customer->created_at->diffForHumans();
            })
            ->addColumn(
            'action',
            '<button class="mb-2 btn btn-sm btn-outline-danger mr-1">Delete</button>')
            ->rawColumns(['action'])
            ->make(true);  
        }
          
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function GetPaymentData()
    {
    	if (Auth::check()) {
            
            $payment = Payment::all();
            return Datatables::of($payment)
            ->setRowId(function ($payment) {
				    return $payment->id;
				})
            ->editColumn('created_at',function($payment){
                return $payment->created_at->diffForHumans();
            })
            ->editColumn('aproved_by',function($payment){
            	return User::where('id',$payment->aproved_by)->value('username');
            })
            ->addColumn('action',function($payment){
                if($payment->state == 'Rejected'){
                    return '<button class="mb-2 btn btn-sm btn-outline-danger mr-1 paymentDelete">Delete</button>';
                }else if($payment->state == 'Accepted'){
                    return '';
                }
                else{
                    return '<button class="mb-2 btn btn-sm btn-outline-info mr-1 paymentConfirmModel" data-toggle="modal" data-target="#paymentConfirmModel">Make Approve</button>';
                }
            })
            ->addColumn('shop_name',function($payment){
                return Shop::where('id',$payment->shop_id)->value('shop_name');
            })
            ->addColumn('connection_end',function($payment){
                $date =  Shop::where('id',$payment->shop_id)->value('expire_date');
                return $date;
            })
            ->addColumn('payment_plan',function($payment){
                $date =  Shop::where('id',$payment->shop_id)->value('payment_plan');
                return $date;
            })
            ->rawColumns(['action','voucher'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetProductStockData()
    {
        if (Auth::check()) {
            $stockData = Stock::where('shop_id',Auth::user()->shop_id)->where('remark','!=','Newly Added')->where('remark','!=','Updated')->get();
            return Datatables::of($stockData)
            ->setRowId(function($stock){
                return $stock->id;
            })
            ->addColumn('product_name',function($stock){
                if($stock->product_id){
                    $company = $stock->product->company->company_name;
                    $product = $stock->product->product_name;
                    $item_name = $company.' '.$product;
                    return $item_name;
                }else{
                    return 'Delete Stock Record ID '.$stock->delete_product_id;
                }
            })
            ->addColumn('location_code',function($stock){
                if($stock->product_id){
                    return $stock->product->location_code;
                }else{
                    return 'this item deleted';
                }
            })
            ->editColumn('remark',function($stock){
                if($stock->state == 0){
                    return $stock->remark.'(Deleted Item)';
                }else{
                    return $stock->remark;
                }
            })
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetDiscardProductData()
    {
        if (Auth::check()) {
            $discardItemData = DiscardItem::where('shop_id',Auth::user()->shop_id)->where('delete_product_id',null)->get();
            return Datatables::of($discardItemData)
            ->setRowId(function($item){
                return $item->id;
            })
            ->addColumn('product_name',function($item){

                return Product::where('shop_id',Auth::user()->shop_id)->where('id',$item->product_id)->value('product_name');
            })
            ->addColumn('action',function($item){
                if($item->state == 'Not Approved'){
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-outline-success approveItem"><i class="fa fa-check" style="color:green;" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-outline-danger disApproveItem"><i class="fa fa-close" style="color:red;" aria-hidden="true"></i></button>
                          </div>';
                }else if($item->state == 'Approved'){
                    return '<span class="badge badge-success">Approved</span>';
                }else if($item->state == 'Rejected'){
                    return '<span class="badge badge-danger">Rejected</span>';
                }
            })
           ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function GetCurrentProductData()
    {
        if(Auth::check()){
            $product = Product::where('shop_id',Auth::user()->shop_id)->where('product_state','Active')->get();
            return Datatables::of($product)
            ->setRowId(function($product){
                return $product->id;
            })
            ->editColumn('product_name',function($product){
                return $product->product_name.'('.$product->company->company_name.')';
            })
            ->addColumn('productName',function($product){
                return $product->product_name;
            })
            ->addColumn('company_name',function($product){
                return $product->company->company_name;
            })
            ->addColumn('type_name',function($product){
                return ItemType::where('id',$product->type_id)->value('type');
            })
            ->addColumn('count_type',function($product){
                return $product->stock->count_type;
            })
            ->editColumn('updated_at',function($product){
               return $product->updated_at->diffForHumans();
            })
            ->addColumn('current_qty',function($product){
                $received = Batch::where('shop_id',Auth::user()->shop_id)->where('product_id',$product->id)->where('state',1)->sum('receive_qty');
                $sold = Batch::where('shop_id',Auth::user()->shop_id)->where('product_id',$product->id)->where('state',1)->sum('sold_qty');
                $discard = Batch::where('shop_id',Auth::user()->shop_id)->where('product_id',$product->id)->where('state',1)->sum('discard_qty');
                $qty_remain = $received - ($sold + $discard);
                return $qty_remain;
            })
            ->addColumn('direction',function($product){
                $lcode = $product->location_code;
                $array = explode('/', $lcode);

                if(count(explode('/', $lcode)) == 1){
                    return 'e';
                }else{
                    return $array[0];
                }
            })
            ->addColumn('row',function($product){
                $lcode = $product->location_code;
                $array = explode('/', $lcode);

                if(count(explode('/', $lcode)) == 1){
                    return 'e';
                }else{
                    return $array[1];
                }
            })
            ->addColumn('column',function($product){
                $lcode = $product->location_code;
                $array = explode('/', $lcode);

                if(count(explode('/', $lcode)) == 1){
                    return 'e';
                }else{
                    return $array[2];
                }
            })
            ->addColumn('avarage_sale',function($product){
               $sold_qty_of_this_month = Bill::where('product_id',$product->id)->whereMonth('created_at','=',Carbon::now()->month)->sum('qty');
               $days_of_this_month = Carbon::now()->daysInMonth;

               $avarage = ($sold_qty_of_this_month)/$days_of_this_month;
               return sprintf('%0.2f', $avarage);
            })
            ->addColumn(
            'action',
            '<div class="ui icon buttons">
                <button class="mini ui inverted green button updateItemModel" data-toggle="modal" data-target="#updateItem">
                    <i class="plus icon"></i>
                  </button>
                  <button class="mini ui inverted blue button editItemModel" data-toggle="modal" data-target="#editItem">
                    <i class="edit icon"></i>
                  </button>
                  <button class="mini ui inverted yellow button discardItemModel" data-toggle="modal" data-target="#discardItem">
                    <i class="trash alternate icon"></i>
                  </button>
                  <button class="mini ui inverted red button deleteItemModel" data-toggle="modal" data-target="#deleteItem">
                    <i class="times icon"></i>
                  </button>
                </div>')
            ->rawColumns(['action'])
            ->make(true);
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }   
    }
    public function GetExpenceData()
    {
    	if (Auth::check()) {
    		$expenceData = Expence::where('shop_id',Auth::user()->shop_id)->orderBy('created_at','ASC')->get();
            return Datatables::of($expenceData)
            ->setRowId(function($expence){
            	return $expence->id;
            })
            ->addColumn(
            'intro',
            '<button class="mb-2 btn btn-sm btn-outline-danger mr-1">Delete</button>')
            ->rawColumns(['intro'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetCashCreditData()
    {
        if (Auth::check()) {
            $dates = [];
            $cash = [];
            $credit = [];
            $void_cash = [];
            $void_credit = [];
            $credit_discount = [];
            $cash_discount = [];

            $data = [];
            $period = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());
            foreach ($period as $date) {
                $cashAmount = Bill::where('shop_id',Auth::user()->shop_id)->where('created_at','LIKE',Carbon::parse($date)->format('Y-m-d').'%')->where('cash_credit','cash')->where('state','settled')->sum('total_price');
                $creditAmount = Bill::where('shop_id',Auth::user()->shop_id)->where('created_at','LIKE',Carbon::parse($date)->format('Y-m-d').'%')->where('cash_credit','credit')->where('state','settled')->sum('total_price');
                $void_creditAmount = Bill::where('shop_id',Auth::user()->shop_id)->where('created_at','LIKE',Carbon::parse($date)->format('Y-m-d').'%')->where('cash_credit','credit')->where('state','void')->sum('total_price');
                $void_cashAmount = Bill::where('shop_id',Auth::user()->shop_id)->where('created_at','LIKE',Carbon::parse($date)->format('Y-m-d').'%')->where('cash_credit','cash')->where('state','void')->sum('total_price');
                $totalCashDiscount = Bill::where('shop_id',Auth::user()->shop_id)->where('created_at','LIKE',Carbon::parse($date)->format('Y-m-d').'%')->where('cash_credit','cash')->where('state','settled')->sum('discount_amount');
                $totalCreditDiscount = Bill::where('shop_id',Auth::user()->shop_id)->where('created_at','LIKE',Carbon::parse($date)->format('Y-m-d').'%')->where('cash_credit','credit')->where('state','settled')->sum('discount_amount');
                
                $cash[$date->format('Y-m-d')] = $cashAmount;
                $credit[$date->format('Y-m-d')] = $creditAmount;
                $void_credit[$date->format('Y-m-d')] = $void_creditAmount;
                $void_cash[$date->format('Y-m-d')] = $void_cashAmount;
                $cash_discount[$date->format('Y-m-d')] = $totalCashDiscount;
                $credit_discount[$date->format('Y-m-d')] = $totalCreditDiscount;
            }
            // return $credit;

            foreach ($period as $value) {
                $data[] = array(
                        'date' => $value->format('Y-m-d'),
                        'credit' => $credit[$value->format('Y-m-d')],
                        'cash' => $cash[$value->format('Y-m-d')],
                        'void_cash' => $void_cash[$value->format('Y-m-d')],
                        'void_credit' => $void_credit[$value->format('Y-m-d')],
                        'cash_discount' => $cash_discount[$value->format('Y-m-d')],
                        'credit_discount' => $credit_discount[$value->format('Y-m-d')],
                        'total' => $credit[$value->format('Y-m-d')] + $cash[$value->format('Y-m-d')],
                );   
            }
            return Datatables::of($data)->make(true);
            // return $data;
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetVoidBillData()
    {
        if (Auth::check()) {
            $voidData = Bill::where('shop_id',Auth::user()->shop_id)->where('state','void')->orderBy('created_at','DESC')->get();
            return Datatables::of($voidData)
            ->setRowId(function($bill){
                return $bill->id;
            })
            ->editColumn('product_id',function($voidbill){
                return $voidbill->Product->company->company_name.' '.$voidbill->Product->product_name.' '.$voidbill->Product->stock->size;
            })
            ->editColumn('user_id',function($voidbill){
                return User::where('id',$voidbill->user_id)->value('username');
            })
            ->addColumn(
            'action',
            '<button class="mb-2 btn btn-sm btn-outline-danger mr-1">Delete</button>')
            ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function GetSalesBillData()
    {
        if (Auth::check()) {
            $voidData = Bill::where('shop_id',Auth::user()->shop_id)->where('state','settled')->orderBy('created_at','DESC')->get();
            return Datatables::of($voidData)
            ->setRowId(function($bill){
                return $bill->id;
            })
            ->editColumn('product_id',function($voidbill){
                return $voidbill->Product->company->company_name.' '.$voidbill->Product->product_name.' '.$voidbill->Product->stock->size;
            })
            ->editColumn('user_id',function($voidbill){
                return User::where('id',$voidbill->user_id)->value('username');
            })
            ->editColumn('count_type',function($voidbill){
                $count_type = Stock::where('product_id',$voidbill->product_id)->where('shop_id',Auth::user()->shop_id)->value('count_type');
                return $count_type;
            })
            ->addColumn(
            'action',
            '<button class="mb-2 btn btn-sm btn-outline-danger mr-1">Delete</button>')
            ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetItemWiseData($date)
    {
        if (Auth::check()) {
            if($date){
                $inputDate = Carbon::parse($date)->format('Y-m-d').'%';
            }else{
                $inputDate = Carbon::now()->format('Y-m-d').'%';
            }
            $product = Product::where('shop_id',Auth::user()->shop_id)->where('product_state','Active')->orderBy('product_name','ASC')->get();
            return Datatables::of($product)
            ->setRowId(function($bill){
                return $bill->id;
            })
            ->addColumn('qty_sold',function($item) use($inputDate){
                // $date = Carbon::now()->subDays(1)->format('Y-m-d').'%';
                return Bill::where('shop_id',Auth::user()->shop_id)->where('state','settled')->where('created_at','like',$inputDate)->where('product_id',$item->id)->sum('qty');
            })
            ->addColumn('total_sale',function($item) use($inputDate){
                // $date = Carbon::now()->subDays(1)->format('Y-m-d').'%';
                return Bill::where('shop_id',Auth::user()->shop_id)->where('state','settled')->where('created_at','like',$inputDate)->where('product_id',$item->id)->sum('total_price');
            })
            ->addColumn('total_discount',function($item) use($inputDate){
                // $date = Carbon::now()->subDays(1)->format('Y-m-d').'%';
                return Bill::where('shop_id',Auth::user()->shop_id)->where('state','settled')->where('created_at','like',$inputDate)->where('product_id',$item->id)->sum('discount_amount');
            })
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function NewAddForStock()
    {
        if (Auth::check()) {
            $stockData = Stock::where('shop_id',Auth::user()->shop_id)->where('remark','=','Newly Added')->orWhere('remark','=','Updated')->get();
            return Datatables::of($stockData)
            ->setRowId(function($stock){
                return $stock->id;
            })
            ->addColumn('product_name',function($stock){
                $company = $stock->product->company->company_name;
                $product = $stock->product->product_name;
                $item_name = $company.' '.$product;
                return $item_name;
            })
            ->editColumn('remark',function($stock){
                if($stock->state == 0){
                    return $stock->remark.'(Deleted Item)';
                }else{
                    return $stock->remark;
                }
            })
            ->addColumn('location_code',function($stock){
                return $stock->product->location_code;
            })
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetBatchData()
    {
        if (Auth::check()) {
            $stockData = Batch::where('shop_id',Auth::user()->shop_id)->get();
            return Datatables::of($stockData)
            ->setRowId(function($stock){
                return $stock->id;
            })
            ->addColumn('available_Qty',function($stock){
             $available = ($stock->receive_qty) - (($stock->sold_qty) + ($stock->discard_qty));
             if ($available == 0) {
                return 'Stock Close';
             }else if($stock->Product->product_state == 'Deleted'){
                return 'Stock Close';
             }else{
                return  $available;
             }
            })
            ->addColumn('product_name',function($batch){
                $company = $batch->Product->company->company_name;
                $product = $batch->Product->product_name;
                $item_name = $company.' '.$product;
                return $item_name; 
            })
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetSettledBillData()
    {
        if (Auth::check()) {
            $stockData = Bill::where('shop_id',Auth::user()->shop_id)->where('state','settled')->get();
            return Datatables::of($stockData)
            ->setRowId(function($stock){
                return $stock->id;
            })
            ->addColumn('product_name',function($batch){
                    $company = $batch->Product->company->company_name;
                    $product = $batch->Product->product_name;
                    $item_name = $company.' '.$product;
                  return $item_name;  
            })
            ->addColumn('action',function($bill){
                if($bill->Product->product_state == 'Deleted'){
                    return'<span class="new badge red" data-badge-caption="NotAvailable"></span>';
                }else{
                    if(Carbon::now()->diffInDays($bill->created_at,false) >= -7){
                        return '<button class="btn btn-danger btn-small returnItemForm"><i class="material-icons">close</i></button>';
                    }else{
                      return'<span class="new badge red" data-badge-caption="NotAvailable"></span>';  
                    }
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetShoppingCartBillData()
    {
    	if (Auth::check()) {
    		$stockData = Bill::where('shop_id',Auth::user()->shop_id)->where('state','not-settled')->where('user_id',Auth::user()->id)->get();
            return Datatables::of($stockData)
            ->setRowId(function($stock){
            	return $stock->id;
            })
            ->editColumn('discount',function($dis){
                if($dis->discount != null){
                    return $dis->discount.'%';
                }else{
                    return 'N/A';
                }
            })
            ->editColumn('serial_no',function($dis){
                if($dis->serial_no != null){
                    return $dis->serial_no;
                }else{
                    return 'N/A';
                }
            })
            ->addColumn('product_name',function($batch){
                    $company = $batch->Product->company->company_name;
                    $product = $batch->Product->product_name;
                    $item_name = $company.' '.$product;
                  return $item_name;  
            })
            ->addColumn(
            'action',
            '<button class="btn btn-danger btn-small"><i class="material-icons">close</i></button>')
            ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    // start hotel dataflow
    public function GetCurrentHotelRate()
    {
        if(Auth::check()){
            $rates = RoomRate::where('shop_id',Auth::user()->shop_id)->get();
            return Datatables::of($rates)
            ->setRowId(function($rate){
                return $rate->id;
            })
            ->editColumn('user_id',function($rate){
                return User::where('id',$rate->user_id)->value('username');
            })
            ->addColumn(
            'action',
            '<div class="ui icon buttons">
                  <button class="mini ui inverted blue button editRateModel" data-dismiss="modal" data-toggle="modal" data-target="#editRateModel">
                    <i class="edit icon"></i>
                  </button>
                  <button class="mini ui inverted red button deleteRateModel" data-dismiss="modal" data-toggle="modal" data-target="#deleteRateModel">
                    <i class="times icon"></i>
                  </button>
                </div>')
            ->rawColumns(['action'])
            ->make(true);
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }

    public function GetHotelReservationDetails()
    {
        if(Auth::check()){
            $reservations = Reservation::where('shop_id',Auth::user()->shop_id)->get();
            return Datatables::of($reservations)
            ->setRowId(function($reservation){
                return $reservation->id;
            })
            ->editColumn('travelagent_id',function($reservation){
                return TravelAgent::where('id',$reservation->travelagent_id)->value('name');
            })
            ->addColumn(
            'action',
            '<button  class="mb-2 btn btn-sm btn-outline-light mr-1 detailModel">More</button>')
            ->addColumn('last_name',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('last_name');
                // return $reservation->guset_detail->last_name;
            })
            ->addColumn('address',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('address');
                // return $reservation->guset_detail->address;
            })
            ->addColumn('travelagent',function($reservation){
                return $reservation->travelagent_id;
                // return $reservation->guset_detail->address;
            })
            ->addColumn('email',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('email');
                // return $reservation->guset_detail->email;
            })
            ->addColumn('contact_no',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('contact_no');
                // return $reservation->guset_detail->contact_no;
            })
            ->addColumn('reservationPayment',function($reservation){
                // return GuestDetail::where('reservation_id',$reservation->id)->value('contact_no');
                return $reservation->reservation_payment->total_payment;
            })
            ->addColumn('reservation_discount',function($reservation){
                // return GuestDetail::where('reservation_id',$reservation->id)->value('contact_no');
                return $reservation->reservation_payment->discount;
            })
            ->addColumn('payment_collect',function($reservation){
                // return GuestDetail::where('reservation_id',$reservation->id)->value('contact_no');
                return $reservation->reservation_payment->collect_method;
            })
            ->addColumn('advance_payment',function($reservation){
                // return GuestDetail::where('reservation_id',$reservation->id)->value('contact_no');
                return $reservation->reservation_payment->advance_payment;
            })
            ->addColumn('passport_no',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('passport_no');
                // return $reservation->guset_detail->passport_no;
            })
            ->addColumn('guest',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('first_name');
            })
            ->addColumn('contact',function($reservation){
                return GuestDetail::where('reservation_id',$reservation->id)->value('contact_no');
            })
            ->rawColumns(['action'])
            ->make(true);
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }

    public function GetRoomAvailability()
    {
        if(Auth::check()){
            $reservation = Reservation::all();
            // foreach ($reservation as $value) {
            //     $in = Carbon::createFromFormat('Y-m-d', $value->checkin);
            //     $out = Carbon::createFromFormat('Y-m-d', $value->checkout)->addDay(1);
                
            //     return $in->diffInDays($out).$in.$out;
            // }
            return $reservation;
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }
    public function GetCheckinData()
    {
        if(Auth::check()){
            $today = Carbon::parse(Carbon::now())->format('Y-m-d');
            $reservationsData = Reservation::where('shop_id',Auth::user()->shop_id)->where('checkin',$today)->whereIn('state',['confirmed','pending'])->get();
            return Datatables::of($reservationsData)
            ->setRowId(function($reservation){
                return $reservation->id;
            })
            ->editColumn('nationality',function($reservation){
                $country = Country::where('value',$reservation->nationality)->value('name');
                return '<span class="flag-icon flag-icon-'.$reservation->nationality.'" data-toggle="tooltip" data-placement="right" title="'.$country.'"></span>';
            })
            ->editColumn('night',function($reservation){
                $adult = $reservation->adult_count;
                $child = ($reservation->child_count)*(1/2);
                $pax = $adult + $child;
                return '<span class="badge badge-dark">'.$reservation->night.' Night & '.$pax.' Pax | '.$reservation->room_count.' Room Allocated</span>';
            })
            ->editColumn('contact',function($reservation){
                
                return '<span class="badge badge-info"><i class="fa fa-phone" aria-hidden="true"></i> | '.$reservation->guest_detail->contact_no.'</span>';
            })
            ->addColumn('guest_name',function($reservation){
                return $reservation->guest_detail->first_name;
            })
            ->addColumn('action',function(){
                return '<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                            <button data-toggle="tooltip" data-placement="right" title="Mark No Show" type="button" class="btn btn-white deleteReservationModal"><i class="fa fa-eye" style="color:red;" aria-hidden="true"></i></button>
                            <button data-toggle="tooltip" data-placement="right" title="Make Check In" type="button" class="btn btn-white checkingModal"><i class="fa fa-check" style="color:green;" aria-hidden="true"></i></button>
                          </div>';
            })
            ->addColumn('passport',function($reservation){
                return $reservation->guest_detail->passport_no;
            })
            ->rawColumns(['nationality','night','action','contact'])
            ->make(true);
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }
    public function GetBooking()
    {
        if(Auth::check()){
            $dates = Booking::where('shop_id',Auth::user()->shop_id)->distinct()->get(['date']);
            return Datatables::of($dates)
            ->setRowId(function($date){
                return $date->id;
            })
            ->addColumn('room_count',function($date){
                return Booking::where('shop_id',Auth::user()->shop_id)->where('date',$date->date)->sum('room_count');
            })
            ->addColumn('arrival',function($date){
                $arrival = Reservation::where('shop_id',Auth::user()->shop_id)->where('checkin',$date->date)->sum('room_count');
                if($arrival !=0){
                    return '<span class="badge badge-pill badge-primary">Arrival for '.$arrival.' Rooms</span>';
                }
            }) 
            ->addColumn('departure',function($date){
                $departure = Reservation::where('shop_id',Auth::user()->shop_id)->where('checkout',$date->date)->sum('room_count');
                if ($departure != 0) {
                    return '<span class="badge badge-pill badge-dark">Departure '.$departure.' Rooms</span>';
                }
            })
            ->addColumn('statistic',function($date){
                $AllRoomCount = Room::where('shop_id',Auth::user()->shop_id)->count();
                $currentBookedRoom =  Booking::where('shop_id',Auth::user()->shop_id)->where('date',$date->date)->sum('room_count');
                if($AllRoomCount < $currentBookedRoom){
                    return '<span class="badge badge-pill badge-warning">Hotel Over Booked with Room '.($currentBookedRoom - $AllRoomCount).'</span>';
                }else if($AllRoomCount > $currentBookedRoom){
                    return '<span class="badge badge-pill badge-success">'.($AllRoomCount - $currentBookedRoom).' Rooms Left for Booking</span>';
                }else if($AllRoomCount == $currentBookedRoom){
                    return '<span class="badge badge-pill badge-info">All Rooms Already Booked</span>';
                }
            })
            ->rawColumns(['statistic','arrival','departure'])
            ->make(true);
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }
    public function GetReservationDetails()
    {
        if(Auth::check()){
            $payments = ReservationPayment::where('shop_id',Auth::user()->shop_id)->get();
            return Datatables::of($payments)
            ->setRowId(function($payment){
                return $payment->id;
            })
            ->editColumn('advance_payment',function($payment){
                $image = Attachment::where('reservation_payment_id',$payment->id)->where('type','advance')->value('attachment');
                return '<a href="/reservation_payment/advance_payment/'.$image.'" target="_blank">'.$payment->advance_payment.'</a>';
            })
            ->editColumn('approved_by',function($payment){
                return User::where('id',$payment->approved_by)->value('username');
            })
            ->editColumn('total_payment',function($payment){
                $image = Attachment::where('reservation_payment_id',$payment->id)->where('type','reservation')->value('attachment');
                $adv = $payment->advance_payment;
                $tot = $payment->total_payment;
                $totOut = $tot - $adv;
                return '<a href="/reservation_payment/reservation_voucher/'.$image.'" target="_blank">'.$totOut.'</a>';
            })
            ->addColumn('action',function($payment){
                if($payment->state == 'pending'){
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                        <button data-toggle="tooltip" data-placement="right" title="Reject Payment" type="button" class="btn btn-white rejectmButton"><i class="fa fa-eye" style="color:red;" aria-hidden="true"></i></button>
                        <button data-toggle="tooltip" data-placement="right" title="Accept Payment Details" type="button" class="btn btn-white confirmButton"><i class="fa fa-check" style="color:green;" aria-hidden="true"></i></button>
                        </div>';
                }else if($payment->state == 'confirmed'){
                    return '<span class="badge badge-success">Payment Details Confirmed</span>';
                }else if($payment->state == 'rejected'){
                    return '<span class="badge badge-danger">Payment Details Rejected</span>';
                }
            })
            ->rawColumns(['advance_payment','total_payment','action'])
            ->make(true);
            
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }

    public function GetCurrentGuestData()
    {
        if(Auth::check()){
            $roomsOccupied = Room::where('shop_id',Auth::user()->shop_id)->where('room_state','occupied')->get();
            return Datatables::of($roomsOccupied)
            ->setRowId(function($room){
                return $room->id;
            })
            ->addColumn('guest_name',function($room){
                $name = GuestDetail::where('reservation_id',$room->reservation_id)->value('first_name');
                return $name;
            })
            ->addColumn('outstanding_reservation',function($room){
                $name = ReservationPayment::where('reservation_id',$room->reservation_id)->where('state','!=','rejected')->first();
                
                $totalPayble = $name->total_payment - $name->advance; 

                return $totalPayble;
            })
            ->make(true);
            
        }else{
           return redirect('/sri-lanka-web-based-pos-software-signup'); 
        }
    }
    // end hotel dataflow
}
