<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// ----------------- this not working when host website
// use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
// use Mike42\Escpos\Printer;
// -----------------

use App\customer;
use App\Jobs;
use App\User;
use App\Shop;
use Carbon\Carbon;
use Session;

class JobsController extends Controller
{
    public function ReceiveJob(Request $request)
    {
    	$name = $request['name'];
    	$address = $request['address'];
    	$nic = $request['nic'];
    	$contact = $request['contact'];
        $shop_name = Shop::where('id',Auth::user()->shop_id)->value('shop_name');
        $shop_contact_no = Shop::where('id',Auth::user()->shop_id)->value('contact_no');
    	$customer = new customer();

    	$customer->name = $name;
    	$customer->address = $address;
    	$customer->nic = $nic;
        if(substr($contact,0,1) == 0){
            $customer->contact_no = substr_replace($contact,"94",0,1);
        }else if(substr($contact,0,2) == 94){
            $customer->contact_no = $contact;
        }
        $customer->user_id = Auth::user()->id;
    	$customer->shop_id = Auth::user()->shop_id;

    	$customer->save();

    	$priority = $request['priority'];
    	$description = $request['description'];
        $remark = $request['remark'];
        $job_price = $request['job_price'];
    	$advance = $request['advance'];
    	$customer_id = DB::table('customers')->where('nic', $nic)->value('id');
        $previousJob = Jobs::where('shop_id',Auth::user()->shop_id)->orderBy('created_at','DESC')->first();
    	$job = new Jobs();
    	$job->description = $description;
    	$job->remark = $remark;
    	$job->priority = $priority;
        $job->customer_id = $customer_id;
        $job->job_price = $job_price;
        if($previousJob != null){
            $job->jobNo = $previousJob->jobNo + 1;
        }else{
            $job->jobNo = 1;
        }
    	$job->advance_payment = $advance;
        $job->user_id = Auth::user()->id;
        $job->shop_id = Auth::user()->shop_id;
    	
    	$job->save();

        $print_job_id = Jobs::where('print_receipt',0)->where('user_id',Auth::user()->id)->value('id');
        if (Auth::user()->print_type == 'invoice') {
         return view('PrintPreview/printpreview',compact('description','priority','job_price','remark','job_price'));   
        }else{
            $shop = Shop::where('id',Auth::user()->shop_id)->value('shop_name');
            $address = Shop::where('id',Auth::user()->shop_id)->value('address');
            $city = Shop::where('id',Auth::user()->shop_id)->value('city');
            $contact_no = Shop::where('id',Auth::user()->shop_id)->value('contact_no');
            // $jobNo = Shop::where('id',Auth::user()->shop_id)->value('jobNo');
            if($previousJob != null){
                $jobNo = $previousJob->jobNo + 1;
            }else{
                $jobNo = 1;
            }
        return redirect()->back()
            ->with([
                    'success'=>'Received Note Succussfully printed',
                    'job_id'=> $print_job_id,
                    'priority' => $priority,
                    'description' => $description,
                    'job_price' => $job_price,
                    'advance_payment' => $advance,
                    'remark' => $remark,
                    'address' => $address,
                    'city' => $city,
                    'contact_no' => $contact_no,
                    'jobNo' => $jobNo,
                    'shop' => $shop
                ]);
        }
    }

    public function JobAction(Request $request)
    {
        if($request['cancel_job_id']){
            Jobs::where('id',$request['cancel_job_id'])
                ->update([
                    'state' => 'Canceled'
                    ]);

            return redirect()->back()->with(['success' => 'Job Canceled']);
        }
        if($request['finish_job_id']){
            Jobs::where('id',$request['finish_job_id'])
                ->update([
                    'state' => 'Completed'
                    ]);

            return redirect()->back()->with(['success' => 'Job Completed']);
        }
    }
}
