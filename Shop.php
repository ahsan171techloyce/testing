<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Shop extends Model
{
    //
	
	/**
     * The products that belong to the shop.
     */
    public function products()
    {
          return $this->belongsToMany('App\Product', 'shopproducts', 'shop_id', 'product_id');
         
    }
}
