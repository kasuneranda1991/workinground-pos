<?php
namespace App;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use App\Charts\SaleChart;
use App\customer;
use App\Jobs;
use App\User;
use App\Shop;
use App\Stock;
use App\Product;
use App\Expence;
use Carbon\Carbon;
use App\Batch;
use App\Bill;
// include_once(app_path() . '\WebClientPrint\WebClientPrint.php');
use Neodynamic\SDK\Web\ClientPrintJob;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\WebClientPrint;//this is related to $wcpScript
use File;
use Session;
class ViewController extends Controller
{
    public function GetVideoTutorial()
    {
        return View('tutorial/tutorial');
    }
    public function landingPage()
    {
        return View('landing/landing');
    }
    public function GettestPage()
    {
        return View('test');
    }
    public function GetBatch()
    {
        if (Auth::check()) {

            return view('Batch/batch');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetSiteMap()
    {
        return view('sitemap');
    }
    
    public function datapost(Request $request)
    {
        Shop::where('id',1)->update([
                'shop_name' => $request['shop_name'],
                ]);
        
        // return $shop;
        // return Response::json($shop);;
    }
    public function data()
    {
        $shop = Shop::all();
        // return $shop;
        return Response::json($shop);
    }

    public function Getajaxtest()
    {
        if (Auth::check()) {

            return view('testAjax');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function GetTestRelation()
    {
        if (Auth::check()) {
            // $x = Product::first();
            $x = Shop::first();
            // foreach ($x as $value) {
                 return $x->user->username;
            // }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function GetHome()
    {
        if (Auth::check()) {

            return view('home');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetStockTestView()
    {
        if (Auth::check()) {

            return view('stores.stores_home');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function TestPrint(Request $request)
    {
        if (Auth::check()) {
            $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('ViewController@TestPrint'), Session::getId());
            $sid = Session::getId();
            
            return view('testPrint',compact('wcpScript','sid'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function PrintJob(Request $request){
        //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
        $cpj = new ClientPrintJob();
        $cpj->clientPrinter = new DefaultPrinter();
        // $cpj->printerCommands = 'PRINTER_COMMANDS_GO_HERE';
        $cpj->printerCommands = '0x1B C 0x00 5';
        $cpj->sendToClient();

        return redirect()->back();
    }
    public function GetExpence()
    {
        if (Auth::check()) {
            
            
            $this_month = Carbon::now()->format('m');
            $this_year = Carbon::now()->format('Y');
            $category = Expence::orderBy('category','ASC')->where('shop_id',Auth::user()->shop_id)->pluck('category');
            $month_expence_array = array();
            foreach ($category as $type) {
            $total = Expence::where('shop_id',Auth::user()->shop_id)->where('category',$type)->where('shop_id',Auth::user()->shop_id)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');

                $month_expence_array[$type] = $total;
            }

            // $totalExpence = Expence::where('shop_id',Auth::user()->shop_id)->whereMonth('created_at',$this_month)->sum('amount');
            return view('Expence/expence',compact('month_expence_array'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    // ________________________________________________________Start Alert expired
    public function expiredItemNotification()
    {
        $date = Carbon::now()->addDays(7);
        $expArray = array();
        $expitemArray = array();
        $dataEXP = Batch::where('shop_id',Auth::user()->shop->id)->where('state',1)->where('expire_date','>',Carbon::now())->where('expire_date', '<',$date)->whereNotNull('expire_date')->get();

        foreach ($dataEXP as $value){
            $product = Product::where('shop_id',Auth::user()->shop_id)->where('id',$value->product_id)->first();
            $name = $product->product_name;
            $company = $product->company->company_name;
            $itemName = $company.' '.$name;
            $sold = $value->sold_qty;
            $receive = $value->receive_qty;
            $discard = $value->discard_qty;
            $available = $receive - ($sold + $discard);

            $expitemArray['item'] = $itemName;         
            $expitemArray['qty'] = $available;         
            $expitemArray['batch_no'] = $value->batch_no;
            $expitemArray['day'] = Carbon::parse(Carbon::now())->diffInDays($value->expire_date);
            $expitemArray['type'] = $product->stock->count_type;

            $expArray[$value->id] = $expitemArray;         
        }
        return $expArray;
    }
    // reduce dode alert exoired
    public function outOfStockData()
    {

        $alertArray = array();
        $alertItemData = array();
        $dataOS = Batch::where('shop_id',Auth::user()->shop->id)
                        ->where('state','!=','0')
                        ->where('expire_date','>',Carbon::now())
                        ->orWhere('expire_date','=',null)
                        ->distinct('product_id')
                        // ->sum('sold_qty');
                        ->get();
                    foreach ($dataOS as $value) {
                        $sold = Batch::where('product_id',$value->product_id)->sum('sold_qty');
                        $receive = Batch::where('product_id',$value->product_id)->sum('receive_qty');
                        $discard = Batch::where('product_id',$value->product_id)->sum('discard_qty');

                        $total = $receive - ($sold + $discard);
                        if(Product::where('shop_id',Auth::user()->shop_id)->where('id',$value->product_id)->value('stock_remainder') >= $total){
                            $product = Product::where('shop_id',Auth::user()->shop_id)->where('id',$value->product_id)->first();

                            $name = $product->product_name;
                            $company = $product->company->company_name;
                            $itemName = $company.' '.$name;
                            $alertItemData['item'] = $itemName;
                            $alertItemData['qty'] = $total;
                            $alertItemData['batch_no'] = $value->batch_no;

                            $alertArray[$value->product_id] = $alertItemData;
                        }
                    }
       
        // return View('alerttest',compact('expArray','alertArray'));
        return $alertArray;
    }
    // reduce dode alert exoired

    public function alertExpired()
    {
        return Batch::where('shop_id',Auth::user()->shop->id)->where('state',1)->where('expire_date', '>',Carbon::now())->whereNotNull('expire_date')->get();   
    }

    public function ProductItems()
    {
        if (Auth::check()) {
            return Product::where('shop_id',Auth::user()->shop_id)->get();
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function DistinctQuantity()
    {
        if (Auth::check()) {
        
            return Batch::where('state',1)->where('expire_date', '>',Carbon::now())->get();
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function AlertDataDate()
    {
        if (Auth::check()) {
            $stock = Stock::all()->first();
            $exp = $stock->expire_date;
            $now = Carbon::now();
            $exp_carbon = new Carbon($stock->expire_date);
            $date_remain = Carbon::parse(Carbon::now())->diffInDays($exp_carbon);
           

            return view('alert/alert-data',compact('date_remain'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function ExpireAndOutOfStockAlert()
    {
        if (Auth::check()) {
            
            
           

            return $alertArray;
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    // ________________________________________________________end Alert expired
    public function GetMaster()
    {
        if (Auth::check()) {
            
            return view('master');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetReceiveJob()
    {
        if (Auth::check()) {
             if (Auth::user()->shop->type == 'Mobile_repair' || Auth::user()->role == 'super_admin') {
                 $jobs = Jobs::orderBy('created_at','desc')->get();
                 $users = User::all();
                 $customers = customer::all();

                 $completejob = Jobs::where('shop_id',Auth::user()->shop_id)->where('state','Completed')->count();
                 $workingjob = Jobs::where('shop_id',Auth::user()->shop_id)->where('state','working')->count();
                 $canceljob = Jobs::where('shop_id',Auth::user()->shop_id)->where('state','Canceled')->count();
                return view('job/receivejob' ,compact('jobs','users','customers','completejob','workingjob','canceljob'));
             }else{
                return redirect()->back()->with('error','This facility not included to your shop type');
             }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetPrinterTest()
    {
            return view('print/myprinter');
    }
    public function GetLogin()
    {
    	if(Auth::check() == false){
            return view('login');
        }else{
            return redirect()->back();
        }
    }
    public function GetRegister()
    {
    	return view('register');	
    }
    public function GetJob()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Mobile_repair' || Auth::user()->role == 'super_admin') {
                return view('job/getjob');   
            }else{
                return redirect()->back()->with('error','This facility not included to your shop type');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetPrint()
    {
        if (Auth::check()) {
            return view('PrintPreview/printpreview');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetnewUserManage()
    {
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            return view('Manage-users/test');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetSystemTest()
    {
        if (Auth::check()) {
            $shop = Shop::all();
            return view('test',compact('shop'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    // start hotel view
    public function Getreservation()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('reservation/reservation');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }    
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetreservationDetail()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('reservation/reservationDetails');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }    
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetCalender()
    {
        if (Auth::check()) {
             if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('reservation/availability');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }    
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetRoomRate()
    {
        if (Auth::check()) {
             if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('roomRate/roomRate');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            } 
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetRoomOccupancy()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('reservation/room_occupancy');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            } 
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetCheckIn()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('CheckIn/checkin');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetCheckOut()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('CheckIn/checkout');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetReservationConfirmation()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('reservation_confirmation/reservation_confirmation');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function GetHotelCurrentGuest()
    {
        if (Auth::check()) {
            if (Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin') {
                return view('currentGuest/current-guest');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    // end hotel view
}
