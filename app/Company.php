<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function product()
    {
        return $this->hasMany('App\Product');
    }
}
