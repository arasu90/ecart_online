<?php

namespace App\Http\Controllers;

use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_name' => 'required|string',
            'banner_desc' => 'required|string',
            'banner_img' => 'required|file|mimes:jpeg,jpg,png|max:1000'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('banner_img')) {
            $banner = new HomeBanner();
            $banner->banner_name = $request->banner_name;
            $banner->banner_desc = $request->banner_desc;
            $path_1 = $request->file('banner_img')->store('public/banner');
            $banner->banner_img = Storage::url($path_1);
            $banner->created_by = Auth::user()->id;
            $banner->save();
            
            return back()->with('success', 'Product added and image uploaded successfully');
        }
        return back()->with('error', 'Faild to upload');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeBanner $homeBanner)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeBanner $homeBanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeBanner $homeBanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeBanner $homeBanner)
    {
        //
    }

    public function homebanner(HomeBanner $homeBanner)
    {
        $homebanner_data=$homeBanner->get();
        return view('admin.homebanner', compact('homebanner_data'));
    }
   
    public function deletebanner($id,HomeBanner $homeBanner)
    {
        $homebanner_data=$homeBanner->findorfail($id);
        if($homebanner_data != null){
            $path = public_path($homebanner_data->banner_img);
            File::delete($path);
            $homebanner_data->delete();
        }
        return back()->with('success', 'Deleted Successfully');
    }
}
