<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    use HasFactory;

    protected $fillable = ['image_name', 'product_id'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}
