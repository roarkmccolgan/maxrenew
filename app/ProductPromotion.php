<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPromotion extends Model
{
    public function product(){
    	return $this->belongs('App\Products');
    }

    public function product(){
    	return $this->hasOne('App\Order');
    }
}
