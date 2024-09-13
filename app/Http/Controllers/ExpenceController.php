<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Expence;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ExpenceController extends Controller
{
    public function PostExpence(Request $request)
    {
    	if (Auth::check()) {
    		$category = $request['category'];
    		$amount = $request['amount'];
    		$remark = $request['remark'];

    		if ($category != '0') {
                $new_expence_record = new Expence();
                $new_expence_record->user_id = Auth::user()->id;
                $new_expence_record->shop_id = Auth::user()->shop_id;
                $new_expence_record->amount = $amount;
                $new_expence_record->category = $category;
                $new_expence_record->remark = $remark;
                $new_expence_record->save();
                return redirect()->back()->with('success','Your Expence Successfully Stored!');
            }else{
                return redirect()->back()->with('error','Please select expence category!');
            }

            
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
    public function DeleteExpence(Request $request)
    {
    	if (Auth::check()) {
    		$record_id = $request['record_id'];

    		Expence::where('id',$record_id)->delete();

            return redirect()->back()->with('success','Expence Successfully Removed!');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-software-signup');
        }
    }
}
