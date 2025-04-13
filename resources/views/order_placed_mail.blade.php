<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation Mail from {{ env('APP_NAME') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color:hsl(300, 22.20%, 96%);
            padding: 20px;
            border-radius: 8px;
        }

        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f1f1;
        }

        .email-header h1 {
            color: #2d3e50;
        }

        .email-content {
            border: 1px solid #ddd;
            padding: 0.2rem;
        }

        .email-content h3 {
            color: #2d3e50;
        }

        .order-summary {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-summary th, .order-summary td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .order-summary th {
            background-color: #f1f1f1;
            color: #333;
        }

        .order-summary td {
            color: #555;
        }

        .order-summary .total {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .email-footer {
            text-align: center;
            margin-top: 20px;
            padding: 20px 0;
            background-color:#a268e1;
            color: #fff;
            border-radius: 8px;
        }

        .email-footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .float-right{
            float: right;
        }
        .header-panel{
            background-color:#a268e1;
            padding: 10px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px 5px 0 0;
        }
        .user-name
        {
            font-size: 20px;
            font-weight: bold;
        }

        .table-body
        {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header-panel">
            <span><img src="{{ asset(env('PAYMENTLOGO')) }}" style="width:20px;border-radius:100%;" alt="">{{ env('APP_NAME') }}</span>
            <span class="float-right">Order Placed</span>
        </div>
        <div class="header-content">
            <p>
                <span class="user-name">Hi, {{ ucwords($order->user->name) }}!</span>
                <span class="float-right">Order Date : {{ $order->order_date }}</span>
            </p>
            <p>
                <span>Your order has been successfully placed.</span>
                <span class="float-right">Order Id : {{ $order->id }}</span>
            </p>
        </div>
        
        <div class="email-content">
            <h4>Delivery Address</h4>
            <p>
                @php
                    $order->billing_details = json_decode($order->billing_details, true)
                @endphp
                {{ ucwords($order->billing_details['name']) }} <br />
                {{ $order->billing_details['phone'] }} <br />
                {{ $order->billing_details['address'] }} <br />
                @if($order->billing_details['landmark'])
                    Landmark : {{ $order->billing_details['landmark'] }} <br />
                @endif
            </p>
            <h3>Order Summary:</h3>
            <table class="order-summary">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->product_qty }}</td>
                            <td>{{ number_format($item->total_amt, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="2">Discount Amount</td>
                        <td>{{ number_format($order->discount_amt, 2) }}</td>
                    </tr>
                    <tr class="total">
                        <td colspan="2">Sub Total Amount</td>
                        <td>{{ number_format($order->total_amt, 2) }}</td>
                    </tr>
                    <tr class="total">
                        <td colspan="2">Shipping Amount</td>
                        @if ($order->shipping_amt == 0)
                            <td>Free</td>
                        @else
                            <td>{{ number_format($order->shipping_amt, 2) }}</td>
                        @endif
                    </tr>
                    <tr class="total">
                        <td colspan="2">Total Amount</td>
                        <td>{{ number_format($order->net_total_amt, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="email-footer">
            <p>Thank you for shopping with {{ strtolower(env('APP_NAME')) }}!</p>
            <p>If you have any questions, feel free to <a href="mailto:{{env('MAIL_SUPPORT')}}">contact us</a>.</p>
        </div>
    </div>
</body>
</html>
