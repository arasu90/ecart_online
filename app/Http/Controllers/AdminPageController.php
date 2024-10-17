<?php

namespace App\Http\Controllers;

use App\Models\CartFee;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\OrderItem;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager as Image;

class AdminPageController extends Controller
{
    public function home()
    {
        return view('admin.dashboard');
    }
    public function list()
    {
        $category_list = Category::get();
        return view('admin.categorylist', compact('category_list'));
    }
    public function create()
    {
        return view('admin.categorynew');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:45|unique:categories,category_name',
            'imagefile' => 'required|file|mimes:jpeg,jpg,png|max:1000'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('imagefile')) {
            /* $resizedImage = Image::make($request->file('imagefile'))->resize(500, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($request->file('imagefile')->getClientOriginalExtension());
            $path = $request->file('imagefile')->store('public/uploads', $resizedImage);
            $category = new Category();
            $category->category_name = $request->name;
            $category->category_img = Storage::url($path);
            $category->category_status = 1;
            $category->save(); */

            $path = $request->file('imagefile')->store('public/uploads');
            $category = new Category();
            $category->category_name = $request->name;
            $category->category_img = Storage::url($path);
            $category->category_status = 1;
            $category->created_by = Auth::user()->id;
            $category->save();
            return back()->with('success', 'File uploaded successfully');
        }
        return back()->with('error', 'Faild to upload');
    }
    public function edit($id)
    {
        $category_data = Category::findOrFail($id);
        return view('admin.categoryedit', compact('category_data'));
    }
    public function update($id, Request $request)
    {
        try {
            $category = Category::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:45|unique:categories,category_name,' . $id,
                'imagefile' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
                'status' => 'required|between:0,1'
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if ($request->hasFile('imagefile')) {
                $path_img = public_path($category->category_img);
                File::delete($path_img);
                // Resize the image to 500x400 pixels
                /* $resizedImage = Image::make($request->file('imagefile'))->resize(500, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($request->file('imagefile')->getClientOriginalExtension());
                $path = $request->file('imagefile')->store('public/uploads', $resizedImage); */
                $path = $request->file('imagefile')->store('public/uploads');
                $category->category_img = Storage::url($path);
            }
            $category->category_name = $request->name;
            $category->category_status = $request->status;
            $category->save();
            return back()->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function orderlist()
    {
        $orderList = [];
        $orderList = OrderMaster::with('getuserName')->where('order_status','>=', 2)->where('payment_status','>=',2)->orderby('created_at', 'desc')->get();
        $todayorderList = [];
        $todayorderList = OrderMaster::with('getuserName')->where('order_status', '>=', 2)->where('payment_status','>=', 2)->where('created_at','>=',date("Y-m-d"))->orderby('created_at', 'desc')->get();
        return view('admin.orderlist', compact('orderList','todayorderList'));
    }

    public function overallorderlist()
    {
        $orderList = [];
        $orderList = OrderMaster::with('getuserName')->orderby('created_at', 'desc')->get();
        return view('admin.allorderlist', compact('orderList'));
    }

    public function orderedit($id)
    {
        $orderMaster = OrderMaster::with('getuserName')->findOrFail($id);
        $orderItems = OrderItem::where('order_id', $orderMaster->id)->get();
        // dd($orderMaster);
        return view('admin.orderedit', compact('orderMaster', 'orderItems'));
    }

    public function orderItemUpdate($id, Request $request)
    {
        $delivery_notes = $request->delivery_notes;
        $delivery_date = date("Y-m-d", strtotime($request->delivery_date));
        $orderitemid = $request->orderitemid;
        $update_item = [];
        if ($delivery_date != "1970-01-01") {
            $update_item['delivery_date'] = $delivery_date;
        }
        if ($delivery_notes != "") {
            $update_item['delivery_notes'] = $delivery_notes;
        }

        if (count($update_item)) {
            $orderItems = OrderItem::where('id', $orderitemid)->update(['delivery_date' => $delivery_date, 'delivery_notes' => $delivery_notes]);
        } else {
            return back()->with('failed', 'Nothing to update');
        }
        if ($orderItems) {
            return back()->with('success', 'Successfully Updated');
        } else {
            return back()->with('failed', 'Unable to update');
        }
    }

    public function userlist()
    {
        $user_list = User::get();
        // $user_list = User::withTrashed()->get();
        return view('admin.userlist', compact('user_list'));
    }

    public function useredit($id)
    {
        $user_list = User::findOrFail($id);
        $orderList = OrderMaster::with('getuserName')->where('user_id', $id)->where('order_status', '>=', 2)->where('payment_status','>=', 2)->orderby('created_at', 'desc')->get();
        $orderItems = OrderItem::where('order_id', '1')->get();
        return view('admin.useredit', compact('user_list', 'orderItems', 'orderList'));
    }

    public function feesdetails(CartFee $cartfee)
    {
        $page_data = $cartfee->get();
        return view('admin.feesdetails', compact('page_data'));
    }

    public function deletefeesdetails($id, CartFee $cartfee)
    {
        $fetch_data = $cartfee->findorfail($id);
        if ($fetch_data != null) {
            $fetch_data->delete();
        }
        return back()->with('success', 'Deleted Successfully');
    }

    public function savefeesdetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fees_name' => 'required|string|max:15|unique:'.CartFee::class.',fees_name',
            'fees_value' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $banner = new CartFee();
        $banner->fees_name = $request->fees_name;
        $banner->fees_value = $request->fees_value;
        if ($banner->save()) {
            return back()->with('success', 'Fees Details added successfully');
        } else {
            return back()->with('error', 'Faild to Add');
        }
    }

    public function websitedata(Website $website)
    {
        $page_data = $website->first();
        // dd($page_data);
        return view('admin.sitedetails', compact('page_data'));
    }

    public function deletewebsite($id, Website $website)
    {
        $fetch_data = $website->findorfail($id);
        if ($fetch_data != null) {
            $fetch_data->delete();
        }
        return back()->with('success', 'Deleted Successfully');
    }

    public function savewebsite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_logo' => 'nullable|file|mimes:png|max:1000',
            'site_desc' => 'nullable|string|max:200',
            'site_address' => 'required|string|max:100',
            'site_email' => 'required|email|string|lowercase|max:30',
            'site_mobile' => 'required|numeric|digits:10',
            'site_gpay_img' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
        ]);
        // dd($validator->fails());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $website = Website::first();
        if($request->hasFile('site_logo')){
            
            // $path = public_path($website->site_logo);
            // File::delete($path);

            $newPath = $request->file('site_logo')->store('public/website');
            $website->site_logo = Storage::url($newPath);
        }
        $website->site_desc = $request->site_desc;
        $website->site_address = $request->site_address;
        $website->site_email = $request->site_email;
        $website->site_mobile = $request->site_mobile;
        if($request->hasFile('site_gpay_img')){
            // $gpayImgpath = public_path($website->site_gpay_img);
            // File::delete($gpayImgpath);

            $newGpayPath = $request->file('site_gpay_img')->store('public/website');
            $website->site_gpay_img = Storage::url($newGpayPath);
        }
        if ($website->update()) {
            return back()->with('success', 'Site Details Updated Successfully');
        } else {
            return back()->with('error', 'Faild to update');
        }
    }

    public function removeSiteImg($id=null): void
    {
        $img_data = Website::find($id);
        if($img_data != null){
            $path = public_path($img_data->brand_img);
            File::delete($path);
        }
    }
}
