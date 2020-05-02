<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function stock()
    {
        return $this->hasOne('App\Stock');
    }
    public function Batch()
    {
        return $this->hasOne('App\Batch');
    }
    public function Bill()
    {
        return $this->hasOne('App\Bill');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
     public function itemtype()
    {
        return $this->belongsTo('App\ItemType');
    }
    public function discard_item()
    {
        return $this->hasMany('App\DiscardItem','product_id');
    }
}
