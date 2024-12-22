<?php

namespace App\Http\Controllers;

use App\Models\CartFee;
use App\Models\CartItem;
use App\Models\CartMaster;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\MyAddress;
use App\Models\OrderItem;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\ProductReview;
use Faker\Provider\Uuid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PageController extends Controller
{
    public $cart_count = 0;
    public $cookie_cart = array();
    public $backto;

    public function __construct()
    {
        if (Auth::user()) {
            $this->getcartcount();
        } else {
            $this->cookiefunction();
        }
        session(['cart_count' => $this->cart_count]);
    }

    public function getcartcount(): void
    {
        $cart_id = CartMaster::whereIn('cart_status', [1,2])->where('user_id', Auth::user()->id)->pluck('id');
        $cart_count_val = CartItem::whereIn('cart_id', $cart_id)->count();
        if ($cart_id != null) {
            $this->cart_count = $cart_count_val;
        }
    }

    public function homepage()
    {

        if(Auth::user() && !Auth::user()->hasVerifiedEmail()){
            return redirect()->route('verification.notice');
        }
        $banner_data = HomeBanner::get();
        // $brand_list = DB::table('dummy_brand')->get();
        // $brand_list = '';
        $trand_product = $this->getTrandProduct();
        // dd($trand_product);
        $new_product = $this->getNewProduct();
        $product_category = Category::where('category_status', 1)->inRandomOrder()->limit(10)->get();
        return view('page.home', compact('banner_data', 'product_category', 'new_product', 'trand_product'));
    }

    public function getTrandProduct($product_id = false)
    {
        $query = Product::with('defaultImg')->where('product_status', 1);
        if ($product_id) {
            $query->where('id', '<>', $product_id);
        }

        $product_data = $query->orderby('created_at', 'desc')->inRandomOrder()->limit(8)->get();
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
        if (Auth::user()) {
            $cart_master = CartMaster::where('user_id', Auth::user()->id)->whereIn('cart_status', [1,2])->first();
            if($cart_master){
                $cartItemsKeys = CartItem::where('cart_id', $cart_master->id)->pluck('product_id')->toArray();
            }
            // dd($cartItemsKeys);
        } else {
            if (isset($_COOKIE['shopping_cart'])) {
                $cartItems = json_decode($_COOKIE['shopping_cart'], true);
                $cartItemsKeys = array_keys($cartItems);
            }
        }

        return in_array($product_id, $cartItemsKeys) ? 'remove' : 'add';
    }

    public function productDetails($prodid)
    {
        $product_data = Product::with(['product_img_2' => function ($query) {
            $query->orderBy('default_img', 'desc');
        }])->with(['product_review.users'])->with(['product_detail_data.product_data'])->with(['product_colors.colors'])->findorfail($prodid);
        // dd($product_data);
        $averageRating = $product_data->product_review->avg('review_rating');

        $cart_status = $this->cartYesorNo($prodid);

        $trand_product = $this->getTrandProduct($prodid);

        return view('page.product_details', compact('product_data', 'trand_product', 'averageRating', 'cart_status'));
    }

    public function product(Request $request)
    {
        $category = $request->query('category');
        // $product_list = Product::with('defaultImg')->inRandomOrder()->get();
        $search = $request->input('search');
        $product_list = Product::with('defaultImg')->when($category, function ($query, $category) {
            return $query->where('category_id',$category);
        })->when($search, function ($query, $search) {
            return $query->where('product_name','like','%'.$search.'%');
        })->inRandomOrder()->paginate(10);
        foreach ($product_list as $key => $product) {
            $product_list[$key]['cart_type'] = $this->cartYesorNo($product->id);
        }
        
        $product_list->appends(['category' => $request->query('category')]);

        return view('page.product', compact('product_list', 'search'));
    }

    public function checkout()
    {

        $list = ['Andaman and Nicobar Islands', 'Haryana', 'Tamil Nadu', 'Madhya Pradesh', 'Jharkhand', 'Mizoram', 'Nagaland', 'Himachal Pradesh', 'Tripura', 'Andhra Pradesh', 'Punjab', 'Chandigarh', 'Rajasthan', 'Assam', 'Odisha', 'Chhattisgarh', 'Jammu and Kashmir', 'Karnataka', 'Manipur', 'Kerala', 'Delhi', 'Puducherry', 'Uttarakhand', 'Uttar Pradesh', 'Bihar', 'Gujarat', 'Telangana', 'Meghalaya', 'Arunachal Pradesh', 'Maharashtra', 'Goa', 'West Bengal'];
        asort($list);
        $state_list = $list;
        // $cart_data = CartMaster::with('cart_item_list.product_list')->where('cart_status', 1)->first();
        if (Auth::user()) {
            $cart_data = CartMaster::with('cart_item_list.product_list.defaultImg')->whereIn('cart_status', [1,2])->where('user_id', Auth::user()->id)->get();
            // echo count($cart_data) ? 'empty' : 'not empty';
            // dd($cart_data);
            if(!count($cart_data)){
                return redirect()->route('home');
            }
        } else {
            $cart_data = CartMaster::with('cart_item_list.product_list.defaultImg')->whereIn('cart_status', [1,2])->where('session_id', Session::getId())->get();
            if(!count($cart_data)){
                return redirect()->route('home');
            }
        }

        $addresslist = $this->myAddressList();
        return view('page.checkout', compact('cart_data', 'state_list','addresslist'));
    }

    public function cart()
    {

        // $catrt = CartMaster::with('cart_item_list.product_list.product_colors.colors')->findorfail(1);
        // dd($catrt);
        // $product_list = DB::table('dummy_products_details')->limit(4)->get();
        // $review_product = DB::table('dummy_review as dnl')->select('review_id','review','review_rating')->join('dummy_products_details as dpd','dpd.id','=','dnl.prod_id')->get();
        if (Auth::user()) {
            $item_list = CartMaster::with('cart_item_list.product_list.defaultImg')->whereIn('cart_status', [1,2])->where('user_id', Auth::user()->id)->first();
            $cart_data = [];
            if (isset($item_list->cart_item_list)) {
                foreach ($item_list->cart_item_list as $items) {
                    $item = [];
                    $item['id'] = $items->product_id;
                    $item['product_name'] = $items->product_list->product_name;
                    $item['image_name'] = $items->product_list->defaultImg->image_name;
                    $item['product_qty'] = $items->product_qty;
                    $item['product_mrp'] = $items->product_list->product_mrp;
                    $item['product_rate'] = $items->product_list->product_rate;
                    $item['cart_id'] = $items->id;
                    $cart_data[] = $item;
                }
            }
            // dd($cart_data);

        } else {
            // $cart_data = CartMaster::with('cart_item_list.product_list.defaultImg')->where('cart_status',1)->where('session_id',Session::getId())->get();

            // $test1 = $item_list = $_COOKIE['shopping_cart'];

            $cartItemsKeys = [];
            if (isset($_COOKIE['shopping_cart'])) {
                $cartItems = json_decode($_COOKIE['shopping_cart'], true);
                $cartItemsKeys = array_keys($cartItems);
            }

            $item_list = Product::with('defaultImg')->where('product_status', 1)->whereIn('id', $cartItemsKeys)->get();
            $cart_data = [];
            foreach ($item_list as $items) {
                $item = [];
                $item['id'] = $items->id;
                $item['product_name'] = $items->product_name;
                $item['image_name'] = $items->defaultImg->image_name;
                $item['product_qty'] = $cartItems[$items->id]['quantity'];
                $item['product_mrp'] = $items->product_mrp;
                $item['product_rate'] = $items->product_rate;
                $item['cart_id'] = $items->id;
                $cart_data[] = $item;
            }
        }
        $cart_fees = CartFee::get();
        // dd($cart_data);
        // $trand_product = DB::table('dummy_top_tranding as dtt')->select('product_name','product_rate','product_img')->join('dummy_products_details as dpd','dpd.id','=','dtt.product_id')->groupBy('dtt.product_id')->inRandomOrder()->limit(8)->get();
        return view('page.cart', compact('cart_data', 'cart_fees'));
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
            $cart_master = CartMaster::where('user_id', Auth::user()->id)->whereIn('cart_status', [1,2])->first();
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
        // $data['body'] = "remove to cart";
        $data['cartcount'] = $cart_count;
        return response()->json($data);
    }

    public function removetocart(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));
        if (Auth::user()) {
            $cart_master = CartMaster::where('user_id', Auth::user()->id)->whereIn('cart_status', [1,2])->first();
            $cart_item = CartItem::where('cart_id', $cart_master->id)->where('product_id', $product->id)->first();
            if ($cart_item != null) {
                $cart_item->delete();
            }
            $this->cart_count = CartItem::where('cart_id', $cart_master->id)->count();
        } else {
            $this->cookiefunction($product, 'remove');
        }

        $data['cartcount'] = $this->cart_count;
        return response()->json($data);
    }

    public function cookiefunction($product = null, $type = 'add'): void
    {
        $cartItems = array();
        if (isset($_COOKIE['shopping_cart'])) {
            $cartItems = json_decode($_COOKIE['shopping_cart'], true);
        }
        if ($product) {
            $cartItems[$product->id] = [
                'item_id' => $product->id,
                'quantity' => 1,
                'price' => $product->product_rate,
                'sub_total' => $product->product_rate,
                'item_color' => 'default'
            ];

            if ($type == 'remove') {
                unset($cartItems[$product->id]);
            }
        }
        $array_value = [];
        if (isset($cartItems)) {
            $array_value = array_column($cartItems, 'sub_total');
            // $cartItems['values']['sub_total'] = array_sum($array_value);
        }
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
        if (Auth::user()) {
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
        } else {
            if (isset($_COOKIE['shopping_cart'])) {
                $cartItems = json_decode($_COOKIE['shopping_cart'], true);

                if ($request->input('update_type') == 'remove') {
                    unset($cartItems[$request->input('cart_id')]);
                }

                $itemval = [];
                foreach ($cartItems as $items) {
                    $product_qty = $items['quantity'];
                    if ($items['item_id'] == $request->input('cart_id')) {
                        $product_qty = $request->input('prod_qty');
                    }
                    $itemval[$items['item_id']] = [
                        'item_id' => $items['item_id'],
                        'quantity' => $product_qty,
                        'price' => $items['price'],
                        'sub_total' => ($items['price'] * $product_qty),
                        'item_color' => 'default'
                    ];
                }
                $cartItems = $itemval;
                $array_value = array_column($cartItems, 'sub_total');
                // $cartItems['values']['sub_total'] = array_sum($array_value);

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
            'bill_address' => 'required|numeric',
            'cart_master_id' => 'required|numeric'
        ]);
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cart_data = CartMaster::with('cart_item_list.product_list.product_colors.colors')->findorfail($request->cart_master_id);

        $get_address = MyAddress::findorfail($request->bill_address);
        $billing_address = $get_address->contact_name."|".$get_address->contact_mobile."|".$get_address->address_line1."|".$get_address->address_line2."|".$get_address->address_city."|".$get_address->address_state."|".$get_address->address_pincode;

        $orderMaster = new OrderMaster();
        $order_master_id = Uuid::randomNumber();
        $orderMaster->order_master_id = $order_master_id;
        $orderMaster->cart_id = $cart_data->id;
        $orderMaster->user_id = Auth::user()->id;
        $orderMaster->order_date = date("Y-m-d H:i:s");
        $orderMaster->payment_status = 1;
        $orderMaster->payment_mode = $request->input('payment');
        $orderMaster->payment_reference_no = $request->input('gpay_ref_no');
        $orderMaster->order_status = 1;
        $orderMaster->billing_details = $billing_address;
        $orderMaster->save();

        $orderMasterID = $orderMaster->id;
        $sub_total_overall = 0;
        $total_amt_overall = 0;
        $total_order_qty = 0;
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
            $orderItem->product_id = $item_list->product_list->id;
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
            $orderItem->order_status = 1;
            $orderItem->order_date = date("Y-m-d H:i:s");
            $orderItem->save();

            $sub_total_overall += $sub_total;
            $total_amt_overall += $total_amt;
            $total_order_qty += $item_list->product_qty;
        }
        
        OrderMaster::where('id', $orderMaster->id)->update(['sub_total' => $sub_total_overall, 'total_amt' => $total_amt_overall,'total_order_qty' => $total_order_qty]);

        CartMaster::where('id', $cart_data->id)->update(['cart_status' => 2]);
 
        $ordermasterid = $orderMaster->id;
        $ordernumber = Uuid::randomNumber();
        Log::info('checkout page confirmation:', [
            'user_id' => Auth::user()->id,
            'ordermasterid' => $ordermasterid,
            'ordernumber'=>$ordernumber
        ]);
        return redirect()->route('makepayment',['makeorder'=>$ordermasterid,'accessorder'=>$ordernumber]);
    }

    public function thankyou()
    {
        if (Session::has('thankyou_success') || Session::has('thankyou_failed')) {
            session()->forget(['thankyou_success', 'thankyou_failed']);
            return view('page.thankyou');
        } else {
            return redirect()->route('home');
        }
    }

    public function myorderlist()
    {
        $orderItems = [];
        $orderMaster = OrderMaster::where('order_status', '3')->where('payment_status', '3')->where('user_id', Auth::user()->id)->pluck('id');
        if(count($orderMaster)){
            $orderItems = OrderItem::whereIn('order_id', $orderMaster)->orderby('created_at','desc')->get();
        }

        return view('page.orderlist', compact('orderItems'));
    }

    public function myaddress(Request $request)
    {
        $backto = $request->input('backto');
        if($backto){
            Session::put('backto', $backto);
        }
        $addresslist = $this->myAddressList();
        return view('page.myaddress',  compact('addresslist'));
    }

    public function myaddressAdd(Request $request):RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'contact_name' => 'required|string|max:50',
            'contact_mobile' => 'required|numeric|digits:10',
            'address_line1' => 'required|string|max:150',
            'address_line2' => 'nullable|string|max:150',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'pincode' => 'required|numeric|digits:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $my_address =  new MyAddress();
        // $my_address->contact_name = $request->contact_name;
        // $my_address->make_default = ($request->isdefault) ? 1 : 0;
        // $my_address->contact_mobile = $request->contact_mobile;
        // $my_address->address_line1 = $request->address_line1;
        // $my_address->address_line2 = $request->address_line2;
        // $my_address->address_city = $request->city;
        // $my_address->address_state = $request->state;
        // $my_address->address_pincode = $request->pincode;
        // $my_address->save();

        $address_data = [];
        $address_data['contact_name'] = $request->input('contact_name');
        $address_data['contact_mobile'] = $request->input('contact_mobile');
        $address_data['address_line1'] = $request->input('address_line1');
        $address_data['address_line2'] = $request->input('address_line2');
        $address_data['address_city'] = $request->input('city');
        $address_data['address_state'] = $request->input('state');
        $address_data['address_pincode'] = $request->input('pincode');
        $address_data['make_default'] = ($request->input('isdefault')) ? 1 : 0;
        $address_data['user_id'] = Auth::user()->id;

        MyAddress::updateOrCreate(['id'=>$request->input('address_id')],$address_data);
        
        if(Route::has(session('backto'))){
            return redirect()->route(session('backto'));
        }
        return redirect()->route("profile.myaddress");

    }

    public function myAddressList()
    {

        return MyAddress::where('user_id', Auth::user()->id)->get();
    }

    public function deleteMyAddress(Request $request)
    {
        $deladdress = $request->input('deladdress');
        MyAddress::where('id',$deladdress)->delete();
        return redirect()->route("profile.myaddress");
    }
}
