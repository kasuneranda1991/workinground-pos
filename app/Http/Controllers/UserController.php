<?php
namespace NotifyLk;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Shop;
use Image;
use Hash;

use \NotifyLk\Configuration;
use \NotifyLk\ApiClient;
use \NotifyLk\ApiException;
use \NotifyLk\ObjectSerializer;
use App\SmsApi;

class UserController extends Controller
{
    public function registerUser(Request $request){ 

        $username = $request['username'];
        $shop_name = $request['shop_name'];
        $shop_id_of_new_user = $request['shop_id'];
        $contact_no = $request['contact_no'];
    	$shop_type = $request['shop_type'];
    	$password = bcrypt($request['password']);
        $verificationCode = rand(10,100000);

        $shop_count = Shop::where('id',$shop_id_of_new_user)->count();

        if ($shop_type && $shop_id_of_new_user === null ) {
            $new_shop = new Shop();
            $new_shop->shop_name = $shop_name;
            $new_shop->type = $shop_type;
            $new_shop->expire_date = Carbon::parse(Carbon::now())->addDays(150);
            $new_shop->save();

            // create user
            $user = new User;
            $user->username = $username;
            $user->password = $password;
            $user->confirmed = 1;
            if(substr($contact_no,0,1) == 0){
                $user->contact_no = substr_replace($contact_no,"94",0,1);
                $sender_no = substr_replace($contact_no,"94",0,1);
            }else if(substr($contact_no,0,2) == 94){
                $user->contact_no = $contact_no;
                $sender_no = $contact_no;
            }
            // $user->verification_code = $verificationCode; Vcode disabled due to finantial difficulties
            
            $user->verification_code = 0;
            $user->login_state = 'online';
            $user->shop_id = Shop::where('shop_name',$shop_name)->latest()->value('id');
            $user->save();

            // ________________________________________________________________
            Auth::login($user);
            // $shop_id_contact = Shop::where('shop_name',$shop_name)->value('id');

            $api_instance = new \NotifyLk\Api\SmsApi();
            $user_id = "10611"; // string | API User ID - Can be found in your settings page.
            $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
            $message = "Hi ". $username. " this is Your Verification Code " .$verificationCode." Contact Us if you need help"; // string | Text of the message. 320 chars max.
            $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
            $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
            $contact_fname = $shop_name; // string | Contact First Name - This will be used while saving the phone number in your Notify contacts.
            $contact_lname = ""; // string | Contact Last Name - This will be used while saving the phone number in your Notify contacts.
            $contact_email = ""; // string | Contact Email Address - This will be used while saving the phone number in your Notify contacts.
            $contact_address = ""; // string | Contact Physical Address - This will be used while saving the phone number in your Notify contacts.
            $contact_group = 0; // int | A group ID to associate the saving contact with

            try {
                $api_instance->sendSMS($user_id, $api_key, $message, $to, $sender_id, $contact_fname, $contact_lname, $contact_email, $contact_address, $contact_group);
            } catch (Exception $e) {
                echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
            }
            // ________________________________________________________________
            return redirect('/');
        }else if($shop_count != null){

            $user = new User;
            $user->username = $username;
            $user->password = $password;
            
            if(substr($contact_no,0,1) == 0){
                $user->contact_no = substr_replace($contact_no,"94",0,1);
                $sender_no = substr_replace($contact_no,"94",0,1);
            }else if(substr($contact_no,0,2) == 94){
                $user->contact_no = $contact_no;
                $sender_no = $contact_no;
            }
            $user->shop_id = $shop_id_of_new_user;

            // this is belong to to create new user
            $payment_plan = Shop::where('id',$shop_id_of_new_user)->value('payment_plan');
            $user_count = User::where('shop_id',$shop_id_of_new_user)->count();
                if($payment_plan === 'demo' && $user_count === 0){
                    $confirmed = true;
                    $user->confirmed = 1;
                    $user->login_state = 'online'; 
                }else if($payment_plan === 'starter' && $user_count === 0){
                    $confirmed = true;
                    $user->confirmed = 1;
                    $user->login_state = 'online';
                }else if($payment_plan === 'advance' && $user_count <= 1){
                    $confirmed = true;
                    $user->confirmed = 1;
                    $user->login_state = 'online';
                }else if($payment_plan === 'economy' && $user_count <= 4){
                    $confirmed = true;
                    $user->confirmed = 1;
                    $user->login_state = 'online';
                }else{
                    $confirmed = false;
                    $user->confirmed = 0;
                    $user->login_state = 'offline';
                }
                $user->verification_code = $verificationCode;
                $user->save();


            if($confirmed === true){
                Auth::login($user);
                // ________________________________________________________________
                // $shop_id_contact = Shop::where('shop_name',$shop_name)->value('id');

                $api_instance = new \NotifyLk\Api\SmsApi();
                $user_id = "10611"; // string | API User ID - Can be found in your settings page.
                $api_key = "bLaRxOMBksfNdn7Q4NUn"; // string | API Key - Can be found in your settings page.
                $message = "Hi ". $username. " this is Your Verification Code " .$verificationCode." Contact Us if you need help"; // string | Text of the message. 320 chars max.
                $to = $sender_no; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
                $sender_id = "WORKINGROUN"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
                $contact_fname = $shop_name; // string | Contact First Name - This will be used while saving the phone number in your Notify contacts.
                $contact_lname = ""; // string | Contact Last Name - This will be used while saving the phone number in your Notify contacts.
                $contact_email = ""; // string | Contact Email Address - This will be used while saving the phone number in your Notify contacts.
                $contact_address = ""; // string | Contact Physical Address - This will be used while saving the phone number in your Notify contacts.
                $contact_group = 0; // int | A group ID to associate the saving contact with

                try {
                    $api_instance->sendSMS($user_id, $api_key, $message, $to, $sender_id, $contact_fname, $contact_lname, $contact_email, $contact_address, $contact_group);
                } catch (Exception $e) {
                    echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
                }
                // ________________________________________________________________
                return redirect('/');
            }else{
                return redirect('/sri-lanka-web-based-pos-system-software-signup')->with('error','Maximum user limit exeed please contact customer support if need more users to in your shop');
            }
            // this is belong to to create new user
        }else{
            return redirect()->back()->with('error','Please Choose Shop Type');
        }
    }
    public function SignOut(){
        User::where('id',Auth::user()->id)->update(['login_state' => 'offline']);
        Auth::logout();
        return redirect('/sri-lanka-web-based-pos-system-software-signup');
    }
    public function VerifyAccount(Request $request)
    {
        $code = $request['verification'];
        $user_verification_code = User::where('id',Auth::user()->id)->value('verification_code');

        if($user_verification_code == $code){
           User::where('id',Auth::user()->id)->update([ 'verification_code' => 0, 'account_state' => 'Verified' ]); 
           return redirect()->back()->with(['success' => 'Your Account Verified']);
        }else{
            return redirect()->back()->with(['code_error' => 'Sorry! Verification Code Not Right,Request New Code Or Contact customer support']);
        }
    }
    public function SignUp(Request $request){

        $loginUserName = $request->input('username');
        $loginPassword = $request->input('password');
        $loginShopID = $request->input('shop_id');

        $data = array(
            'username'=>$loginUserName,
            'password'=>$loginPassword,
            'shop_id'=>$loginShopID
            );
        if(Auth::attempt($data)){
            if (Auth::user()->confirmed != 0) {
                if(Auth::user()->shop->payment_plan != 'demo' || Auth::user()->role === 'super_admin'){
                    $thisMonth = Carbon::now()->month;
                    Shop::where('id',Auth::user()->shop_id)->update([ 'bulk_month' => $thisMonth ]);
                }
                User::where('id',Auth::user()->id)->update(['login_state' => 'online']);
                return redirect('/');
            }else{
                Auth::logout();
                return redirect('/sri-lanka-web-based-pos-system-software-signup')->with('error','Cannot override maximum user count allocated to your payment plan,If need more users please contact customer support');
            }
        }else{

            return redirect()->back()->with('login-error','User Name,Shop ID or Password Incorrect.for Help Please contact us');
        }
    }
    public function ManageUsers(){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin') {

                $shops = Shop::all();
                $users = User::all();

                return view('Manage-users/manage-user',compact('shops','users'));
            }else{
                return redirect('/home')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function VerifyShop(Request $request){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin') {

                $VerifyShop_id = $request['verifyshop'];

                Shop::where('id',$VerifyShop_id)
                ->update([
                    'state' => 'Verified',
                    ]);
            }else{
                return redirect('/home')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function VerifyShopTest(Request $request){
        if (Auth::check() && Auth::user()->role ==='super_admin') {

                $VerifyShop_id = $request['verifyshop_id'];
                $state_change = $request['state_change'];

                Shop::where('id',$VerifyShop_id)
                ->update([
                    'state' => $state_change,
                    ]);
           
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

     public function UpdateShopDetails(Request $request){
        if (Auth::check()) {

                $edit_shop_id = $request['edit_shop_id'];
                $shop_name = $request['shop_name'];
                $owner_name = $request['owner_name'];
                $owner_nic = $request['owner_nic'];
                $monthly_rate = $request['monthly_rate'];
                $vat = $request['vat'];
                $br = $request['br'];
                $contact_no = $request['contact_no'];
                $payment_plan = $request['payment_plan'];
                if(substr($contact_no,0,1) == 0){
                    $sender_no = substr_replace($contact_no,"94",0,1);
                }else if(substr($contact_no,0,2) == 94){
                    $sender_no = $contact_no;
                }

            if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin'){
                
                Shop::where('id',$edit_shop_id)
                ->update([
                    'shop_name' => $shop_name,
                    'owner' => $owner_name,
                    'owner_nic' => $owner_nic,
                    'monthly_rate' => $monthly_rate,
                    'VAT' => $vat,
                    'BR' => $br,
                    'contact_no' => $sender_no,
                    'payment_plan' => $payment_plan,
                    ]);
                return redirect()->back()->with('message','Shop Updated ');
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function VerifyUsers(Request $request){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin') {

                $Verify_user_id = $request['verify_user_id'];
                $delete_user_id = $request['delete_user_id'];
                $block_user_id = $request['block_user_id'];
                $unblock_user_id = $request['unblock_user_id'];
                $promote_user_id = $request['promote_user_id'];
                $demote_user_id = $request['demote_user_id'];

                if($Verify_user_id){
                    User::where('id',$Verify_user_id)
                    ->update([
                        'account_state' => 'Verified',
                        ]);
                }else if($delete_user_id){
                    User::where('id',$delete_user_id)
                    ->update([
                        'account_state' => 'Delete',
                        ]);
                }
                else if($block_user_id){
                    User::where('id',$block_user_id)
                    ->update([
                        'block_state' => 'Block',
                        ]);
                }
                else if($unblock_user_id){
                    User::where('id',$unblock_user_id)
                    ->update([
                        'block_state' => 'Unblock',
                        ]);
                }
                else if($promote_user_id){
                    User::where('id',$promote_user_id)
                    ->update([
                        'role' => 'admin',
                        ]);
                }
                else if($demote_user_id){
                    User::where('id',$demote_user_id)
                    ->update([
                        'role' => 'user',
                        ]);
                }

            }else{
                return redirect('/home')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function DeleteShopTest(Request $request){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin') {
                $delete_shop_id = $request['delete_shop_id'];
                Shop::where('id',$delete_shop_id)->delete();
            }else{
                return redirect('/home')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function BulkChangeTest(Request $request){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin'){
                $bulk_change_shop_id = $request['bulk_change_shop_id'];
                $change_state = $request['change_state'];
                $thisMonth = Carbon::now()->month;
                Shop::where('id',$bulk_change_shop_id)->update([ 'bulk' => $change_state,'bulk_month' => $thisMonth, ]);
            }else{
                return redirect('/home')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function NotificationChangeTest(Request $request){
        if (Auth::check()) {
            if (Auth::user()->role == 'super_admin'){
                $notification_change_shop_id = $request['notification_change_shop_id'];
                $change_state = $request['change_state_for_notification'];
                Shop::where('id',$notification_change_shop_id)->update([ 'notification' => $change_state, ]);
            }else{
                return redirect('/home')->with('error','Sorry Access Denied'); 
            }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function GetProfile()
    {
        if (Auth::check()) {
            return view('user-profile');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function photoUpload(Request $request)
    {
        if($request->hasFile('shop_logo')){
            $user = Auth::user()->shop_id;
            
            $old_image = Shop::where('id',$user)->value('logo');
           
    
            if( $old_image !== 'shop-logo.png'){
                @unlink('shop/'.$old_image);
                
                $shop_logo = $request->file('shop_logo');
                $fileName = time().'.'. $shop_logo->getClientOriginalExtension();
                Image::make($shop_logo)->resize(150,140)->encode('jpg',75)->save(public_path('/shop/'.$fileName));

                Shop::where('id',Auth::user()->shop_id)
                    ->update(['logo'=>$fileName]);

                    return redirect()->back()->with('success','Shop Logo Changed');
            }else{
                $shop_logo = $request->file('shop_logo');
                $fileName = time().'.'. $shop_logo->getClientOriginalExtension();
                Image::make($shop_logo)->resize(150,140)->encode('jpg',75)->save(public_path('/shop/'.$fileName));

                Shop::where('id',Auth::user()->shop_id)
                    ->update(['logo'=>$fileName]);
                return redirect()->back()->with('success','Shop Logo Changed');
            }
        }
        if($request->hasFile('profile_pic')){
            $user = Auth::user()->id;
            
            $old_image = User::where('id',$user)->value('profile_pic');
           
    
            if( $old_image !== 'user.png'){
                @unlink('user/'.$old_image);
                
                $profile_pic = $request->file('profile_pic');
                $fileName = time().'.'. $profile_pic->getClientOriginalExtension();
                Image::make($profile_pic)->resize(140,150)->encode('jpg',75)->save(public_path('/user/'.$fileName));

                User::where('id',Auth::user()->id)
                    ->update(['profile_pic'=>$fileName]);

                    return redirect()->back()->with('success','Profile Picture Changed');
            }else{
                $profile_pic = $request->file('profile_pic');
                $fileName = time().'.'. $profile_pic->getClientOriginalExtension();
                Image::make($profile_pic)->resize(140,150)->encode('jpg',75)->save(public_path('/user/'.$fileName));

                User::where('id',Auth::user()->id)
                    ->update(['profile_pic'=>$fileName]);

                    return redirect()->back()->with('success','Profile Picture Changed');
            }
        }

    }

    public function UpdateUser(Request $request){
        if (Auth::check()) {

                $shop_name = $request['shop_name'];
                $owner_name = $request['owner_name'];
                $owner_nic = $request['owner_nic'];
                $address = $request['address'];
                $city = $request['city'];
                $postal_code = $request['postal_code'];
                $country = $request['country'];
                $contact_no = $request['contact_no'];
                $br = $request['br'];
                $vat = $request['vat'];
            if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin'){
                
                Shop::where('id',Auth::user()->shop_id)
                ->update([
                    'shop_name' => $shop_name,
                    'owner' => $owner_name,
                    'owner_nic' => $owner_nic,
                    'address' => $address,
                    'city' => $city,
                    'postal_code' => $postal_code,
                    'country' => $country,
                    'contact_no' => $contact_no,
                    'BR' => $br,
                    'VAT' => $vat,
                    ]);
            }

            return redirect()->back()->with('success','Profile Successfully Updated');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }

    public function PrinterUserSettings(Request $request){
        if (Auth::check()) {
                $ip = $request['ip'];
                $username = $request['username'];
                $confirm = $request['old_password'];
                $printing_type = $request['printer_type'];
           
                if ($username  !== User::where('id',Auth::user()->id)->value('username') ) {
                    
                    User::where('id',Auth::user()->id)
                        ->update([
                            'username' => $username
                            ]);
                    return redirect()->back()->with('success','Username Successfully Updated');
                }

                if ($ip !== User::where('id',Auth::user()->id)->value('user_printer')) {
                    User::where('id',Auth::user()->id)->update(['user_printer' => $ip]);
                    return redirect()->back()->with('success','Printer Details Successfully Updated');
                }
                if ($printing_type !== User::where('id',Auth::user()->id)->value('print_type')) {
                    User::where('id',Auth::user()->id)->update(['print_type' => $printing_type]);
                    return redirect()->back()->with('success','Printer Type Successfully Updated');
                }
                if($request['confirm_password'] != null){
                    if (Hash::check($confirm,Auth::user()->password)){
                        User::where('id',Auth::user()->id)
                            ->update([
                                'password' => bcrypt($request['confirm_password'])
                        ]);
                        return redirect()->back()->with('success','Password Successfully Updated');    
                    }else{
                        return redirect()->back()->with('error','Old Password is Wrong');
                    }
                }
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
    public function ManageUserCollection($id)
    {
        $user = User::where('shop_id',$id)->get();
        return $user;
    }
    public function ChangeRole(Request $request)
    {
        $change_role = $request['change_role'];
        $user_id = $request['change_role_user_id'];

        User::where('id',$user_id)->update([ 'role' => $change_role ]);
        if($request['active_user_id']){
            User::where('id',$request['active_user_id'])->update([ 'confirmed' => 1 ]);
            $rate = Shop::where('id',$request['active_user_shop_id'])->value('monthly_rate');
            $new_user_price = 1000;
            $new_rate = $rate + $new_user_price;
            Shop::where('id',$request['active_user_shop_id'])->update([ 'monthly_rate' => $new_rate ]);
            $user = User::where('id',$request['active_user_shop_id'])->get();
            return response()->json(['error' => true,'data' => 'Batch No Is Incorrect']);
        }
    }
}
