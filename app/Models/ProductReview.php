<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    public function users() {
        return $this->belongsTo(User::class,'created_by');
    }
}
