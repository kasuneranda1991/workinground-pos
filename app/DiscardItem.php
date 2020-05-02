<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscardItem extends Model
{
    public function products()
    {
    	return $this->belongsTo('App\Product');
    }
    // public function userDI()
    // {
    // 	return $this->belongsTo('App\User');
    // }
}
