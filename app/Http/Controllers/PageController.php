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

// use Validator;


class PageController extends Controller
{
    public $cart_count=0;
    public function __construct()
    {

        // $cart = CartMaster::with('cart_count')->count();
        if(Auth::user()){
            // DB::enableQueryLog();
            $cart = CartMaster::with(['cart_count'])->where('cart_status',1)->where('user_id',Auth::user()->id)->first();
            // $query = DB::getQueryLog();
            // dd($cart);
            if($cart != null){
                $this->cart_count = count($cart->cart_count);
            }
        }
        // dd(count($cart->cart_count));
        session(['cart' => $this->cart_count]);
    }
    public function homepage(){
        
        $banner_data = HomeBanner::get();
        // $new_product = DB::table('dummy_new_launched as dnl')->select('dpd.id','product_name','product_rate','product_img')->join('dummy_products_details as dpd','dpd.id','=','dnl.prod_id')->groupBy('dnl.prod_id')->inRandomOrder()->limit(8)->get();
        // $trand_product = DB::table('dummy_top_tranding as dtt')->select('dpd.id','product_name','product_rate','product_img')->join('dummy_products_details as dpd','dpd.id','=','dtt.product_id')->groupBy('dtt.product_id')->inRandomOrder()->limit(8)->get();
        // $product_category = DB::table('categories as dpc')->select('dpc.id','dpc.category_name','dpc.category_img',DB::raw('count(dpd.id) as product_count'))->join('dummy_products_details  as dpd','dpd.cat_id','=','dpc.id')->where('category_status',1)->groupBy('dpc.id')->inRandomOrder()->limit(6)->get();
        $brand_list = DB::table('dummy_brand')->get();
        $trand_product = Product::with('defaultImg')->where('product_status',1)->orderby('created_at','desc')->inRandomOrder()->limit(4)->get();
        $new_product = Product::with('defaultImg')->where('product_status',1)->orderby('created_at','desc')->limit(8)->get();
        // dd($new_product[0]->defaultImg->image_name);
        $product_category = Category::where('category_status',1)->inRandomOrder()->limit(6)->get();
        return view('page.home', compact('banner_data','product_category','new_product','trand_product','brand_list'));
    }
    public function productDetails($prodid){
        // $product_list = DB::table('dummy_products_details')->limit(4)->get();
        $product_list = [];
        // $review_product = DB::table('dummy_review as dnl')->select('review_id','review','review_rating')->join('dummy_products_details as dpd','dpd.id','=','dnl.prod_id')->get();
        $review_product = [];
        // DB::enableQueryLog();
        $product_data = Product::with(['product_img' => function($query) {
            $query->orderBy('default_img', 'desc');
        }])->with(['product_review.users'])->with(['product_colors.colors'])->findorfail($prodid);
        // print_r(DB::getQueryLog());

        // dd($product_data);
        $averageRating = $product_data->product_review->avg('review_rating');
        $trand_product = Product::with('defaultImg')->where('product_status',1)->where('id','<>',$prodid)->orderby('created_at','desc')->inRandomOrder()->limit(8)->get();
        return view('page.product_details', compact('product_list','review_product','product_data','trand_product','averageRating'));
    }
    public function product(){
        $product_list = Product::with('defaultImg')->inRandomOrder()->get();
        return view('page.product', compact('product_list'));
    }
    public function checkout(){
  
        $list = ['Andaman and Nicobar Islands', 'Haryana', 'Tamil Nadu', 'Madhya Pradesh', 'Jharkhand', 'Mizoram', 'Nagaland', 'Himachal Pradesh', 'Tripura', 'Andhra Pradesh', 'Punjab', 'Chandigarh', 'Rajasthan', 'Assam', 'Odisha', 'Chhattisgarh', 'Jammu and Kashmir', 'Karnataka', 'Manipur', 'Kerala', 'Delhi', 'Puducherry', 'Uttarakhand', 'Uttar Pradesh', 'Bihar', 'Gujarat', 'Telangana', 'Meghalaya', 'Arunachal Pradesh', 'Maharashtra', 'Goa', 'West Bengal'];
        asort($list);
        $state_list = $list;
        $cart_data = CartMaster::with('cart_item_list.product_list')->where('cart_status', 1)->first();
        return view('page.checkout', compact('cart_data','state_list'));
    }
    public function cart(){

        // $catrt = CartMaster::with('cart_item_list.product_list.product_colors.colors')->findorfail(1);
        // dd($catrt);
        // $product_list = DB::table('dummy_products_details')->limit(4)->get();
        // $review_product = DB::table('dummy_review as dnl')->select('review_id','review','review_rating')->join('dummy_products_details as dpd','dpd.id','=','dnl.prod_id')->get();
        $cart_data = CartMaster::with('cart_item_list.product_list')->where('cart_status',1)->first();
        // dd($cart_data);
        // $trand_product = DB::table('dummy_top_tranding as dtt')->select('product_name','product_rate','product_img')->join('dummy_products_details as dpd','dpd.id','=','dtt.product_id')->groupBy('dtt.product_id')->inRandomOrder()->limit(8)->get();
        return view('page.cart', compact('cart_data'));
    }
    
