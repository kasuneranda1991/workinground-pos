<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Image;

use Carbon\Carbon;  
use App\Shop;
use App\Room;
use App\RoomRate;
use App\GuestDetail;
use App\Reservation;
use App\ReservationPayment;
use App\TravelAgent;
use App\Attachment;
use App\Booking;

class ReservationController extends Controller
{
    public function MakeNewReservation(Request $request)
    {
    	// form data start
    	$first_name = $request['first_name'];
    	$last_name = $request['last_name'];
    	$email = $request['email'];
    	$contact_no = $request['contact_no'];
    	$passport_no = $request['passport'];
    	$country = $request['country'];
    	$travel_agent = $request['travel_agent'];
    	$tour_no = $request['tour_no'];
    	$check_in = $request['check_in'];
    	$check_out = $request['check_out'];
    	$reservation_type = $request['reservation_type'];
    	$reservation_room_type = $request['reservation_room_type'];
    	$reservation_bed_type = $request['reservation_bed_type'];
        $reservationRateCode = $request['reservationRateCode'];
        $rooms_no = $request['rooms_no'];
    	$address = $request['address'];
    	$room_count = $request['room_count'];
    	$adult_count = $request['adult_count'];
    	$child_count = $request['child_count'];
        $night_count = $request['night_count'];
        $rate = $request['rate'];
    	$discount = $request['reservation_discount'];
    	$special_note = $request['special_note'];
        // $check_in_to = $request['check_in_to'];
        // $check_out_after = $request['check_out_after'];
        $travelagent_id = $request['travel_agent'];
    	
        $payment_collect = $request['payment_collect'];
        $advance_payment = $request['advance_payment'];
        if($discount != 0 || $discount != null ){
            $total_reservation_payment = (($rate*$night_count*$room_count)/100)*(100 - $discount);
        }else{
            $total_reservation_payment = $rate*$night_count*$room_count;
        }

    	// form data end

        // check previous reservation details start
        $reservation_count = Reservation::where('shop_id',Auth::user()->shop_id)->count();
        if($reservation_count === 0){
            $new_Ref_No = 1;
        }else{
            $lastReservationRef = Reservation::where('shop_id',Auth::user()->shop_id)->OrderBy('created_at','DESC')->value('reservation_ref');
            $new_Ref_No = $lastReservationRef + 1;
        }
        // check previous reservation details end

        // check previous reservation payment details start
        $payment_count = Reservation::where('shop_id',Auth::user()->shop_id)->count();
        if($payment_count === 0){
            $new_payment_Ref_No = 1;
        }else{
            $lastPaymentRef = ReservationPayment::where('shop_id',Auth::user()->shop_id)->OrderBy('created_at','DESC')->value('payment_ref');
            $new_payment_Ref_No = $lastPaymentRef + 1;
        }
        // check previous reservation payment details end

    	// start Create reservation entry
    	$newReservation = new Reservation();

        $newReservation->reservation_ref = $new_Ref_No;
        $newReservation->tour_no = $tour_no;
        $newReservation->checkin = $check_in;
        $newReservation->checkout = $check_out;
        $newReservation->rate_code = $reservationRateCode;
        $newReservation->nationality = $country;
        // $newReservation->checkinTo = $check_in_to;
        // $newReservation->checkOutAfter = $check_out_after;
        $newReservation->reservation_Type = $reservation_type;
        $newReservation->reservation_room_type = $reservation_room_type;
        $newReservation->reservation_bed_type = $reservation_bed_type;
        $newReservation->roomNo = $rooms_no;
        $newReservation->room_count = $room_count;
        $newReservation->adult_count = $adult_count;
        $newReservation->child_count = $child_count;
        $newReservation->night = $night_count;
        $newReservation->rate = $rate;
        $newReservation->discount = $discount;
        $newReservation->special_note = $special_note;
        $newReservation->state = 'pending';
        $newReservation->shop_id = Auth::user()->shop_id;
        $newReservation->user_id = Auth::user()->id;
    	$newReservation->travelagent_id = $travelagent_id;
        $newReservation->save();
    	// end Create reservation entry	

    	// start Create reservation payment entry
    	$newReservationPayment = new ReservationPayment();
        $newReservationPayment->payment_ref = $new_payment_Ref_No;
        $newReservationPayment->payment_state = 'Incomplete';
        $newReservationPayment->collect_method = $payment_collect;
        $newReservationPayment->advance_payment = $advance_payment;
        $newReservationPayment->discount = $discount;
        $newReservationPayment->total_payment = $total_reservation_payment;
        $newReservationPayment->state = 'pending';
        $newReservationPayment->user_id = Auth::user()->id;
        $newReservationPayment->shop_id = Auth::user()->shop_id;
        $newReservationPayment->reservation_id = Reservation::where('user_id',Auth::user()->id)
                                                            ->where('shop_id',Auth::user()->shop_id)
                                                            ->where('reservation_ref',$new_Ref_No)
                                                            ->value('id');        
        $newReservationPayment->save();
    	// end Create reservation payment entry
    	
    	// start Create reservation guest entry
    	$newGuest = new GuestDetail();
        $newGuest->first_name = $first_name;    
        $newGuest->last_name = $last_name;  
        $newGuest->email = $email;  
        $newGuest->contact_no = $contact_no;    
        $newGuest->passport_no = $passport_no;  
        $newGuest->country = $country;  
        $newGuest->address = $address;  
        $newGuest->reservation_id = Reservation::where('user_id',Auth::user()->id)
                                                            ->where('shop_id',Auth::user()->shop_id)
                                                            ->where('reservation_ref',$new_Ref_No)
                                                            ->value('id');
        $newGuest->user_id = Auth::user()->id;  
        $newGuest->shop_id = Auth::user()->shop_id;
        $newGuest->save();	
        // end Create reservation guest entry

        // start Create reservation attachment
        // $advance_payment_voucher = $request['advance_payment_voucher'];
        // $reservation_voucher = $request['reservation_voucher'];

        if($request->hasFile('advance_payment_voucher')){
            $advance_payment_voucher = $request->file('advance_payment_voucher');
            $filename = time().'.'. $advance_payment_voucher->getClientOriginalExtension();
            Image::make($advance_payment_voucher)->save(public_path('/reservation_payment/advance_payment/'.$filename));
            $newAttachment = new Attachment();
            $newAttachment->attachment = $filename;
            $newAttachment->type = 'advance';
            $newAttachment->user_id = Auth::user()->id;
            $newAttachment->shop_id = Auth::user()->shop_id;
            $newAttachment->reservation_id = Reservation::where('user_id',Auth::user()->id)
                                                                ->where('shop_id',Auth::user()->shop_id)
                                                                ->where('reservation_ref',$new_Ref_No)
                                                                ->value('id');
            $newAttachment->reservation_payment_id = ReservationPayment::where('user_id',Auth::user()->id)
                                                            ->where('shop_id',Auth::user()->shop_id)
                                                            ->where('payment_ref',$new_payment_Ref_No)
                                                            ->value('id');
            $newAttachment->save();      
        }

        if($request->hasFile('reservation_voucher')){
            $reservation_voucher = $request->file('reservation_voucher');
            $filename = time().'.'. $reservation_voucher->getClientOriginalExtension();
            Image::make($reservation_voucher)->save(public_path('/reservation_payment/reservation_voucher/'.$filename));
            $newAttachment = new Attachment();
            $newAttachment->attachment = $filename;
            $newAttachment->type = 'reservation';
            $newAttachment->user_id = Auth::user()->id;
            $newAttachment->shop_id = Auth::user()->shop_id;
            $newAttachment->reservation_id = Reservation::where('user_id',Auth::user()->id)
                                                                ->where('shop_id',Auth::user()->shop_id)
                                                                ->where('reservation_ref',$new_Ref_No)
                                                                ->value('id');
            $newAttachment->reservation_payment_id = ReservationPayment::where('user_id',Auth::user()->id)
                                                            ->where('shop_id',Auth::user()->shop_id)
                                                            ->where('payment_ref',$new_payment_Ref_No)
                                                            ->value('id');
            $newAttachment->save();      
        }
        // end Create reservation attachment

        // Start Create Bookings Table entry
        $in = Carbon::createFromFormat('Y-m-d', $check_in);
        $out = Carbon::createFromFormat('Y-m-d', $check_out);        
        $increment = 0;
        $diff = $in->diffInDays($out);
        for ($i = $diff; $i > 0 ; $i--) {
            if($i == $diff){
                // $occupaied_room = Booking::where('date',$in)->where('shop_id',Auth::user()->shop_id)->sum('room_count');
                $newBooking = new Booking();
                $newBooking->date = $in;
                $newBooking->room_count =  $room_count;
                $newBooking->reservation_id = Reservation::where('user_id',Auth::user()->id)
                                                                ->where('shop_id',Auth::user()->shop_id)
                                                                ->where('reservation_ref',$new_Ref_No)
                                                                ->value('id');
                $newBooking->user_id = Auth::user()->id;
                $newBooking->shop_id = Auth::user()->shop_id;
                $newBooking->save();
            }else if($i != $diff){
                $next_date = Carbon::createFromFormat('Y-m-d', $check_in)->addDay($increment);
                // $occupaied_room = Booking::where('date',$next_date)->where('shop_id',Auth::user()->shop_id)->sum('room_count');
                $newBooking = new Booking();
                $newBooking->date = $next_date;
                $newBooking->room_count =$room_count;
                $newBooking->reservation_id = Reservation::where('user_id',Auth::user()->id)
                                                                ->where('shop_id',Auth::user()->shop_id)
                                                                ->where('reservation_ref',$new_Ref_No)
                                                                ->value('id');
                $newBooking->user_id = Auth::user()->id;
                $newBooking->shop_id = Auth::user()->shop_id;
                $newBooking->save();
            }
            $increment++;
        }

    	// End Create Bookings Table entry

        return redirect()->back()->with('success','Reservation Successfull');
    }

