<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductData;
use App\Models\ProductDataValue;
use App\Models\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function listProduct()
    {
        $product_list = Product::with('defaultImg')->get();
        return view('admin.productlist', compact('product_list'));
    }

    public function newProduct()
    {
        $brand_list = Brand::get();
        $category_list = Category::get();
        return view('admin.productnew', compact('brand_list', 'category_list'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'product_name' => 'required',
            'product_detail' => 'nullable',
            'product_mrp' => 'required',
            'product_price' => 'required',
            'product_tax' => 'required',
            'product_stock' => 'required',
            'product_status' => 'required',
        ]);

        $product = new Product();
        if($request->input('brand_id') !== null){
            $product->brand_id = $request->input('brand_id');
        }
        if($request->input('category_id') !== null){
            $product->category_id = $request->input('category_id');
        }
        $product->product_name = $request->input('product_name');
        $product->product_detail = $request->input('product_detail');
        $product->product_mrp = $request->input('product_mrp');
        $product->product_price = $request->input('product_price');
        $product->product_tax = $request->input('product_tax');
        $product->product_stock = $request->input('product_stock');
        $product->product_status = ($request->input('product_status')) ? 1 : 0;
        $product->save();

        return redirect()->route('admin.productedit', $product->id)->with('success', 'Product added successfully');
    }

    public function editProduct($id)
    {
        $brand_list = Brand::get();
        $category_list = Category::get();
        $product_data = Product::find($id);
        $product_field_list = ProductData::get();
        $product_field_value_list = ProductDataValue::with('product_data')->where('product_id', $id)->get();
        $product_img_list = ProductImg::where('product_id', $id)->get();
        return view('admin.productedit', compact('brand_list', 'category_list', 'product_data', 'product_img_list', 'product_field_list', 'product_field_value_list'));
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        try{
            if(!$product)
            {
                throw new \Exception('Invalid Product ID');
            }

            ProductImg::where('product_id', $id)->delete();
            ProductDataValue::where('product_id', $id)->delete();
            $product->delete();
            return redirect()->route('admin.productlist')->with('success', 'Product deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateProduct($id, Request $request)
    {
        $request->validate([
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'product_name' => 'required',
            'product_detail' => 'nullable',
            'product_mrp' => 'required',
            'product_price' => 'required',
            'product_tax' => 'required',
            'product_stock' => 'required',
            'product_status' => 'required',
        ]);

        $product = Product::find($id);
        if($request->input('brand_id') !== null){
            $product->brand_id = $request->input('brand_id');
        }
        if($request->input('category_id') !== null){
            $product->category_id = $request->input('category_id');
        }
        $product->product_name = $request->input('product_name');
        $product->product_detail = $request->input('product_detail');
        $product->product_mrp = $request->input('product_mrp');
        $product->product_price = $request->input('product_price');
        $product->product_tax = $request->input('product_tax');
        $product->product_stock = $request->input('product_stock');
        $product->product_status = ($request->input('product_status')) ? 1 : 0;
        $product->save();

        return redirect()->route('admin.productedit', $product->id)->with('success', 'Product updated successfully');
    }

    public function addProductField($productid, Request $request)
    {
        $request->validate([
            'product_data_field_id' => 'required',
            'product_data_field_value' => 'required',
        ]);

        $product_data_value = new ProductDataValue();
        $product_data_value->field_id = $request->input('product_data_field_id');
        $product_data_value->field_value = $request->input('product_data_field_value');
        $product_data_value->product_id = $productid;
        $product_data_value->save();

        return redirect()->route('admin.productedit', $productid)->with('success', 'Product data value added successfully');
    }

    public function addProductImg($productid, Request $request)
    {
        $request->validate([
            'product_img' => 'file|mimes:jpeg,jpg|required|max:10000',
        ]);

        $product_img = new ProductImg();
        if($request->input('default_img')){
            DB::select('CALL update_product_default_img(?)', [$productid]);
        }
        $path = $request->file('product_img')->store('uploads', 'public');
        $product_img->product_img = Storage::url($path);
        $product_img->product_id = $productid;
        $product_img->default_img = ($request->input('default_img')) ? 1 : 0;
        $product_img->save();

        return redirect()->route('admin.productedit', $productid)->with('success', 'Product Image added successfully');
    }

    public function removeProductImg($id)
    {
        $product_img = ProductImg::find($id);

        $productid = $product_img->product_id;

        if (File::exists(public_path().$product_img->product_img)) {
            unlink(public_path().$product_img->product_img);
        }
        $product_img->delete();

        return redirect()->route('admin.productedit', $productid)->with('success', 'Product Image Deleted successfully');
    }

    public function prodDataList(Request $request)
    {
        $datafield_data = ProductData::find($request->input('datafield_id'));
        $datafield_list = ProductData::get();
        return view('admin.product_data_field', compact('datafield_data', 'datafield_list'));
    }

    public function addprodData(Request $request)
    {
        $request->validate([
            'datafield_name' => 'required|max:100|string',
            'datafield_status' => 'required',
        ]);
        // dd($request);
        $datafield = new ProductData();
        $datafield->field_name = $request->input('datafield_name');
        $datafield->field_status = ($request->input('datafield_status')) ? 1 : 0;
        $datafield->save();

        return redirect()->route('admin.prodDataList')->with('success', 'Data Field added successfully');
    }

    public function updateprodData($datafieldid, Request $request)
    {
        $request->validate([
            'datafield_name' => 'required|max:100|string',
            'datafield_status' => 'required',
        ]);
        $datafield = ProductData::findOrFail($datafieldid);
        $datafield->field_name = $request->input('datafield_name');
        $datafield->field_status = ($request->input('datafield_status')) ? 1 : 0;
        $datafield->save();

        return redirect()->route('admin.prodDataList', ['datafield_id' => $datafieldid])->with('success', 'Data Field updated successfully');
    }

    public function deleteprodData($id)
    {
        $datafield = ProductData::find($id);
        try {
            if (!$datafield) {
                throw new \Exception('Invalid Data Field ID');
            }

            $datafield->delete();
            return redirect()->route('admin.prodDataList')->with('success', 'Data Field deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
