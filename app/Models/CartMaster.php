<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartMaster extends Model
{
    use HasFactory;

    public function cart_count()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function cart_item_list()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
