<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class BrandController extends Controller
{
    public function list()
    {
        $brand_list = Brand::get();
        return view('admin.brandlist', compact('brand_list'));
    }
    public function create()
    {
        return view('admin.brandnew');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:45|unique:brands,brand_name',
            'brand_img' => 'required|file|mimes:jpeg,jpg,png|max:1000'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('brand_img')) {
            
            $path = $request->file('brand_img')->store('public/brand');
            $brand = new Brand();
            $brand->brand_name = $request->brand_name;
            $brand->brand_img = Storage::url($path);
            $brand->created_by = Auth::user()->id;
            $brand->save();
            return back()->with('success', 'File uploaded successfully');
        }
        return back()->with('error', 'Faild to upload');
    }
    public function edit($id)
    {
        $brand_data = Brand::findOrFail($id);
        return view('admin.brandedit', compact('brand_data'));
    }
    public function update($id, Request $request)
    {
        try{
        $brand = Brand::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:45|unique:brands,brand_name,'.$id,
            'brand_img' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'brand_status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('brand_img')) {
            $this->destroy($id);
            $path = $request->file('brand_img')->store('public/brand');
            $brand->brand_img = Storage::url($path);
        }
        $brand->brand_name = $request->brand_name;
        $brand->brand_status = $request->brand_status;
        $brand->save();
        return back()->with('success', 'Brand updated successfully');
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    }
    public function destroy($id=null): void
    {
        $img_data = Brand::find($id);
        if($img_data != null){
            $path = public_path($img_data->brand_img);
            File::delete($path);
        }
    }
}
