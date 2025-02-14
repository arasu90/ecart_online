<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = ['order_master_id', 'user_id', 'create_order_id', 'create_order_amt', 'create_order_currency_type', 'create_order_receipt', 'razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature', 'razorpay_status', 'razorpay_message', 'payment_status', 'payment_mode', 'order_date'];
}
