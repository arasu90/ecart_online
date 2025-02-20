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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    use CommonFunction;
    
    public function home()
    {
        $img_carousel = array('0' => array('img' => 'assets/img/carousel-1.jpg', 'text1' => '10% Off Your First Order', 'text2' => 'Fashionable Dress', 'link' => "3"), '1' => array('img' => 'assets/img/carousel-2.jpg', 'text1' => '13% Off Your First Order', 'text2' => 'Reasonable Price', 'link' => "4"));

        $category_list = Category::with('product')->where('category_status', '1')->limit(6)->get();

        $brand_list = Brand::where('brand_status', '1')->get();

        $trandy_product = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->inRandomOrder()->limit(8)->get();

        $newly_product = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->inRandomOrder()->limit(8)->get();

        return view('index', compact('img_carousel', 'category_list', 'trandy_product', 'newly_product', 'brand_list'));
    }

    public function productdetail($id)
    {
        $product_data = Product::with('product_img')->with('cart_item')->with('product_field_data')->with(['product_review.users'])->find($id);
        $related_product_list = Product::where('category_id', $product_data->category_id)->with('defaultImg')->where('id', '!=', $id)->with('cart_item')->inRandomOrder()->limit(8)->get();
        $averageRating = $product_data->product_review->avg('review_rating');

        return view('product_detail', compact('product_data', 'related_product_list', 'averageRating'));
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

        return redirect()->back()->with('success', 'Review Submitted Successfully');
    }

    public function view_cart()
    {
        $cart_items = CartItem::with('product.defaultImg')->where('user_id', Auth::id())->where('order_id', '0')->get();
        $item_value = 0;
        $tax_value = 0;
        $subtotal = 0;
        $shipping = 50;
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
        if ($subtotal == 0) {
            $shipping = 0;
        }
        $cart_value['Shipping'] = $shipping;

        $total_value = $subtotal + $shipping;
        return view('view_cart', compact('cart_items', 'cart_value', 'total_value'));
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
        $shipping = 50;
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
        $cart_value['Shipping'] = $shipping;
        $total_value = $subtotal + $shipping;

        $address_list = AddressBook::where('user_id', Auth::id())->where('address_status', 1)->get();

        return view('checkout', compact('cart_items', 'cart_value', 'total_value', 'address_list'));
    }

    public function addtocart($id, Request $request)
    {
        $product_id = $id;
        $product = Product::find($product_id);
        try {
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

                    $returnMsg = 'Cart Updated Successfully';
                } else {
                    $product_qty = $request->product_qty;
                    CartItem::insert(['product_id' => $product_id, 'product_qty' => 1, 'user_id' => $user_id, 'created_at' => now(), 'updated_at' => now()]);
                    $returnMsg = 'Product Added to Cart Successfully';
                }
                return redirect()->back()->with('cart_success', $returnMsg);
            }else{
                return redirect()->back()->with('cart_warning', 'Out of Stock');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('cart_danger', $e->getMessage());
        }
    }

    public function removetocart($id)
    {
        $cart_id = $id;
        $cart_item = CartItem::find($cart_id);

        try {
            if (!$cart_item) {
                throw new \Exception('Cart Item Not Found');
            }
            $cart_item->delete();
            return redirect()->back()->with('cart_warning', 'Product Removed from Cart Successfully');
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
        $category = $request->query('category');
        $search = $request->input('search');
        $brand = $request->input('brand');
        $product_list = Product::with('defaultImg')->with('cart_item')->where('product_status', '1')->when($category, function ($query, $category) {
            return $query->where('category_id', $category);
        })->when($search, function ($query, $search) {
            return $query->where('product_name', 'like', '%' . $search . '%');
        })->when($brand, function ($query, $brand) {
            return $query->where('brand_id', $brand);
        })->orderby('id', 'desc')->paginate(12);

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
}
