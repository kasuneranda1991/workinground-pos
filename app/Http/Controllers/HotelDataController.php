<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;  
use App\Shop;
use App\Room;
use App\RoomRate;
use App\TravelAgent;
use App\Country;
use App\Reservation;
use App\GuestDetail;
use App\ReservationPayment;
use App\Attachment;

class HotelDataController extends Controller
{
    public function CurrentRooms()
    {   
        if(Auth::check()){
            return Room::where('shop_id',Auth::user()->shop_id)->get(); 
        }else{
            return redirect()->back()->with('error','access denied');
        }
    }
    public function GetAvailableRooms()
    {
        if(Auth::check()){
            return Room::where('shop_id',Auth::user()->shop_id)->where('room_state','vacant')->get();
        }else{
            return redirect()->back()->with('error','access denied');
        }
    }
    public function GetCountries()
    {
        if(Auth::check()){
            return Country::all();
        }else{
            return redirect()->back()->with('error','access denied');
        }
    }
    public function GetTravelAgentData()
    {
        if(Auth::check()){
            return TravelAgent::where('state','Confirmed')->orderBy('name','ASC')->get();
        }else{
            return redirect()->back()->with('error','access denied');
        }
    }
     public function GetRoomsRates()
    {
        if(Auth::check()){
            return RoomRate::where('shop_id',Auth::user()->shop_id)->get();
        }else{
            return redirect()->back()->with('error','access denied');
        }
    }
    // public function GetReservationForCheckIn(Request $request)
    // {
    //     if(Auth::check()){
    //         $today = Carbon::parse(Carbon::now())->format('Y-m-d');
    //         $reservations = Reservation::where('shop_id',Auth::user()->shop_id)->where('checkin',$today)->get()->load('guest_detail');
            
    //         if($request->ajax()){
    //             return response()->json($reservations);
    //         }else{
    //             return $reservations;
    //         }
    //     }else{
    //         return redirect()->back()->with('error','access denied');
    //     }
    // }
    public function CreateNewRate(Request $request)
    {
    	$reservation_type = $request['reservation_type'];
    	$rate_room_type = $request['rate_room_type'];
    	$rate_bed_type = $request['rate_bed_type'];
    	$local_rate = $request['local_rate'];
    	$foreign_rate = $request['foreign_rate'];

    	$rateCode = $reservation_type.$rate_room_type.$rate_bed_type;

    	$new_rate = new RoomRate();

    	$new_rate->rateCode = $rateCode;
    	$new_rate->local_rate = $local_rate;
    	$new_rate->foreign_rate = $foreign_rate;
    	$new_rate->user_id =Auth::user()->id;
    	$new_rate->shop_id =Auth::user()->shop_id;
    	$new_rate->save();

    	return redirect()->back()->with('success','New Rate Created....... ');	
    }

    public function ConfirmReservationDetails(Request $request)
    {
        $reservation_confirm_payment_id = $request['confirm_payment_id'];
        $reject_payment_id = $request['reject_payment_id'];
        $actionType = $request['type'];
        if($actionType == 'confirmed'){
            ReservationPayment::where('id',$reservation_confirm_payment_id)->where('shop_id',Auth::user()->shop_id)->update([
                'state'=>'confirmed',
                'approved_by' =>Auth::user()->id,
            ]);

            return response()->json(['success' => true,'data' => 'Payment Details Confirmed']);
        }else if($actionType == 'rejected'){
            if($request['reason']){
                ReservationPayment::where('id',$reject_payment_id)->where('shop_id',Auth::user()->shop_id)->update([
                    'state'=>'rejected',
                    'approved_by' => Auth::user()->id,
                    'remark' => $request['reason'],
                ]);
               return response()->json(['success' => true,'data' => 'Payment Details Rejected']);
           }else{
            return response()->json(['error' => true,'data' => 'You cannot perform this action without clearly state the reson for reject']);
           }
        }else{
            return response()->json(['error' => true,'data' => 'Opps sonthing went wrong']);
        }
    }
}
