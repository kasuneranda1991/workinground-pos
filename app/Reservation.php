<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function guest_detail()
    {
    	return $this->hasOne('App\GuestDetail');
    }
    public function reservation_payment()
    {
    	return $this->hasOne('App\ReservationPayment');
    } 
    public function attachments()
    {
    	return $this->hasMany('App\Attachment');
    }
    public function travel_agent()
    {
    	return $this->belongsTo('App\TravelAgent');
    }
}
