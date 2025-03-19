<?php

namespace App\Http\Controllers;

use App\CommonFunction;
use App\Models\AddressBook;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\ProductReview;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageController extends Controller
{
    use CommonFunction;
    
    public function home()
    {
        
        $img_carousel_result = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->inRandomOrder()->limit(5)->get();

        $img_carousel = $this->resultMap($img_carousel_result, ['pid'=>'id'], ['url_product_name'=>'product_name']);

        $category_result = Category::with('product')->where('category_status', '1')->limit(6)->get();
        $category_list = $this->resultMap($category_result, ['cid'=>'id'], ['url_category_name'=>'category_name']);

        $brand_list = Brand::where('brand_status', '1')->get();

        $trandy_product_result = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->inRandomOrder()->limit(8)->get();

        $trandy_product = $this->resultMap($trandy_product_result, ['pid'=>'id'], ['url_product_name'=>'product_name']);
        
        foreach($trandy_product as $tp){
            if(isset($tp->cart_item)){
                $tp->cart_item->cid  =  $this->encryptData($tp->cart_item->id);
            }
        }
        $newly_product_result = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->inRandomOrder()->limit(8)->get();

        $newly_product = $this->resultMap($newly_product_result, ['pid'=>'id'], ['url_product_name'=>'product_name']);

        foreach($newly_product as $np){
            if(isset($np->cart_item)){
                $np->cart_item->cid  =  $this->encryptData($np->cart_item->id);
            }
        }

        return view('index', compact('img_carousel', 'category_list', 'trandy_product', 'newly_product', 'brand_list'));
    }

    public function productdetail(Request $request)
    {
        try{
            $id=$this->decryptData($request->input('pid'));
            
            $product_data = Product::with('product_img')->with('cart_item')->with('product_field_data')->with(['product_review.users'])->findOrFail($id);
            $product_data->pid = $this->encryptData($product_data->id);
            $product_data->url_product_name = $this->encryptData($product_data->product_name);
            if(isset($product_data->cart_item)){
                $product_data->cart_item->cid  =  $this->encryptData($product_data->cart_item->id);
            }
                
            $related_product_result = Product::where('category_id', $product_data->category_id)->with('defaultImg')->where('id', '!=', $id)->with('cart_item')->inRandomOrder()->limit(8)->get();

            $related_product_list = $this->resultMap($related_product_result, ['pid'=>'id'], ['url_product_name'=>'product_name']);
        
            foreach($related_product_list as $tp){
                if(isset($tp->cart_item)){
                    $tp->cart_item->cid  =  $this->encryptData($tp->cart_item->id);
                }
            }

            $averageRating = $product_data->product_review->avg('review_rating');
            
            return view('product_detail', compact('product_data', 'related_product_list', 'averageRating'));
        } catch ( ModelNotFoundException $e) {
            return redirect()->route('page.error404');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('page.error404');
        }
    }

    public function submit_review(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'review_rating' => 'required',
            'review_comment' => 'required',
        ]);

        $review = new ProductReview();
        $review->product_id = $request->product_id;
        $review->review_rating = $request->review_rating;
        $review->review_comment = $request->review_comment;
        $review->created_by = Auth::id();
        $review->save();

        return redirect()->back()->with('success', 'Review Submitted');
    }

    public function view_cart()
    {
        $cart_items = CartItem::with('product.defaultImg')->where('user_id', Auth::id())->where('order_id', '0')->get();
        $item_value = 0;
        $tax_value = 0;
        $subtotal = 0;

        $website_data_value = $this->getWebsiteData();
        $delivery_free_amt = $website_data_value->delivery_free_charge;
        $delivery_free_amt_notes = $website_data_value->delivery_free_charge_notes;
        $shipping = $website_data_value->delivery_charge;
        $shipping_text = str_replace('$amt', number_format($delivery_free_amt,0), $delivery_free_amt_notes);


        foreach ($cart_items as $value) {
            $without_tax = round(($value->product->product_price * (100 / (100 + ($value->product->product_tax)))), 4);

            $value->item_value = round($value->product_qty * $without_tax, 2);

            $value->item_tax_value = round($value->product->product_tax * $value->item_value / 100, 2);

            $value->total_value = $value->product_qty * $value->product->product_price;

            $tax_value += round(($value->item_value * $value->product->product_tax) / 100, 2);

            $subtotal += $value->total_value;

            $item_value += $value->item_value;

            $value->product->pid = $this->encryptData($value->product->id);
            $value->cartid = $this->encryptData($value->id);
            $value->product->url_product_name = Str::slug($value->product->product_name);
        }

        $cart_value['Item Value'] = $item_value;
        $cart_value['Tax Value'] = $tax_value;
        $cart_value['Sub Total'] = $subtotal;
        if ($subtotal == 0 || $subtotal > $delivery_free_amt) {
            $shipping = 0;
        }
        
        $cart_value['Shipping'] = $shipping;

        $total_value = $subtotal + $shipping;
        return view('view_cart', compact('cart_items', 'cart_value', 'total_value', 'shipping_text'));
    }

    public function checkout()
    {
        $cart_count = $this->getCartCount();
        if ($cart_count == 0) {
            return redirect()->route('page.home')->with('error', 'No Product in Cart');
        }
        $cart_items = CartItem::with('product.defaultImg')->where('user_id', Auth::id())->where('order_id', '0')->get();
        $item_value = 0;
        $tax_value = 0;
        $subtotal = 0;
        
        $website_data_value = $this->getWebsiteData();
        $delivery_free_amt = $website_data_value->delivery_free_charge;
        $delivery_free_amt_notes = $website_data_value->delivery_free_charge_notes;
        $shipping = $website_data_value->delivery_charge;
        $shipping_text = str_replace('$amt', number_format($delivery_free_amt,0), $delivery_free_amt_notes);
        
        foreach ($cart_items as $value) {
            $without_tax = round(($value->product->product_price * (100 / (100 + ($value->product->product_tax)))), 4);

            $value->item_value = round($value->product_qty * $without_tax, 2);

            $value->item_tax_value = round($value->product->product_tax * $value->item_value / 100, 2);

            $value->total_value = $value->product_qty * $value->product->product_price;

            $tax_value += round(($value->item_value * $value->product->product_tax) / 100, 2);

            $subtotal += $value->total_value;

            $item_value += $value->item_value;
        }


        $cart_value['Item Value'] = $item_value;
        $cart_value['Tax Value'] = $tax_value;
        $cart_value['Sub Total'] = $subtotal;
        if ($subtotal == 0 || $subtotal > $delivery_free_amt) {
            $shipping = 0;
        }
        $cart_value['Shipping'] = $shipping;
        $total_value = $subtotal + $shipping;

        $address_list = AddressBook::where('user_id', Auth::id())->where('address_status', 1)->get();

        return view('checkout', compact('cart_items', 'cart_value', 'total_value', 'address_list', 'shipping_text'));
    }

    public function addtocart(Request $request)
    {
        try {
            $product_id = $this->decryptData($request->input('pid'));
            if ($product_id == 'invalid') {
                throw new \Exception('Invalid Product Item');
            }
            $product = Product::find($product_id);
            if (!$product) {
                throw new \Exception('Product Not Found');
            }

            if ($request->product_qty === "") {
                $request->merge(['product_qty' => 1]);
            }

            // $available = $this->checkProductStock($product_id, $request->product_qty);
            $available = true;

            if($available){
                $user_id = Auth::id();
                $cart_item = CartItem::where('product_id', $product_id)->where('user_id', $user_id)->where('order_id', '0')->first();
                if ($cart_item) {
                    $product_qty = $request->product_qty;
                    CartItem::where('id', $cart_item->id)->update(['product_qty' => $product_qty, 'updated_at' => now()]);

                    $returnMsg = 'Cart Updated';
                } else {
                    $product_qty = $request->product_qty;
                    CartItem::insert(['product_id' => $product_id, 'product_qty' => 1, 'user_id' => $user_id, 'created_at' => now(), 'updated_at' => now()]);
                    $returnMsg = 'Cart Added';
                }
                return redirect()->back()->with('cart_success', $returnMsg);
            }else{
                return redirect()->back()->with('cart_warning', 'Out of Stock');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('cart_danger', $e->getMessage());
        }
    }

    public function removetocart(Request $request)
    {
        try {
            $cart_id = $this->decryptData($request->input('cartid'));

            if ($cart_id == 'invalid') {
                throw new \Exception('Invalid Cart Item');
            }
            $cart_item = CartItem::find($cart_id);
            if (!$cart_item) {
                throw new \Exception('Cart Item Not Found');
            }
            $cart_item->delete();
            return redirect()->back()->with('cart_warning', 'Cart Removed');
        } catch (\Exception $e) {
            return redirect()->back()->with('cart_danger', $e->getMessage());
        }
    }
    public function myorder_list()
    {
        $order_list = OrderItem::where('user_id', Auth::id())->get();
        return view('orderlist', compact('order_list'));
    }

    public function vieworder($id)
    {
        $orderMaster = OrderMaster::find($id);

        try {
            if (!$orderMaster) {
                throw new \Exception('Invalid Order Master ID');
            }
            $orderItems = OrderItem::where('order_master_id', $orderMaster->id)->get();
            if (!$orderItems) {
                throw new \Exception('Order Item Not Found');
            }

            return view('view_order', compact('orderMaster', 'orderItems'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function myaddress()
    {
        $myaddress_list = AddressBook::where('user_id', Auth::id())->where('address_status', 1)->get();
        return view('myaddress', compact('myaddress_list'));
    }

    public function product_list(Request $request)
    {
        $category = $request->query('cid') ? $this->decryptData($request->query('cid')) : '';
        $search = $request->input('search');
        $brand = $request->input('brand');
        $product_list = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->when($category, function ($query, $category) {
            return $query->where('category_id', $category);
        })->when($search, function ($query, $search) {
            return $query->where('product_name', 'like', '%' . $search . '%');
        })->when($brand, function ($query, $brand) {
            return $query->where('brand_id', $brand);
        })->orderby('id', 'desc')->paginate(12);

        foreach($product_list as $prod){
            $prod->pid = $this->encryptData($prod->id);
            $prod->url_product_name = Str::slug($prod->product_name);
            if(isset($prod->cart_item)){
                $prod->cart_item->cid  =  $this->encryptData($prod->cart_item->id);
            }
        }

        return view('productlist', compact('product_list'));
    }

    public function checkProductStock($productid, $productqty)
    {
        // Call the stored procedure
        DB::select("CALL check_product_stock_2(?, ?, @available)", [$productid, $productqty]);

        // Get the value of the output variable @available
        $available = DB::select("SELECT @available as available");

        // Return or process the available stock result
        return $available[0]->available;
    }

    public function thankyou(){
        return view('thankyou');
    }

    public function errorNotFound()
    {
        return view('errors.404');
    }
}
