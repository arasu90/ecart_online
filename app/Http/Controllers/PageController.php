<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\CartMaster;
use App\Models\Category;
use App\Models\HomeBanner;
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
    public $cart_count=0;
    public function __construct()
    {

        // $cart = CartMaster::with('cart_count')->count();
        if(Auth::user()){
            $cart = CartMaster::with('cart_count')->first();
            $this->cart_count = count($cart->cart_count);
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
        $cart_data = CartMaster::with('cart_item_list.product_list')->first();
        return view('page.checkout', compact('cart_data','state_list'));
    }
    public function cart(){
        $product_list = DB::table('dummy_products_details')->limit(4)->get();
        $review_product = DB::table('dummy_review as dnl')->select('review_id','review','review_rating')->join('dummy_products_details as dpd','dpd.id','=','dnl.prod_id')->get();
        $cart_data = CartMaster::with('cart_item_list.product_list')->first();
        // dd($cart_data);
        $trand_product = DB::table('dummy_top_tranding as dtt')->select('product_name','product_rate','product_img')->join('dummy_products_details as dpd','dpd.id','=','dtt.product_id')->groupBy('dtt.product_id')->inRandomOrder()->limit(8)->get();
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

            $cart_master = CartMaster::where('user_id', Auth::user()->id)->first();
            if($cart_master ==  null){
                $cart_master =  new CartMaster;
                $cart_master->user_id = Auth::user()->id;
                $cart_master->session_id = Session::getId();
                $cart_master->cart_master_id = Uuid::randomNumber();
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
}
