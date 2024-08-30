<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\CartMaster;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\OrderItem;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\ProductReview;
use Exception;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PageController extends Controller
{
    public $cart_count = 0;
    public $cookie_cart = array();

    public function __construct()
    {
        if (Auth::user()) {
            $this->getcartcount();
        }else{
            $this->cookiefunction();
        }
        session(['cart_count' => $this->cart_count]);
    }

    public function getcartcount(): void
    {
        $cart_id = CartMaster::where('cart_status', 1)->where('user_id', Auth::user()->id)->pluck('id');
        $cart_count_val = CartItem::whereIn('cart_id', $cart_id)->count();
        if ($cart_id != null) {
            $this->cart_count = $cart_count_val;
        }
    }

    public function homepage()
    {

        $banner_data = HomeBanner::get();
        $brand_list = DB::table('dummy_brand')->get();
        $trand_product = $this->getTrandProduct();
        // dd($trand_product);
        $new_product = $this->getNewProduct();
        $product_category = Category::where('category_status', 1)->inRandomOrder()->limit(6)->get();
        return view('page.home', compact('banner_data', 'product_category', 'new_product', 'trand_product', 'brand_list'));
    }

    public function getTrandProduct($product_id=false)
    {
        $query = Product::with('defaultImg')->where('product_status', 1);
        if($product_id){
            $query->where('id','<>',$product_id);
        }

        $product_data = $query->orderby('created_at', 'desc')->inRandomOrder()->limit(8)->get();
        $data = [];
        $cartItemsKeys = [];
        if (isset($_COOKIE['shopping_cart'])) {
            $cartItems = json_decode($_COOKIE['shopping_cart'], true);
            $cartItemsKeys = array_keys($cartItems['items']);
        }



        foreach ($product_data as $product) {
            $data_val['id'] = $product->id;
            $data_val['image_name'] = $product->defaultImg->image_name;
            $data_val['product_name'] = $product->product_name;
            $data_val['product_rate'] = $product->product_rate;
            $data_val['product_mrp'] = $product->product_mrp;
            $data_val['cart_type'] = in_array($product->id, $cartItemsKeys) ? 'remove' : 'add';

            $data[] = $data_val;
        }

        return $data;
    }

    public function getNewProduct()
    {
        $product_data = Product::with('defaultImg')->where('product_status', 1)->orderby('created_at', 'desc')->limit(8)->get();
        $data = [];
        

        foreach ($product_data as $product) {
            $data_val['id'] = $product->id;
            $data_val['image_name'] = $product->defaultImg->image_name;
            $data_val['product_name'] = $product->product_name;
            $data_val['product_rate'] = $product->product_rate;
            $data_val['product_mrp'] = $product->product_mrp;
            $data_val['cart_type'] = $this->cartYesorNo($product->id);
            $data[] = $data_val;
        }

        return $data;
    }

    public function cartYesorNo($product_id)
    {
        $cartItemsKeys = [];
        if (isset($_COOKIE['shopping_cart'])) {
            $cartItems = json_decode($_COOKIE['shopping_cart'], true);
            $cartItemsKeys = array_keys($cartItems['items']);
        }

        return in_array($product_id, $cartItemsKeys) ? 'remove' : 'add';
    }

    public function productDetails($prodid)
    {
        $product_data = Product::with(['product_img' => function ($query) {
            $query->orderBy('default_img', 'desc');
        }])->with(['product_review.users'])->with(['product_colors.colors'])->findorfail($prodid);
        
        $averageRating = $product_data->product_review->avg('review_rating');
        
        $cart_status = $this->cartYesorNo($prodid);

        $trand_product = $this->getTrandProduct($prodid);
        
        return view('page.product_details', compact('product_data', 'trand_product', 'averageRating', 'cart_status'));
    }

    public function product()
    {
        $product_list = Product::with('defaultImg')->inRandomOrder()->get();
        return view('page.product', compact('product_list'));
    }

    public function checkout()
    {

        $list = ['Andaman and Nicobar Islands', 'Haryana', 'Tamil Nadu', 'Madhya Pradesh', 'Jharkhand', 'Mizoram', 'Nagaland', 'Himachal Pradesh', 'Tripura', 'Andhra Pradesh', 'Punjab', 'Chandigarh', 'Rajasthan', 'Assam', 'Odisha', 'Chhattisgarh', 'Jammu and Kashmir', 'Karnataka', 'Manipur', 'Kerala', 'Delhi', 'Puducherry', 'Uttarakhand', 'Uttar Pradesh', 'Bihar', 'Gujarat', 'Telangana', 'Meghalaya', 'Arunachal Pradesh', 'Maharashtra', 'Goa', 'West Bengal'];
        asort($list);
        $state_list = $list;
        // $cart_data = CartMaster::with('cart_item_list.product_list')->where('cart_status', 1)->first();
        if (Auth::user()) {
            $cart_data = CartMaster::with('cart_item_list.product_list.defaultImg')->where('cart_status', 1)->where('user_id', Auth::user()->id)->get();
        } else {
            $cart_data = CartMaster::with('cart_item_list.product_list.defaultImg')->where('cart_status', 1)->where('session_id', Session::getId())->get();
        }
        return view('page.checkout', compact('cart_data', 'state_list'));
    }

    public function cart()
    {

        // $catrt = CartMaster::with('cart_item_list.product_list.product_colors.colors')->findorfail(1);
        // dd($catrt);
        // $product_list = DB::table('dummy_products_details')->limit(4)->get();
        // $review_product = DB::table('dummy_review as dnl')->select('review_id','review','review_rating')->join('dummy_products_details as dpd','dpd.id','=','dnl.prod_id')->get();
        if (Auth::user()) {
            $item_list = CartMaster::with('cart_item_list.product_list.defaultImg')->where('cart_status', 1)->where('user_id', Auth::user()->id)->first();
            $cart_data = [];
            foreach($item_list->cart_item_list as $items){
                $item = [];
                $item['id'] = $items->id;
                $item['product_name'] = $items->product_list->product_name;
                $item['image_name'] = $items->product_list->defaultImg->image_name;
                $item['product_qty'] = $items->product_qty;
                $item['product_mrp'] = $items->product_list->product_mrp;
                $item['product_rate'] = $items->product_list->product_rate;
                $item['cart_id'] = $items->id;
                $cart_data[] = $item;
            }
            // dd($cart_data);

        } else {
            // $cart_data = CartMaster::with('cart_item_list.product_list.defaultImg')->where('cart_status',1)->where('session_id',Session::getId())->get();

            // $test1 = $item_list = $_COOKIE['shopping_cart'];

            $cartItemsKeys = [];
            if (isset($_COOKIE['shopping_cart'])) {
                $cartItems = json_decode($_COOKIE['shopping_cart'], true);
                $cartItemsKeys = array_keys($cartItems['items']);
            }

            $item_list = Product::with('defaultImg')->where('product_status', 1)->whereIn('id', $cartItemsKeys)->get();
            $cart_data = [];
            foreach($item_list as $items){
                $item = [];
                $item['id'] = $items->id;
                $item['product_name'] = $items->product_name;
                $item['image_name'] = $items->defaultImg->image_name;
                $item['product_qty'] = $cartItems['items'][$items->id]['quantity'];
                $item['product_mrp'] = $items->product_mrp;
                $item['product_rate'] = $items->product_rate;
                $item['cart_id'] = $items->id;
                $cart_data[] = $item;
            }
        }
        // dd($cart_data);
        // $trand_product = DB::table('dummy_top_tranding as dtt')->select('product_name','product_rate','product_img')->join('dummy_products_details as dpd','dpd.id','=','dtt.product_id')->groupBy('dtt.product_id')->inRandomOrder()->limit(8)->get();
        return view('page.cart', compact('cart_data'));
    }


    public function savereview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review_comment' => 'required|string',
            'product_id' => 'required|int',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $review = new ProductReview();
        $review->review_comment = $request->review_comment;
        $review->product_id = $request->product_id;
        $review->review_rating = 4.5;
        $review->created_by = Auth::user()->id;
        $review->save();
        return back()->with('review_success', 'Your review posted successfully');
    }

    public function addtocart(Request $request)
    {
        $cart_count = 0;
        $product = Product::findOrFail($request->input('product_id'));
        if (Auth::user()) {
            $cart_master = CartMaster::where('user_id', Auth::user()->id)->where('cart_status', 1)->first();
            if ($cart_master ==  null) {
                $cart_master =  new CartMaster;
                $cart_master->user_id = Auth::user()->id;
                $cart_master->session_id = Session::getId();
                $cart_master->cart_master_id = Uuid::randomNumber();
                $cart_master->cart_status = 1;
                $cart_master->save();
            }

            $cart_item = CartItem::where('cart_id', $cart_master->id)->where('product_id', $product->id)->first();
            if ($cart_item == null) {
                $cart_item =  new CartItem;
                $cart_item->cart_id = $cart_master->id;
                $cart_item->product_id = $product->id;
                $cart_item->product_qty = 1;
                $cart_item->cart_master_id = $cart_master->cart_master_id;
                $cart_item->save();
            }
            $cart_count = CartItem::where('cart_id', $cart_master->id)->count();
        } else {
            /* $cart_master = CartMaster::where('session_id', Session::getId())->where('cart_status', 1)->first();
            if($cart_master ==  null){
                $cart_master =  new CartMaster;
                $cart_master->session_id = Session::getId();
                $cart_master->cart_master_id = Uuid::randomNumber();
                $cart_master->cart_status = 1;
                $insertMaster = $cart_master->save();
            }
            // if($insertMaster){
                $cart_item = CartItem::where('cart_id', $cart_master->id)->where('product_id', $product->id)->first();
                if($cart_item == null){
                    $cart_item =  new CartItem;
                    $cart_item->cart_id = $cart_master->id;
                    $cart_item->product_id = $product->id;
                    $cart_item->product_qty = 1;
                    $cart_item->cart_master_id = $cart_master->cart_master_id;
                    $cart_item->save();
                }
            // }
            $cart_count = CartItem::where('cart_id', $cart_master->id)->count(); */

            $this->cookiefunction($product, 'add');

            $getcookie = "";
            $cart_count = $this->cart_count;
            // dd(count(array_keys($cart_count['items'])));
        }
        $data['body'] = "remove to cart";
        $data['cartcount'] = $cart_count;
        return response()->json($data);
    }

    public function removetocart(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));
        $this->cookiefunction($product, 'remove');

        $data['cartcount'] = $this->cart_count;
        return response()->json($data);
    }

    public function cookiefunction($product = null, $type = 'add'): void
    {
        if (isset($_COOKIE['shopping_cart'])) {
            $cartItems = json_decode($_COOKIE['shopping_cart'], true);
        }
        if ($product) {
            $cartItems['items'][$product->id] = [
                'item_id' => $product->id,
                'quantity' => 1,
                'price' => $product->product_rate,
                'sub_total' => $product->product_rate,
                'item_color' => 'default'
            ];

            if ($type == 'remove') {
                unset($cartItems['items'][$product->id]);
            }
        }

        $array_value = array_column($cartItems['items'], 'sub_total');
        $cartItems['values']['sub_total'] = array_sum($array_value);

        $cookie_name = "shopping_cart";

        $cookie_value = json_encode($cartItems);

        $expiry_time = time() + (365 * 24 * 60 * 60); // 1 year from now

        setcookie($cookie_name, $cookie_value, $expiry_time, "/");

        $this->cart_count = count($array_value);
    }

    /* public function removetocart(Request $request)
    {
        // dd($request['cart_id']);
        $cart = CartItem::where('id', $request->input('cart_id'))->first();
        if ($cart == null) {
            return response()->json(['msg' => 'unable to remove cart id is ' + $request->input('cart_id')], 400);
        }
        $cart->delete();
        $this->getcartcount();
        $data['msg'] = 'successfully removed cart';
        $data['cart_count'] = $this->cart_count;
        return response()->json($data, 200);
    } */

    public function updatecart(Request $request)
    {
        if(Auth::user())
        {
            $cart = CartItem::where('id', $request->input('cart_id'))->first();
            if ($cart == null) {
                $data['msg'] = 'unable to update this cart id';
                $data['cart_id'] = $request->input('cart_id');
                return response()->json($data, 400);
                // dd($cart);
            }
            $cart->product_qty = $request->input('prod_qty');
            $cart->save();

            if ($request->input('update_type') == 'remove') {
                $cart->delete();
            }

            $this->getcartcount();

        }else{
            if (isset($_COOKIE['shopping_cart'])) {
                $cartItems = json_decode($_COOKIE['shopping_cart'], true);

                if ($request->input('update_type') == 'remove') {
                    unset($cartItems['items'][$request->input('cart_id')]);
                }

                $itemval = [];
                foreach($cartItems['items'] as $items){
                    $product_qty = $items['quantity'];
                    if($items['item_id'] == $request->input('cart_id')){
                        $product_qty = $request->input('prod_qty');
                    }
                    $itemval[$items['item_id']] = [
                        'item_id' => $items['item_id'],
                        'quantity' => $product_qty,
                        'price' => $items['price'],
                        'sub_total' => ($items['price']*$product_qty),
                        'item_color' => 'default'
                    ];
                }
                $cartItems['items'] = $itemval;
                $array_value = array_column($cartItems['items'], 'sub_total');
                $cartItems['values']['sub_total'] = array_sum($array_value);

                $cookie_name = "shopping_cart";

                $cookie_value = json_encode($cartItems);

                $expiry_time = time() + (365 * 24 * 60 * 60); // 1 year from now

                setcookie($cookie_name, $cookie_value, $expiry_time, "/");

                $this->cart_count = count($array_value);
            }

        }
        $data['msg'] = 'successfully updated cart';
        $data['cart_count'] = $this->cart_count;
        return response()->json($data, 200);
    }

    public function checkoutpayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_firstname' => 'required|string|max:50',
            'bill_lastname' => 'nullable|string|max:50',
            'bill_contactno' => 'required|numeric',
            'bill_address_line1' => 'required|string|max:200',
            'bill_address_line2' => 'nullable|string|max:200',
            'bill_city' => 'required|string|max:50',
            'bill_state' => 'required|string|max:50',
            'bill_pincode' => 'required|numeric',
            'cart_master_id' => 'required|numeric',
            'payment' => 'required|in:gpay,paypal,banktransfer',
            'gpay_ref_no'  => 'required_if:payment,==,gpay',
            'paypal_ref_no'  => 'required_if:payment,==,paypal',
            'banktransfer_ref_no'  => 'required_if:payment,==,banktransfer',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cart_data = CartMaster::with('cart_item_list.product_list.product_colors.colors')->findorfail($request->cart_master_id);

        $billing_address = $request->input('bill_firstname') . "|" . $request->input('bill_lastname') . "|" . $request->input('bill_contactno') . "|" . $request->input('bill_address_line1') . "|" . $request->input('bill_address_line2') . "|" . $request->input('bill_city') . "|" . $request->input('bill_state') . "|" . $request->input('bill_pincode');

        $orderMaster = new OrderMaster();
        $order_master_id = Uuid::randomNumber();
        $orderMaster->order_master_id = $order_master_id;
        $orderMaster->cart_id = $cart_data->id;
        $orderMaster->user_id = Auth::user()->id;
        $orderMaster->order_date = date("Y-m-d");
        $orderMaster->sub_total = 4.5;
        $orderMaster->other_amt = 4.5;
        $orderMaster->total_amt = 4.5;
        $orderMaster->payment_status = 1;
        $orderMaster->payment_mode = $request->input('payment');
        $orderMaster->payment_reference_no = $request->input('gpay_ref_no');
        $orderMaster->order_status = 1;
        $orderMaster->billing_details = $billing_address;
        $orderMaster->save();

        $orderMasterID = $orderMaster->id;
        $sub_total_overall = 0;
        $total_amt_overall = 0;
        foreach ($cart_data->cart_item_list as $item_list) {

            $sub_total = round($item_list->product_list->product_rate * $item_list->product_qty, 2);
            $total_amt = $sub_total;

            $color_name = 'default';
            if (isset($item_list->product_list->product_color->color_name)) {
                $color_name = $item_list->product_list->product_color->color_name;
            }

            $orderItem = new OrderItem();
            $orderItem->order_id = $orderMasterID;
            $orderItem->order_master_id = $order_master_id;
            $orderItem->user_id = Auth::user()->id;
            $orderItem->product_name = $item_list->product_list->product_name;
            $orderItem->color_name = $color_name;
            $orderItem->product_qty = $item_list->product_qty;
            $orderItem->product_mrp = $item_list->product_list->product_mrp;
            $orderItem->product_rate = $item_list->product_list->product_rate;
            $orderItem->sub_total = $sub_total;
            $orderItem->discount_amt = 0;
            $orderItem->gst_per = 0;
            $orderItem->gst_amt = 0;
            $orderItem->total_amt = $total_amt;
            $orderItem->save();

            $sub_total_overall += $sub_total;
            $total_amt_overall += $total_amt;
        }

        $valid = OrderMaster::where('id', $orderMaster->id)->update(['sub_total' => $sub_total_overall, 'total_amt' => $total_amt_overall]);

        if ($valid) {
            CartMaster::where('id', $cart_data->id)->update(['cart_status' => 2]);
            return redirect()->route('thankyou')->with('success', 'suscccsglll');
        } else {
            return redirect()->route('thankyou')->with('failed', 'failed');
        }
    }

    public function thankyou()
    {
        if (Session::has('success') || Session::has('failed')) {
            return view('page.thankyou');
        } else {
            return redirect()->route('home');
        }
    }
}
