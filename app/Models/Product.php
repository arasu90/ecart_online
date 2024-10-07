<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'category_id', 'product_rate'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function product_img() {
        return $this->hasMany(ProductImg::class,'product_id')->orderby('default_img','desc');
    }


    public function product_img_2() {
        return $this->hasMany(ProductImg::class,'product_id')->where('default_img',1);
    }

    public function product_review() {
        return $this->hasMany(ProductReview::class);
    }
    
    public function defaultImg() {
        return $this->hasOne(ProductImg::class,'product_id')->where('default_img',1)->withDefault([
            'image_name' => 'img/default_image.jpg',
        ]);
    }

    public function product_colors() {
        return $this->hasMany(ProductColor::class,'product_id');
    }

}
