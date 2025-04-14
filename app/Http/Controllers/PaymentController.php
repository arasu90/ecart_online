<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\OrderMaster;
use App\Models\PaymentHistory;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use App\CommonFunction;
use App\Mail\OrderPlacedMailNotification;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    use CommonFunction;
    public function createOrder(Request $request)
    {
        
        $api = new Api(getenv('RAYZORPAY_API_KEY_ID'), getenv('RAYZORPAY_API_KEY_SECRET'));

        CartItem::where('user_id', Auth::user()->id)->where('cart_status',1)->update(['cart_status' => 2]);

        $orderamt = $this->getCartValue();
        $receipt = "ecart_".Uuid::randomNumber();
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
                'receipt' => $receipt,
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
                'receipt' => $receipt,
            ]);

        } catch (\Exception $e) {

            Log::channel('payment')->error('create order failed', [
                'user_id' => Auth::user()->id,
                'orderamt' => $orderamt,
                'currency' => 'INR',
                'receipt' => $receipt,
                'errormsg' => $e->getMessage(),
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

        $data['razorpay_payment_id'] = $paymentId;
        $data['razorpay_order_id'] = $orderId;
        $data['razorpay_signature'] = $signature;
        $data['create_order_amt'] = $request->input('amount');
        $data['create_order_id'] = $request->input('order_id');
        $data['create_order_currency_type'] = $request->input('currency');
        $data['create_order_receipt'] = $request->input('receipt');
        $data['address_id'] = $request->input('address_id');
        
        // Verify the payment signature
        $api = new Api(getenv('RAYZORPAY_API_KEY_ID'), getenv('RAYZORPAY_API_KEY_SECRET'));

        try {
            $payment_data = $api->payment->fetch($paymentId);
            $paymentMode = $payment_data->method;

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ]);
            
            $payment_data = $api->payment->fetch($paymentId);
            $paymentMode = $payment_data->method;

            Log::channel('payment')->error('payment callback success', [
                'user_id' => Auth::user()->id,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'status' => 'success',
                'paymentMode' => $paymentMode,
                'payment_data' => var_export($payment_data, true),
            ]);

            CartItem::where('user_id', Auth::user()->id)->where('cart_status',2)->update(['cart_status' => 3]);

            $data['payment_mode'] = $paymentMode;
            
            $ordermaster_id = $this->insertOrders($data);

            $data['order_date'] = date('Y-m-d H:i:s');
            $data['order_master_id'] = $ordermaster_id;
            $data['razorpay_status'] = 'success';
            $data['razorpay_message'] = 'success';
            $data['payment_status'] = '2';
            $this->insertPaymentHistory($data);
            
            return response()->json(['status' => 'success','message'=>'success']);
        } catch (\Exception $e) {

            Log::channel('payment')->error('payment callback failed', [
                'user_id' => Auth::user()->id,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'status' => 'failed',
                'message' => $e->getMessage(),
                'payment_data' => var_export($payment_data, true),
            ]);

            $data['order_date'] = '';
            $data['order_master_id'] = '0';
            $data['razorpay_status'] = 'failure';
            $data['razorpay_message'] = $e->getMessage();
            $data['payment_status'] = '3';
            $data['payment_mode'] = 'failed';
            
            $this->insertPaymentHistory($data);

            return response()->json(['status' => 'failure', 'message' => $e->getMessage()]);
        }
    }

    public function getCartValue()
    {
        $cart_items = CartItem::where('user_id', Auth::user()->id)->where('cart_status',2)->get();
        $subtotal = 0;
        
        $website_data_value = $this->getWebsiteData();
        $delivery_free_amt = number_format($website_data_value->delivery_free_charge,0);
        $shipping = $website_data_value->delivery_charge;
        

        foreach ($cart_items as $value) {
            $value->total_value = $value->product_qty * $value->product->product_price;
            $subtotal += $value->total_value;
        }
        if ($subtotal == 0 || $subtotal > $delivery_free_amt) {
            $shipping = 0;
        }
        $total_value = $subtotal + $shipping;
        Log::channel('payment')->info('total val'.$total_value);
        return $total_value;
    }

    public function insertPaymentHistory($data):void
    {
        PaymentHistory::create([
            'user_id' => Auth::user()->id,
            'order_master_id' => $data['order_master_id'],
            'order_date' => $data['order_date'],
            'create_order_id' => $data['create_order_id'],
            'create_order_amt' => $data['create_order_amt']/100,
            'create_order_currency_type' => $data['create_order_currency_type'],
            'create_order_receipt' => $data['create_order_receipt'],
            'razorpay_payment_id' => $data['razorpay_payment_id'],
            'razorpay_order_id' => $data['razorpay_order_id'],
            'razorpay_signature' => $data['razorpay_signature'],
            'razorpay_status' => $data['razorpay_status'],
            'razorpay_message' => $data['razorpay_message'],
            'payment_mode' => $data['payment_mode'],
            'payment_status' => $data['payment_status'],
        ]);
    }

    public function insertOrders($data)
    {
        $billing_address = $this->getAddressByID($data['address_id']);
        $ordermaster = new OrderMaster();
        $ordermaster->user_id = Auth::user()->id;
        $ordermaster->order_date = date('Y-m-d H:i:s');
        $ordermaster->payment_mode = $data['payment_mode'];
        $ordermaster->payment_reference_no = $data['razorpay_payment_id'];
        $ordermaster->billing_details = $billing_address;
        $ordermaster->order_status = 1;
        $ordermaster->payment_status = 1;
        $ordermaster->save();

        $website_data_value = $this->getWebsiteData();

        $over_all_item_value = 0;
        $over_all_discount_amt = 0;
        $over_all_sub_total = 0;
        $over_all_tax_amt = 0;
        $over_all_total_amt = 0;
        $over_all_shipping_amt = $website_data_value->delivery_charge;
        $delivery_free_charge = $website_data_value->delivery_free_charge;
        
        $over_all_net_total_amt = 0;
        $cart_items = CartItem::with('product')->where('user_id', Auth::user()->id)->where('cart_status',3)->get();
        foreach ($cart_items as $value) {
            $orderitems = new OrderItem();
            $orderitems->order_master_id = $ordermaster->id;
            $orderitems->user_id = Auth::user()->id;
            $orderitems->cart_id = $value->id;
            $orderitems->order_date = date('Y-m-d H:i:s');
            $orderitems->product_id = $value->product_id;
            $orderitems->product_name = $value->product->product_name;
            $orderitems->product_qty = $value->product_qty;
            $orderitems->product_mrp = $value->product->product_mrp;
            $orderitems->product_price = $value->product->product_price;

            $normal_price = $this->exclusiveProductPrice($value->product->product_price, $value->product->product_tax);

            $orderitems->item_value = $normal_price * $value->product_qty;
            $orderitems->discount_per = '0';
            $orderitems->discount_amt = '0';
            $orderitems->sub_total = $orderitems->item_value - $orderitems->discount_amt;
            $orderitems->tax_per = $value->product->product_tax;
            $orderitems->tax_amt = $value->product->product_tax * $orderitems->item_value/100;
            $orderitems->total_amt = $orderitems->sub_total + $orderitems->tax_amt;
            $orderitems->order_status = 1;
            $orderitems->payment_status = 1;
            $orderitems->payment_mode = $data['payment_mode'];
            $orderitems->payment_reference_no = $data['razorpay_payment_id'];
            $orderitems->billing_details = $billing_address;

            $orderitems->save();

            $over_all_item_value += $orderitems->item_value;
            $over_all_discount_amt += $orderitems->discount_amt;
            $over_all_sub_total += $orderitems->sub_total;
            $over_all_tax_amt += $orderitems->tax_amt;
            $over_all_total_amt += $orderitems->total_amt;
        }

        if ($over_all_total_amt > $delivery_free_charge) {
            $over_all_shipping_amt = 0;
        }
        $over_all_net_total_amt += $over_all_total_amt + $over_all_shipping_amt;

        OrderMaster::where('id', $ordermaster->id)->update(['item_value' => $over_all_item_value, 'discount_amt' => $over_all_discount_amt,'sub_total' => $over_all_sub_total, 'tax_amt'=>$over_all_tax_amt, 'total_amt' => $over_all_total_amt, 'shipping_amt' => $over_all_shipping_amt, 'net_total_amt' => $over_all_net_total_amt]);

        // for mail sending purpose
        $ordermaster_data = OrderMaster::with('orderItems.product', 'user')->where('id', $ordermaster->id)->first();

        CartItem::where('user_id', Auth::user()->id)->where('cart_status',3)->update(['order_id' => $ordermaster->id,'cart_status' => 4]);
        
        // mail log add queue for send order notifications
        Log::channel('payment')->info("ordermail send to user", [
            'user_id' => Auth::user()->id,
            'order_id' => $ordermaster->id,
            'email' => $ordermaster_data->user->email,
        ]);
        
        $queue_id = Mail::to($ordermaster_data->user->email)->send(new OrderPlacedMailNotification($ordermaster_data));

        Log::channel('payment')->info("sending mail", [
            'queue_id' => $queue_id,
        ]);

        return $ordermaster->id;
    }
}