    public function savereview(Request $request){
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
        if(Auth::user()){

            $cart_master = CartMaster::where('user_id', Auth::user()->id)->where('cart_status', 1)->first();
            if($cart_master ==  null){
                $cart_master =  new CartMaster;
                $cart_master->user_id = Auth::user()->id;
                $cart_master->session_id = Session::getId();
                $cart_master->cart_master_id = Uuid::randomNumber();
                $cart_master->cart_status = 1;
                $cart_master->save();
            }
            
            $cart_item = CartItem::where('cart_id', $cart_master->id)->where('product_id', $product->id)->first();
            // dd($cart_item);
            if($cart_item == null){
                $cart_item =  new CartItem;
                $cart_item->cart_id = $cart_master->id;
                $cart_item->product_id = $product->id;
                $cart_item->product_qty = 1;
                $cart_item->cart_master_id = $cart_master->cart_master_id;
                $cart_item->save();
            }
            $cart_count = CartItem::where('cart_id', $cart_master->id)->count();
        }
        // $cart = session()->has('cart') ? session()->get('cart') : [];
        // if (array_key_exists($product->id, $cart)) {
        //     $cart[$product->id]['quantity']++;
        // } else {
        //     $cart[$product->id] = [
        //         'title' => $product->product_name,
        //         'quantity' => 1,
        //         'unit_price' => $product->product_rate,
        //     ];
        // }
        // session(['cart' => $cart]);
        // // session()->flash('message', $product->product_name.' added to cart.');

        // $data = [];
        // $data['cart'] = session()->has('cart') ? session()->get('cart') : [];
        $data['cartcount'] = $cart_count;
        return response()->json($data);
    }

    public function removetocart(Request $request){
        // dd($request['cart_id']);
        $cart = CartItem::where('id',$request->input('cart_id'))->first();
        if($cart == null){
            return response()->json(['msg'=>'unable to remove cart id is '+$request->input('cart_id')], 400);
        }
        $cart->delete();
        $data['msg'] = 'successfully removed cart';
        return response()->json($data, 200);
    }

    public function updatecart(Request $request){
        $cart = CartItem::where('id',$request->input('cart_id'))->first();
        if($cart == null){
            return response()->json(['msg'=>'unable to update cart id is '+$request->input('cart_id')], 400);
        }
        $cart->product_qty = $request->input('prod_qty');
        $cart->save();
        $data['msg'] = 'successfully updated cart';
        return response()->json($data, 200);
    }

    public function checkoutpayment(Request $request){
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

        $billing_address = $request->input('bill_firstname')."|".$request->input('bill_lastname')."|".$request->input('bill_contactno')."|".$request->input('bill_address_line1')."|".$request->input('bill_address_line2')."|".$request->input('bill_city')."|".$request->input('bill_state')."|".$request->input('bill_pincode');

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
        foreach($cart_data->cart_item_list as $item_list){
            
            $sub_total = round($item_list->product_list->product_rate * $item_list->product_qty,2);
            $total_amt = $sub_total;
            
            $color_name = 'default';
            if(isset($item_list->product_list->product_color->color_name)){
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

        $valid = OrderMaster::where('id',$orderMaster->id)->update(['sub_total'=> $sub_total_overall, 'total_amt'=>$total_amt_overall]);

        if($valid){
            CartMaster::where('id', $cart_data->id)->update(['cart_status'=>2]);
            return redirect()->route('thankyou')->with('success','suscccsglll');
        }else{
            return redirect()->route('thankyou')->with('failed','failed');
        }
        
    }

    public function thankyou(){
        if(Session::has('success') || Session::has('failed')){
            return view('page.thankyou');
        }else{
            return redirect()->route('home');
        }
    }
}
