<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public function Product()
    {
    	 return $this->belongsTo('App\Product');
    }
}
