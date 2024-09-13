<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\customer;
use Carbon\Carbon;
use App\Shop;

// start sms api details
use \NotifyLk\Configuration;
use \NotifyLk\ApiClient;
use \NotifyLk\ApiException;
use \NotifyLk\ObjectSerializer;
use App\SmsApi;
// end sms api details


class SmsController extends Controller
{
    public function SendBulkMessage(Request $request)
    {
        $bulk_message = $request['bulkMessage'];
        $today = Carbon::now()->toDateString();
        if(Auth::user()->role === 'super_admin'){
            $customer_numbers = Shop::distinct('contact_no')->get();
            if($bulk_message){
                    foreach ($customer_numbers as $number) {
                        if($number->contact_no != null){
                            // ==========send message===============
                            $api_instance = new \NotifyLk\Api\SmsApi();
                            $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                            $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                            $message = Auth::user()->shop->shop_name."\n\n".$bulk_message; 
                            $to = $number->contact_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                            $sender_id = Auth::user()->shop->sender_id; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
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
                    }

                    return redirect()->back()->with('success','Message Send Successfull');
                }

        }else if( Auth::user()->role == 'user' || Auth::user()->role =='admin' ){
            $customer_numbers = customer::where('shop_id',Auth::user()->shop_id)->where('created_at','>', $today)->distinct('contact_no')->get();
            if(Auth::user()->shop->bulk == 1){
                
                $thisMonth = Carbon::now()->month;
                $userBulkMonth = Auth::user()->shop->bulk_month;
                $userBulkAttemptCount = Auth::user()->shop->bulk_attempt;
                $userPaymentPlan = Auth::user()->shop->payment_plan;
                
                if($thisMonth == $userBulkMonth ){
                    
                    switch ($userPaymentPlan) {
                        case 'starter':
                            if($userBulkAttemptCount === 0){
                                $availability = 1;
                                break;
                            }else{
                                $availability = 0;
                                break;
                            }
                            break;

                        case 'advance':
                            if($userBulkAttemptCount < 1){
                                $availability = 1;
                                break;
                            }else{
                                $availability = 0;
                                break;
                            }
                            break;

                        case 'economy':
                            if($userBulkAttemptCount < 2){
                                $availability = 1;
                                break;
                            }else{
                                $availability = 0;
                                break;
                            }

                        default:
                            $availability = 0;
                            break;
                    }
                }else{
                   $availability = 0; 
                }
                
                if($availability == 1){
                    $userNewAttemptCount = $userBulkAttemptCount + 1;
                    if($userPaymentPlan === 'starter' ){
                        Shop::where('id',Auth::user()->shop_id)->update([ 'bulk_attempt' => $userNewAttemptCount,'bulk' => 0, ]);
                    }else if( $userPaymentPlan === 'advance' || $userPaymentPlan === 'economy'){
                        Shop::where('id',Auth::user()->shop_id)->update([ 'bulk_attempt' => $userNewAttemptCount ]);
                    } 
                    return 'success';
                }else{
                    return redirect()->back()->with('error','Bulk SMS attempt is over for this month,If you need more please make a payment or contact our customer support');
                }

                if($bulk_message){
                    foreach ($customer_numbers as $number) {
                         // ==========send message===============
                            $api_instance = new \NotifyLk\Api\SmsApi();
                            $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                            $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                            $message = Auth::user()->shop->shop_name."\n\n".$bulk_message; 
                            $to = $number->contact_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                            $sender_id = Auth::user()->shop->sender_id; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
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
                    return redirect()->back()->with('success','Message Send Successfull');
                }
            }else{
                return redirect()->back()->with('error','Sorry this Bulk SMS Service not activated for you,To activate this Service Please contact our Customer Service Agent');
            }
        }
    }
}
