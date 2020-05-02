<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
// use App\Shop;
// use App\Rate;
// use App\ItemType;
// use App\Product;
// use App\Stock;
// use App\Expence;
// use App\customer;
// use App\Batch;
// use App\Bill;
// use App\Payment;
// use App\User;
// use App\RoomRate;
use App\Reservation;
// use App\TravelAgent;
// use App\GuestDetail;
// use App\Booking;
use App\Room;
// use App\Country;

class CheckInOutController extends Controller
{
    public function MakeGuestCheckin(Request $request)
    {
    	$checkinReservation_id = $request['reservation_id'];
    	$checkinTo = $request['check_in_to'];
    	$checkOutAfter = $request['check_out_after'];
    	$roomNumbers = $request['rooms'];
    	$c = '';
    	$roomCount = count($roomNumbers);
    	$reservationRoomCount = Reservation::where('shop_id',Auth::user()->shop_id)->where('id',$checkinReservation_id)->value('room_count');
    	if($reservationRoomCount == $roomCount){
    		foreach ($roomNumbers as $value) {
	    		Room::where('shop_id',Auth::user()->shop_id)->where('id',$value)->update([
	    			'room_state' =>'occupied',
                    'reservation_id' => $checkinReservation_id,
	    		]);
	    		$c = $c.Room::where('shop_id',Auth::user()->shop_id)->where('id',$value)->value('room_no').',';
	    	}
	    	Reservation::where('shop_id',Auth::user()->shop_id)->where('id',$checkinReservation_id)->update([
	    		'checkinTo' => $checkinTo,
	    		'checkOutAfter' => $checkOutAfter,
	    		'roomNo' => $c,
	    		'state' => 'checked',
	    	]);
	    	return response()->json(['success' => true,'data' => 'Guest Checked In Successfull']);
    	}else if( $roomCount == 0){
    		return response()->json(['error' => true,'data' => 'Please Select Room']);	
    	}else{
    		return response()->json(['error' => true,'data' => 'Cannot Override Reservation Room Amount ']);	
    	}
    }

    public function MakeGuestAsNoShow(Request $request)
    {
    	$checkinReservation_id = $request['reservation_id'];
    	
    	Reservation::where('shop_id',Auth::user()->shop_id)->where('id',$checkinReservation_id)->update([
    		'state' => 'No-Show',
    	]);
	    return response()->json(['success' => true,'data' => 'Guest Mark as No Show']);
    }
}
