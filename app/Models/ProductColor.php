<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function colors()
    {
        return $this->belongsTo(Color::class,'color_id');
    }
}
