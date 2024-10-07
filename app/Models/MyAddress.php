<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyAddress extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',       // Add 'id' here to allow mass assignment
        'user_id',  // Must include 'user_id' to allow mass assignment
        'contact_name',
        'contact_mobile',
        'address_line1',
        'address_line2',
        'address_city',
        'address_state',
        'address_pincode',
        'make_default',

    ];
}
