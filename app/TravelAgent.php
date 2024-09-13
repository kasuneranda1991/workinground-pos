<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelAgent extends Model
{
    public function reservation()
    {
    	return $this->hasOne('App\Reservaion');
    }
}
