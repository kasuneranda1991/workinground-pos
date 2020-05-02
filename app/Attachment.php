<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function reservation()
    {
    	return $this->belongsTo('App\Reservation');
    }
}