    public function EditReservation(Request $request)
    {
        $edit_reservation_id = $request['edit_reservation_id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $contact_no = $request['contact_no'];
        $passport_no = $request['passport'];
        $country = $request['country'];
        $travel_agent = $request['travel_agent'];
        $tour_no = $request['tour_no'];
        $check_in = $request['check_in'];
        $check_out = $request['check_out'];
        $reservation_type = $request['reservation_type'];
        $reservation_room_type = $request['reservation_room_type'];
        $reservation_bed_type = $request['reservation_bed_type'];
        $reservationRateCode = $request['reservationRateCode'];
        $address = $request['address'];
        $room_count = $request['room_count'];
        $adult_count = $request['adult_count'];
        $child_count = $request['child_count'];
        $night_count = $request['night_count'];
        $rate = $request['rate'];
        $discount = $request['reservation_discount'];
        $special_note = $request['special_note'];
        $check_in_to = $request['check_in_to'];
        $check_out_after = $request['check_out_after'];
        $travelagent_id = $request['travel_agent'];
        
        $payment_collect = $request['payment_collect'];
        $advance_payment = $request['advance_payment'];
        if($discount != 0 || $discount != null ){
            $total_reservation_payment = (($rate*$night_count*$room_count)/100)*(100 - $discount);
        }else{
            $total_reservation_payment = $rate*$night_count*$room_count;
        }
        $validityOfReservation = Reservation::where('id',$edit_reservation_id)->where('checkout','>=',Carbon::now())->count();
        if($validityOfReservation != null){
            Reservation::where('id',$edit_reservation_id)->where('shop_id',Auth::user()->shop_id)->update([
            'tour_no' => $tour_no,
            'checkin' => $check_in,
            'checkout' => $check_out,
            'rate_code' => $reservationRateCode,
            // 'nationality' => $country,
            'checkinTo' => $check_in_to,
            'checkOutAfter' => $check_out_after,
            'reservation_Type' => $reservation_type,
            'reservation_room_type' => $reservation_room_type,
            'reservation_bed_type' => $reservation_bed_type,
            'room_count' => $room_count,
            'adult_count' => $adult_count,
            'child_count' => $child_count,
            'night' => $night_count,
            'rate' => $rate,
            'discount' => $discount,
            'special_note' => $special_note,
            // 'travelagent_id' => $travelagent_id,
        ]);

        GuestDetail::where('reservation_id',$edit_reservation_id)->where('shop_id',Auth::user()->shop_id)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'contact_no' => $contact_no,
            'passport_no' => $passport_no,
            // 'country' => $country,
            'address' => $address,
        ]);

        ReservationPayment::where('reservation_id',$edit_reservation_id)->where('shop_id',Auth::user()->shop_id)->update([
            'collect_method'=> $payment_collect,
            'advance_payment' => $advance_payment,
            'discount' => $discount,
            'total_payment' => $total_reservation_payment,
        ]);

        // return redirect()->back()->with('success','Successfull');
        return response()->json(['success' => true,'data' => 'Reservation has been updated']);
        }else{
        // return redirect()->back()->with('error','Successfull');
        return response()->json(['error' => true,'data' => 'You cannot modify previous reservation details']); 
        }
    }
}
