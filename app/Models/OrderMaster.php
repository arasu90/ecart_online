<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
