<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\ProductData;
use App\Models\ProductDataValue;
use App\Models\ProductImg;
use App\Models\User;
use App\Models\Website;
use Faker\Provider\ar_EG\Company;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $todayOrders = OrderMaster::where('order_date', '>=', date('Y-m-d 00:00:00'))->count();
        $todayOrdersValue = OrderMaster::where('order_date', '>=', date('Y-m-d 00:00:00'))->sum('net_total_amt');

        $thisMonthOrders = OrderMaster::where('order_date', '>=', date('Y-m-01 00:00:00'))->count();
        $thisMonthOrdersValue = OrderMaster::where('order_date', '>=', date('Y-m-01 00:00:00'))->sum('net_total_amt');

        $ordercount = OrderItem::count();
        $barChartProductName = 0;
        $barChartProductQty = 0;
        if ($ordercount) {
            /* $products = OrderItem::join('products', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->orderby('products.id')
                ->select('products.product_name', DB::raw('SUM(order_items.product_qty) as total_qty'))
                ->get(); */
                $products = DB::table('order_items')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->select('products.product_name', DB::raw('SUM(order_items.product_qty) as total_qty'))
                ->groupBy('products.id', 'products.product_name')
                ->orderBy('products.id', 'asc')
                ->get();
                // dd($products);
            $barChartProductName = $products->pluck('product_name');
            $barChartProductQty = $products->pluck('total_qty');
        }
        
        $orders = OrderItem::groupBy('order_master_id')
            ->orderby('total_amt')
            ->select(DB::raw('count(product_id) as total_product'), DB::raw('sum(total_amt) as total_amt'))
            ->get();

        $barChartOrderValue = $orders->pluck('total_amt');
        $barChartOrderItem = $orders->pluck('total_product');

        return view('admin.index', compact('todayOrders', 'todayOrdersValue', 'thisMonthOrdersValue', 'thisMonthOrders', 'barChartProductName', 'barChartProductQty', 'barChartOrderValue', 'barChartOrderItem'));
    }

    public function categoryList(Request $request)
    {
        $category_data = Category::find($request->input('category_id'));
        $category_list = Category::get();
        return view('admin.category', compact('category_data', 'category_list'));
    }

    public function updateCategory($id, Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:50|string|unique:categories,category_name,' . $id . '',
            'category_image' => 'nullable|file|mimes:jpeg,jpg,png|max:10000',
            'category_status' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->category_name = $request->input('category_name');

        if ($request->hasFile('category_image')) {
            $path_img = public_path($category->category_img);
            File::delete($path_img);
            $path = $request->file('category_image')->store('uploads', 'public');
            $category->category_img = Storage::url($path);
        }

        $category->category_status = ($request->input('category_status')) ? 1 : 0;
        $category->save();

        return redirect()->route('admin.categorylist', ['category_id' => $id])->with('success', 'Category updated successfully');
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:50|string|unique:categories,category_name',
            'category_image' => 'file|mimes:jpeg,jpg,png|required|max:10000',
            'category_status' => 'required',
        ]);

        $path = $request->file('category_image')->store('uploads', 'public');
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->category_img = Storage::url($path);
        $category->category_status = ($request->input('category_status')) ? 1 : 0;
        $category->save();

        return redirect()->route('admin.categorylist')->with('success', 'Category added successfully');
    }


    public function deleteCategory($id)
    {
        $category = Category::find($id);
        try {
            if (!$category) {
                throw new \Exception('Invalid Category ID');
            }

            $category->delete();
            return redirect()->route('admin.categorylist')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function brandList(Request $request)
    {
        $brand_data = Brand::find($request->input('brand_id'));
        $brand_list = Brand::get();
        return view('admin.brand', compact('brand_data', 'brand_list'));
    }

    public function updateBrand($id, Request $request)
    {
        $request->validate([
            'brand_name' => 'required|max:50|string|unique:brands,brand_name,' . $id . '',
            'brand_img' => 'nullable|file|mimes:jpeg,jpg,png|max:10000',
            'brand_status' => 'required',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->brand_name = $request->input('brand_name');

        if ($request->hasFile('brand_img')) {
            $path_img = public_path($brand->brand_img);
            File::delete($path_img);
            $path = $request->file('brand_img')->store('uploads', 'public');
            $brand->brand_img = Storage::url($path);
        }

        $brand->brand_status = ($request->input('brand_status')) ? 1 : 0;
        $brand->save();

        return redirect()->route('admin.brandlist', ['brand_id' => $id])->with('success', 'Brand updated successfully');
    }

    public function addBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|max:50|string|unique:brands,brand_name',
            'brand_img' => 'file|mimes:jpeg,jpg,png|required|max:10000',
            'brand_status' => 'required',
        ]);

        $path = $request->file('brand_img')->store('uploads', 'public');
        $brand = new Brand();
        $brand->brand_name = $request->input('brand_name');
        $brand->brand_img = Storage::url($path);
        $brand->brand_status = ($request->input('brand_status')) ? 1 : 0;
        $brand->save();

        return redirect()->route('admin.brandlist')->with('success', 'Brand added successfully');
    }

    public function deleteBrand($brandid)
    {
        $brands = Brand::find($brandid);
        try {
            if (!$brands) {
                throw new \Exception('Invalid Brand ID');
            }

            $brands->delete();
            return redirect()->route('admin.brandlist')->with('success', 'Brand deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userList()
    {
        $user_list = User::get();
        return view('admin.userlist', compact('user_list'));
    }

    public function userView($userid)
    {
        $user_data = User::find($userid);
        $user_order_list = OrderMaster::where('user_id', $userid)->get();
        return view('admin.userview', compact('user_data', 'user_order_list'));
    }

    public function orderlist()
    {
        $order_master_list = OrderMaster::with('users')->get();
        return view('admin.orderlist', compact('order_master_list'));
    }

    public function orderView($orderid)
    {
        $order_master_data = OrderMaster::with('users')->find($orderid);
        $order_item_list = OrderItem::where('order_master_id', $orderid)->get();
        $total_order_qty = $order_item_list->sum('product_qty');
        $total_order_item = $order_item_list->count();
        return view('admin.orderview', compact('order_master_data', 'order_item_list', 'total_order_qty', 'total_order_item'));
    }

    public function websiteData()
    {
        $website_data = Website::first();
        return view('admin.websitedata', compact('website_data'));
    }

    public function websiteDataUpdate(Request $request)
    {
        $website_data = Website::first();
        $request->validate([
            'site_name' => 'required|max:50|string',
            'site_logo' => 'file|mimes:jpeg,jpg|nullable|max:10000',
            'site_email' => 'required',
            'site_mobile' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'address_city' => 'required',
            'address_state' => 'required',
            'address_pincode' => 'required',
        ]);

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('uploads', 'public');
            $website_data->site_logo = Storage::url($path);
        }
        $website_data->site_name = $request->input('site_name');
        $website_data->site_email = $request->input('site_email');
        $website_data->site_mobile = $request->input('site_mobile');
        $website_data->site_desc = $request->input('site_detail');
        $website_data->site_address_line1 = $request->input('address_line_1');
        $website_data->site_address_line2 = $request->input('address_line_2');
        $website_data->site_address_city = $request->input('address_city');
        $website_data->site_address_state = $request->input('address_state');
        $website_data->site_address_pincode = $request->input('address_pincode');
        $website_data->save();

        return redirect()->route('admin.websitedata')->with('success', 'Site data updated successfully');
    }

    public function updateOrderStatus($orderid, Request $request): RedirectResponse
    {
        $order_item_list = OrderItem::find($orderid);
        $order_item_list->order_status = $request->input('orderstatus');
        $order_item_list->delivery_date = $request->input('delivery_date');
        $order_item_list->delivery_notes = $request->input('delivery_notes');
        $order_item_list->save();

        return redirect()->route('admin.orderview', $order_item_list->order_master_id);
    }

    public function login()
    {
        if (Auth::user()) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('admin.login');
        }
    }

    public function validateLogin(Request $request): RedirectResponse
    {
        $input = $request->all();
        $request->validate([
            'username' => ['required', 'email', 'string', 'exists:users,email'],
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $input['username'], 'password' => $input['password']])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with('login_error', 'Invalid Email & Password');
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function updateAdminPassword(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|max:50|string',
            'new_confirm_password' => 'required|max:50|string|required_with:newpassword|same:newpassword',
        ], [
            'new_confirm_password.same' => "New Password & Confirm Password not match"
        ]);

        $profileupdate = User::where('email', 'admin@admin.com')->update(['password' => Hash::make($request->input('newpassword'))]);
        if ($profileupdate) {
            return redirect()->route('admin.changepassword')->with('success', 'Profile Passerd Updated Successfully');
        } else {
            return redirect()->route('admin.changepassword')->with('error', 'Failed to update');
        }
    }
}
