<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailValue extends Model
{
    use HasFactory;

    public function product_data(){
        return $this->belongsTo(ProductDetailData::class,"product_data_id", 'id');
    }
}

