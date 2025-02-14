<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{
    public function product_field_value(){
        return $this->belongsTo(ProductDataValue::class,'id',"field_id");
    }
}
