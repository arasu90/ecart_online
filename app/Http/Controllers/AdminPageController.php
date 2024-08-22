<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
            $resizedImage = Image::make($request->file('imagefile'))->resize(500, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($request->file('imagefile')->getClientOriginalExtension());

            $path = $request->file('imagefile')->store('public/uploads', $resizedImage);
            $category = new Category();
            $category->category_name = $request->name;
            $category->category_img = Storage::url($path);
            $category->category_status = 1;
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
        try{
        $category = Category::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:45|unique:categories,category_name,'.$id,
            'imagefile' => 'nullable|file|mimes:jpeg,jpg,png|max:1000',
            'status' => 'required|between:0,1'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        if ($request->hasFile('imagefile')) {
            $path = public_path($category->category_img);
            File::delete($path);

            // Resize the image to 500x400 pixels
    $resizedImage = Image::make($request->file('imagefile'))->resize(500, 400, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    })->encode($request->file('imagefile')->getClientOriginalExtension());


            $path = $request->file('imagefile')->store('public/uploads', $resizedImage);
            $category->category_img = Storage::url($path);
        }
        $category->category_name = $request->name;
        $category->category_status = $request->status;
        $category->save();

        return back()->with('success', 'Category updated successfully');
        }
        catch(\Exception $e){
        
            echo $e->getMessage();
        }
    }

    
}
