<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    public function defaultImg() {
        return $this->hasOne(ProductImg::class,'product_id')->orderby('default_img','DESC')->withDefault([
            'product_img' => 'img/default_image.jpg',
        ]);
    }

    public function product_img() {
        return $this->hasMany(ProductImg::class,'product_id')->orderby('default_img','desc');
    }

    public function product_review() {
        return $this->hasMany(ProductReview::class);
    }

    public function product_field_data() {
        return $this->hasManyThrough(ProductData::class,ProductDataValue::class,'product_id','id','id','field_id')->with(['product_field_value']);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function cart_item() {
        return $this->hasOne(CartItem::class)->where('user_id', Auth::id())->where('order_id', '0');
    }

}
