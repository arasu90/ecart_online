<?php

namespace App\Http\Controllers;

use App\Models\OrderMaster;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $api = new Api(getenv('RAYZORPAY_API_KEY_ID'), getenv('RAYZORPAY_API_KEY_SECRET'));
        $orderamt = session('orderamt');
        $receipt = getenv('DEVNAME').Uuid::randomNumber();
        // dd($orderamt);
        // Create an order
        $orderData = [
            'amount' => $orderamt * 100, // Amount is in paise
            'currency' => 'INR',
            'receipt' => $receipt,
            'payment_capture' => 1 // Automatically capture the payment
        ];

        try {
            Log::channel('payment')->info('create order API data', [
                'user_id' => Auth::user()->id,
                'orderamt' => $orderamt,
                'currency' => 'INR',
                'receipt' => $receipt
            ]);
            
            $order = $api->order->create($orderData);
            
            Log::channel('payment')->info('create order successful', [
                'user_id' => Auth::user()->id,
                'id' => $order->id,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'receipt' => $receipt,
                'status' => 'success',
            ]);

            return response()->json([
                'id' => $order->id,
                'amount' => $order->amount,
                'currency' => $order->currency,
            ]);

        } catch (\Exception $e) {
            Log::channel('payment')->error('create order failed', [
                'user_id' => Auth::user()->id,
                'orderamt' => $orderamt,
                'currency' => 'INR',
                'receipt' => $receipt,
                'amount' => $e->getMessage(),
                'status' => 'failed 500',
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        Log::channel('payment')->error('payment callback data', [
            'user_id' => Auth::user()->id,
            'request' => $request
        ]);
        // Get payment ID, order ID and signature
        $paymentId = $request->input('razorpay_payment_id');
        $orderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        // Verify the payment signature
        $api = new Api(getenv('RAYZORPAY_API_KEY_ID'), getenv('RAYZORPAY_API_KEY_SECRET'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ]);

            Log::channel('payment')->error('payment callback success', [
                'user_id' => Auth::user()->id,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'status' => 'success',
            ]);

            Session::put('thankyou_success',"Successfully");
            return response()->json(['status' => 'success','message'=>'success']);
        } catch (\Exception $e) {

            Log::channel('payment')->error('payment callback failed', [
                'user_id' => Auth::user()->id,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);

            Session::put('thankyou_failed',"failed order payment");
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()]);
        }

        
    }

    public function makepayment(Request $request)
    {
        Log::channel('payment')->info('Makepayment Page: ', [
            'user_id' => Auth::user()->id,
            'requested_id' => $request->input('makeorder'),
            'ordernumber' => $request->input('accessorder')
        ]);
        $ordermaster = OrderMaster::findorfail($request->input('makeorder'));
        Session::put('orderamt', $ordermaster->total_amt);
        Log::channel('payment')->info('Makepayment DB: ', [
            'user_id' => Auth::user()->id,
            'requested_id' => $request->input('makeorder'),
            'ordernumber' => $request->input('accessorder'),
            'ordermaster' => $ordermaster,
        ]);
        return view('page.makepayment', compact('ordermaster'));
    }
}
