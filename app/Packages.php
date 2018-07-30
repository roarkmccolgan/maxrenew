<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    public function products(){
    	return $this->belongToMany('App\Product', 'package_product', 'package_id', 'product_id');
    }
}
