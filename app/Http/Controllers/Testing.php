<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMailNotification;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Testing extends Controller
{
    public function index()
    {
        $ordermaster_data = OrderMaster::with('orderItems.product', 'user')->where('id', 7)->first();
        
        Log::channel('payment')->info("ordermail send to user", [
            'email' => $ordermaster_data->user->email,
        ]);
        
        $ss = Mail::to($ordermaster_data->user->email)->send(new OrderPlacedMailNotification($ordermaster_data));
        
        Log::channel('payment')->info("ordermail send to user", [
            'order_id' => $ss,
        ]);
        
        dd($ss);
    }
}
