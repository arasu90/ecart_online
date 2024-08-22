<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $product_list = Product::get();
        return view('admin.productlist', compact('product_list'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_list  = Category::where('category_status', 1)->get();
        $brand_list  = Brand::get();
        $colors_list  = Color::get();
        // dd($colors_list);
        return view('admin.productnew', compact('category_list', 'brand_list', 'colors_list'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|int',
            'product_name' => 'required|string',
            'product_mrp' => 'required|numeric',
            'product_rate' => 'required|numeric',
            'product_desc' => 'nullable|string|max:250',
            'product_detail' => 'nullable|string',
            'product_img_1' => 'required|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_2' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_3' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_4' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_5' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('product_img_1')) {
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->category_id = $request->category_name;
            $product->product_mrp = $request->product_mrp;
            $product->product_rate  = $request->product_rate;
            $product->product_desc  = $request->product_desc;
            $product->product_detail = $request->product_detail;
            $product->created_by = Auth::user()->id;
            $product->product_status = 1;
            $product->save();
            $product_id = $product->id;


            if(isset($request->color_set) && isset($request->color_value)){
                foreach($request->color_value as $value){
                    DB::table('product_colors')->insert([
                        'product_id' => $product_id,
                        'color_id' => $value
                    ]);
                }
                DB::table('products')->update([
                    'color_set' => $request->color_set
                ],['id',$product_id]);
            }

            /* if(isset($request->size_set)){
                DB::table('product_sizes')->insert([
                    'product_id' => $product_id,
                    'size_name' => $request->size_name,
                    'size_mrp' => $request->size_mrp,
                    'size_rate' => $request->size_rate,
                    'color_id' => $request->size_color_name
                ]);

                DB::table('products')->update([
                    'size_set' => $request->size_set
                ],['id',$product_id]);
            }
            
            if(isset($request->type_set)){
                DB::table('products')->update([
                    'cable_type_set' => $request->cable_type
                ],['id',$product_id]);
            } */

            
            $product_img = new ProductImg();
            $path_1 = $request->file('product_img_1')->store('public/products');
            $product_img->image_name = Storage::url($path_1);
            $product_img->product_id = $product_id;
            $product_img->image_status = 1;
            $product_img->default_img = 1;
            $product_img->created_by = Auth::user()->id;
            $product_img->save();
            if ($request->hasFile('product_img_2')) {
                $path_2 = $request->file('product_img_2')->store('public/products');
                $product_img = new ProductImg();
                $product_img->image_name = Storage::url($path_2);
                $product_img->product_id = $product_id;
                $product_img->image_status = 1;
                $product_img->created_by = Auth::user()->id;
                $product_img->save();
            }
            if ($request->hasFile('product_img_3')) {
                $path_3 = $request->file('product_img_3')->store('public/products');
                $product_img = new ProductImg();
                $product_img->image_name = Storage::url($path_3);
                $product_img->product_id = $product_id;
                $product_img->image_status = 1;
                $product_img->created_by = Auth::user()->id;
                $product_img->save();
            }
            if ($request->hasFile('product_img_4')) {
                $path_4 = $request->file('product_img_4')->store('public/products');
                $product_img = new ProductImg();
                $product_img->image_name = Storage::url($path_4);
                $product_img->product_id = $product_id;
                $product_img->image_status = 1;
                $product_img->created_by = Auth::user()->id;
                $product_img->save();
            }
            if ($request->hasFile('product_img_5')) {
                $path_5 = $request->file('product_img_5')->store('public/products');
                $product_img = new ProductImg();
                $product_img->image_name = Storage::url($path_5);
                $product_img->product_id = $product_id;
                $product_img->image_status = 1;
                $product_img->created_by = Auth::user()->id;
                $product_img->save();
            }
            return back()->with('success', 'Product added and image uploaded successfully');
        }
        return back()->with('error', 'Faild to upload');
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category_list  = Category::where('category_status', 1)->get();
        $product_data = Product::with(['product_img' => function($query) {
            $query->orderBy('default_img', 'desc');
        }])->findorfail($id);
        return view('admin.productedit', compact('product_data', 'category_list'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|int',
            'product_name' => 'required|string',
            'product_mrp' => 'required|numeric',
            'product_rate' => 'required|numeric',
            'status' => 'required|boolean',
            'product_desc' => 'nullable|string|max:250',
            'product_detail' => 'nullable|string',
            'product_img_1' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_2' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_3' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_4' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'product_img_5' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_name;
        $product->product_mrp = $request->product_mrp;
        $product->product_rate  = $request->product_rate;
        $product->product_desc  = $request->product_desc;
        $product->product_detail = $request->product_detail;
        $product->created_by = Auth::user()->id;
        $product->product_status = $request->status;
        $product->save();
        $product_id = $id;
        if(isset($request->delete_img)){
        foreach($request->delete_img as $value){
            $this->destroy($value);
        }
    }
        if ($request->hasFile('product_img_1')) {
            $img_data = ProductImg::where('product_id',$product_id)->where('default_img',1)->first();
            // dd($img_data);
            if($img_data != null){
                $this->destroy($img_data->id);
            }
            $product_img = new ProductImg();
            $path_1 = $request->file('product_img_1')->store('public/products');
            $product_img->image_name = Storage::url($path_1);
            $product_img->product_id = $product_id;
            $product_img->image_status = 1;
            $product_img->default_img = 1;
            $product_img->created_by = Auth::user()->id;
            $product_img->save();
        }
        if ($request->hasFile('product_img_2')) {
            $path_2 = $request->file('product_img_2')->store('public/products');
            $product_img = new ProductImg();
            $product_img->image_name = Storage::url($path_2);
            $product_img->product_id = $product_id;
            $product_img->image_status = 1;
            $product_img->created_by = Auth::user()->id;
            $product_img->save();
        }
        if ($request->hasFile('product_img_3')) {
            $path_3 = $request->file('product_img_3')->store('public/products');
            $product_img = new ProductImg();
            $product_img->image_name = Storage::url($path_3);
            $product_img->product_id = $product_id;
            $product_img->image_status = 1;
            $product_img->created_by = Auth::user()->id;
            $product_img->save();
        }
        if ($request->hasFile('product_img_4')) {
            $path_4 = $request->file('product_img_4')->store('public/products');
            $product_img = new ProductImg();
            $product_img->image_name = Storage::url($path_4);
            $product_img->product_id = $product_id;
            $product_img->image_status = 1;
            $product_img->created_by = Auth::user()->id;
            $product_img->save();
        }
        if ($request->hasFile('product_img_5')) {
            $path_5 = $request->file('product_img_5')->store('public/products');
            $product_img = new ProductImg();
            $product_img->image_name = Storage::url($path_5);
            $product_img->product_id = $product_id;
            $product_img->image_status = 1;
            $product_img->created_by = Auth::user()->id;
            $product_img->save();
        }
        if ($product->save()) {
            return back()->with('success', 'Product added and image uploaded successfully');
        } else {
            return back()->with('error', 'Faild to upload');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id=null): void
    {
        $img_data = ProductImg::find($id);
        if($img_data != null){
            $path = public_path($img_data->image_name);
            File::delete($path);
            $img_data->delete();
        }
    }
}
