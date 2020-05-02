<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\customer;
use App\Jobs;
use App\Expence;
use App\User;
use App\Bill;
use App\Stock;
use App\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Twilio\Twiml;

class ReportController extends Controller
{
    public function expence()
    {
        $this_month = Carbon::now()->format('m');
        $this_year = Carbon::now()->format('Y');

        $expence = Expence::where('shop_id',Auth::user()->shop_id)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');
        return $expence; 
    }
    public function income()
    {
        $this_month = Carbon::now()->format('m');
        $this_year = Carbon::now()->format('Y');

        $bill_income = Bill::where('shop_id',Auth::user()->shop_id)->where('state','settled')->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('total_price');
        $job_income = Jobs::where('shop_id',Auth::user()->shop_id)->where('state','Completed')->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('job_price');

        $income = $bill_income + $job_income;
        return $income; 
    }

    public function GetReports()
    {
        if (Auth::check()) {
            
            $start = Carbon::now()->subDays(10)->format('Y-m-d');
            $end = Carbon::now()->format('Y-m-d');
            $months_array = array();
            $item_cost_array = array();
            $profit_array = array();
            $scale = 10000;
            $period = CarbonPeriod::create($start,$end );

            $this_month = Carbon::now()->format('m');
            $this_year = Carbon::now()->format('Y');
            $category = Expence::orderBy('category','ASC')->where('shop_id',Auth::user()->shop_id)->pluck('category');
            $month_expence_array = array();
            foreach ($category as $type) {
            $total = Expence::where('shop_id',Auth::user()->shop_id)->where('category',$type)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');

                $month_expence_array[$type] = $total;
            }

            if (! empty($period)) {
                    foreach ($period as $date) {
                    $month_day = Carbon::parse($date)->format('d');
                    $month_name = Carbon::parse($date)->format('M');
                    $month_no = Carbon::parse($date)->format('m');
                    $year_no = Carbon::parse($date)->format('Y');
                   
                    $daily_sales = Bill::whereDay('created_at',date($month_day))
                                    ->whereMonth('created_at',date($month_no))
                                    ->whereYear('created_at',date($year_no))
                                    ->where('shop_id',Auth::user()->shop_id)
                                    ->sum('total_price');
                    $item_cost = Stock::where('remark','sale')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum(DB::raw('qty * unit_price'));
                    $receive_job_profit = Jobs::where('state','Completed')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum('job_price');

                    $item_cost_array[$month_day.$month_name] = ($item_cost)*(-1);
                    $months_array[$month_day.$month_name] = $daily_sales;
                    $profit_array[$month_day.$month_name] = $daily_sales + $item_cost + $receive_job_profit;

                }
            }


            return view('Reports/report',compact('months_array','item_cost_array','profit_array','scale','month_expence_array'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetMyReports()
    {
        if (Auth::check()) {
            return view('Reports/shop-report');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function GetSalesChartData(Request $request)
    {
        if (Auth::check()) {
            $step_size = $request['step_size'];
            $start = Carbon::now()->subDays(10)->format('Y-m-d');
            $end = Carbon::now()->format('Y-m-d');
            $months_array = array();
            $item_cost_array = array();
            $profit_array = array();
            $scale = 1000;
            $period = CarbonPeriod::create($start,$end );

            $this_month = Carbon::now()->format('m');
            $this_year = Carbon::now()->format('Y');
            $category = Expence::orderBy('category','ASC')->where('shop_id',Auth::user()->shop_id)->pluck('category');
            $month_expence_array = array();
            foreach ($category as $type) {
            $total = Expence::where('shop_id',Auth::user()->shop_id)->where('category',$type)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');

                $month_expence_array[$type] = $total;
            }

            if (! empty($period)) {
                    foreach ($period as $date) {
                    $month_day = Carbon::parse($date)->format('d');
                    $month_name = Carbon::parse($date)->format('M');
                    $month_no = Carbon::parse($date)->format('m');
                    $year_no = Carbon::parse($date)->format('Y');
                   
                    $daily_sales = Bill::whereDay('created_at',date($month_day))
                                    ->whereMonth('created_at',date($month_no))
                                    ->whereYear('created_at',date($year_no))
                                    ->where('shop_id',Auth::user()->shop_id)
                                    ->where('state','settled')
                                    ->sum('total_price');
                    $item_cost = Stock::where('remark','sale')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum(DB::raw('qty * unit_price'));
                    $receive_job_profit = Jobs::where('state','Completed')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum('job_price');

                    $item_cost_array[$month_day.$month_name] = ($item_cost)*(-1);
                    $months_array[$month_day.$month_name] = $daily_sales;
                    $profit_array[$month_day.$month_name] = $daily_sales + $item_cost + $receive_job_profit;

                }

            }
            return response()->json(['expence' => $month_expence_array,'success' => false,'sales' => $months_array,'cost' => $item_cost_array,'profit'=>$profit_array,'stepSize'=> $scale]); 
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }

    public function GetChangeChartData(Request $request)
    {
        if (Auth::check()) {
            $step_size = $request['step_size'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];
            
            if($start_date){
                $start = Carbon::parse($start_date)->format('Y-m-d');
            }else{
                $start = Carbon::now()->format('Y-m-d');
            }

            if($end_date){
                $end = Carbon::parse($end_date)->format('Y-m-d');
            }else{
                $end = Carbon::now()->format('Y-m-d');
            }
            
            $months_array = array();
            $item_cost_array = array();
            $profit_array = array();
            if($step_size){
                $scale = $step_size;
                $value = 'submit';
            }else{
                $scale = 1000;
                $value = 'not-submit';
            }

            $period = CarbonPeriod::create($start,$end );

            if (! empty($period)) {
                    foreach ($period as $date) {
                    $month_day = Carbon::parse($date)->format('d');
                    $month_name = Carbon::parse($date)->format('M');
                    $month_no = Carbon::parse($date)->format('m');
                    $year_no = Carbon::parse($date)->format('Y');
                   
                    $daily_sales = Bill::whereDay('created_at',date($month_day))
                                    ->whereMonth('created_at',date($month_no))
                                    ->whereYear('created_at',date($year_no))
                                    ->where('shop_id',Auth::user()->shop_id)
                                    ->where('state','settled')
                                    ->sum('total_price');
                    $item_cost = Stock::where('remark','sale')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum(DB::raw('qty * unit_price'));
                    $receive_job_profit = Jobs::where('state','Completed')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum('job_price');

                    $item_cost_array[$month_day.$month_name] = ($item_cost)*(-1);
                    $months_array[$month_day.$month_name] = $daily_sales;
                    $profit_array[$month_day.$month_name] = $daily_sales + $item_cost + $receive_job_profit;

                }

            }
            return response()->json(['success' => $value,'sales' => $months_array,'cost' => $item_cost_array,'profit'=>$profit_array,'stepSize'=> $scale]); 
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function GetChangeExpenceChartData(Request $request)
    {
        if (Auth::check()) {

            $month = $request['month'];
            $year = $request['year'];
            $month_expence_array = array();

            if($month){
                $this_month = $month;
            }else{
                $this_month = Carbon::now()->format('m');
            }

            if($year){
                $this_year = $year;
            }else{
                $this_year = Carbon::now()->format('Y');
            }

           
            $category = Expence::orderBy('category','ASC')->where('shop_id',Auth::user()->shop_id)->pluck('category');
            foreach ($category as $type) {
            $total = Expence::where('shop_id',Auth::user()->shop_id)->where('category',$type)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');

                $month_expence_array[$type] = $total;
            }
            return response()->json(['expence' => $month_expence_array]);
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }


    public function GetReportdata(Request $request)
    {
        if (Auth::check()) {
            $doughtnut_month = $request['month'];
            $doughtnut_year = $request['year'];
            $scale = $request['step_size'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];

            if ($start_date ) {
                $start = $start_date;
            }else{
                $start = Carbon::now()->subDays(10)->format('Y-m-d');
            }

            if ($end_date) {
                $end =$end_date;
            }else{
                $end = Carbon::now()->format('Y-m-d');
            }
            if($doughtnut_month){
                $this_month = $doughtnut_month;
            }else{
                $this_month = Carbon::now()->format('m');
            }

            if($doughtnut_year){
                $this_year = $doughtnut_year;
            }else{
                $this_year = Carbon::now()->format('Y');
            }
            
            $period = CarbonPeriod::create($start,$end );
            $category = Expence::orderBy('category','ASC')->where('shop_id',Auth::user()->shop_id)->pluck('category');
            $month_expence_array = array();
            foreach ($category as $type) {
            $total = Expence::where('shop_id',Auth::user()->shop_id)->where('category',$type)->where('shop_id',Auth::user()->shop_id)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');

                $month_expence_array[$type] = $total;
            }

            $months_array = array();
            $item_cost_array = array();
            $profit_array = array();
            $cost_total = 0;
            $period = CarbonPeriod::create($start,$end );
            if (! empty($period)) {
                foreach ($period as $date) {
                    $month_day = Carbon::parse($date)->format('d');
                    $month_name = Carbon::parse($date)->format('M');
                    $month_no = Carbon::parse($date)->format('m');
                    $year_no = Carbon::parse($date)->format('Y');
                    $daily_sales = Bill::whereDay('created_at',date($month_day))
                                    ->whereMonth('created_at',date($month_no))
                                    ->whereYear('created_at',date($year_no))
                                    ->where('shop_id',Auth::user()->shop_id)
                                    ->sum('total_price');
                    $item_cost = Stock::where('remark','sale')
                                        ->where('shop_id',Auth::user()->shop_id)
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum(DB::raw('qty * unit_price'));

                    $item_cost_array[$month_day.$month_name] = ($item_cost)*(-1);                    
                    $months_array[$month_day.$month_name] = $daily_sales;
                    $profit_array[$month_day.$month_name] = $daily_sales + $item_cost;

                }//period end foreach
            }
            return view('Reports/sale-data',compact('this_month','this_year','months_array','scale','item_cost_array','profit_array','month_expence_array'));
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function doughnut(Request $request)
    {   
        if (Auth::check()) {
            $doughtnut_month = $request['month'];
            $doughtnut_year = $request['year'];

             if($doughtnut_month){
                $this_month = $doughtnut_month;
            }

            if($doughtnut_year){
                $this_year = $doughtnut_year;
            }

            $category = Expence::orderBy('category','ASC')->where('shop_id',Auth::user()->shop_id)->pluck('category');
            $month_expence_array = array();
            foreach ($category as $type) {
            $total = Expence::where('shop_id',Auth::user()->shop_id)->where('category',$type)->where('shop_id',Auth::user()->shop_id)->whereMonth('created_at',$this_month)->whereYear('created_at',$this_year)->sum('amount');

                $month_expence_array[$type] = $total;
            }
            return redirect()->back()->with(['$month_expence_array' => $month_expence_array]);
        }else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
        
    }
    public function Billdata()
    {
        if (Auth::check()) {
            $bills = DB::table('bills')
            ->join('stocks', 'bills.created_at', '=', 'stocks.created_at')
            ->get();

  
            return $bills;
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
// ======================================================================================================
    public function getAllMonths()
    {
        if (Auth::check()) {
        	$months_array = array();
            $months = Bill::orderBy('created_at','ASC')->pluck('created_at');
            if (! empty($months)) {
            	foreach ($months as $unformated_month) {
            		$month = new \DateTime($unformated_month);
            		$month_no = $month->format('m');
            		$month_name = $month->format('M');

            		$months_array[$month_no] = $month_name;
            	}
            }
            return $months_array;
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function getMonthData($month)
    {
        if (Auth::check()) {
   
        	$total_sale_month = Bill::whereMonth('created_at',$month)->sum('total_price');
            return $total_sale_month;
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function getAllMonthlyData()
    {

            $item_cost_array = array();
            $cost_total = 0;
            $start = Carbon::now()->subDays(30)->format('Y-m-d');
            $end = Carbon::now()->format('Y-m-d');
            $months_array = array();
            $period = CarbonPeriod::create($start,$end );
            if (! empty($period)) {
                    foreach ($period as $date) {
                    $month_day = Carbon::parse($date)->format('d');
                    $month_name = Carbon::parse($date)->format('M');
                    $month_no = Carbon::parse($date)->format('m');
                    $year_no = Carbon::parse($date)->format('Y');
                   
                    $daily_sales = Bill::whereDay('created_at',date($month_day))
                                    ->whereMonth('created_at',date($month_no))
                                    ->whereYear('created_at',date($year_no))
                                    ->where('shop_id',Auth::user()->shop_id)
                                    ->sum('total_price');
                    $item_cost = Stock::where('remark','sale')
                                        ->whereDay('created_at',$month_day)
                                        ->whereMonth('created_at',$month_no)
                                        ->whereYear('created_at',$year_no)
                                        ->sum(DB::raw('qty * unit_price'));
                                        
                    $item_cost_array[$month_day.$month_name] = $item_cost;
                    $months_array[$month_day.$month_name] = $daily_sales;
                }
        }
        return $item_cost_array;
    }
}
