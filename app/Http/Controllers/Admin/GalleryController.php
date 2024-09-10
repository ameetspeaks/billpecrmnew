<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::all();
        $categorys = Category::where('status', 1)->get();
        return view('admin.gallery.index', compact('categorys','gallery'));
    }

    public function add()
    {
        $categorys = Category::with('products')->where('status', 1)->get();
        return view('admin.gallery.add', compact('categorys'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'category'=>'required|exists:categories,id',
            'product_id'=>'required|exists:products,id',   
            'image.*' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
           
            $gallery=array();
            foreach($request->image as $image){
                #save image
                $gallery_image = $image;
                if ($gallery_image) {
                    $path  = config('image.profile_image_path_view');
                    $gallery_image = CommonController::saveImage($gallery_image, $path , 'gallery');
                }else{
                    $gallery_image = null;
                }

                $gallery=new Gallery(); 
                $gallery->module_id=$request->module_id;
                $gallery->category_id=$request->category;
                $gallery->product_id=$request->product_id;
                $gallery->image= $gallery_image;
                $gallery->save();  
            }   

            DB::commit();
            return redirect()->route('admin.gallery.add')->with('message', 'Images have been uploaded');
        }
    }
}
