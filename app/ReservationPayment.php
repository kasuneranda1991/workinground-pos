<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationPayment extends Model
{
    //belongsTo
    public function reservation()
    {
    	return $this->belongsTo('App\Reservation');
    }
}
