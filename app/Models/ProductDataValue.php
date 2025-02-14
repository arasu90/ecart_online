<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDataValue extends Model
{
    public function product_data(){
        return $this->belongsTo(ProductData::class,"field_id", 'id');
    }
}
