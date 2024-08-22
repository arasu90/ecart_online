<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    public function cart_master()
    {
        return $this->belongsTo(CartMaster::class);
    }

    public function product_list()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
