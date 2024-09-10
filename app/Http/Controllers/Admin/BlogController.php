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
use App\Models\Unit;
use App\Models\Module;
use App\Models\Blog;

use DataTables;

use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Blog::with('blogCategory')->get();
            // print_r($data->toarray()); die;
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.blog.blogpage.index');
    }

    public function add()
    {
        $categoties = BlogCategory::where('status',1)->get();
        return view('admin.blog.blogpage.add', compact('categoties'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'category_id' => 'required',
            'title' => 'required|unique:blogs,title',
            'meta_title' => 'required',
            'meta_desc' => 'required',
            'meta_keywords' => 'required',
            'post' => 'required',
            'image' => 'required|mimes:webp,png,jpg,jpeg',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            #save image
            $blog_image = $request->image;
            if ($blog_image) {
                $path  = config('image.profile_image_path_view');
                $blog_image = CommonController::saveImage($blog_image, $path , 'blog');
            }else{
                $blog_image = null;
            }
            $blog = Blog::create([
                'blog_category_id'   => $request->category_id,
                'title'              => trim($request->title),
                'blog_image'         => $blog_image,
                'meta_title'         => trim($request->meta_title),
                'meta_description'   => trim($request->meta_desc),
                'meta_keyword'       => trim($request->meta_keywords),
                'post'               => trim($request->post),
                'status'             => '1',
            ]);
            DB::commit();
            return redirect()->route('admin.blog.index')->with('message', 'Blog added successfully');
        }
    }

    public function edit($id)
    {
        $blog = Blog::where('id',$id)->first();
        $categoties = BlogCategory::where('status',1)->get();
        return view('admin.blog.blogpage.edit', compact('categoties','blog'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'category_id' => 'required',
            'title' => 'required|unique:blogs,title,' . $request->blog_id,
            'meta_title' => 'required',
            'meta_desc' => 'required',
            'meta_keywords' => 'required',
            'post' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $blog = BLog::where('id',$request->blog_id)->first();

            #save image
            $blog_image = $request->image;
            if ($blog_image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $blog->blog_image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $blog_image = CommonController::saveImage($blog_image, $path , 'blog');
            }else{
                $blog_image = $blog->blog_image;
            }
            
            $blog->blog_category_id = $request->category_id;
            $blog->title = trim($request->title);
            $blog->blog_image = $blog_image;
            $blog->meta_title = trim($request->meta_title);
            $blog->meta_description	 = trim($request->meta_desc);
            $blog->meta_keyword = trim($request->meta_keywords);
            $blog->post = trim($request->post);
            $blog->save();

            DB::commit();
            return redirect()->route('admin.blog.index')->with('message', 'Category updated successfully');
        }
    }

    public function delete($id)
    {
        $blog = Blog::where('id',$id)->first();
        $blog->destroy($id);
        return response()->json(['status' => true,'message' => 'Blog Deleted successfully']);
    }

    public function uploadImage(Request $request)
    {
        $path  = config('image.profile_image_path_view');
        $link = CommonController::saveImage($request->image, $path , 'blogText');

        return response()->json(['url' => $link]);
    }

    public function deleteImage(Request $request)
    {
        $find = url('/storage');
        $pathurl = str_replace($find, "", $request->url);

        if(File::exists('storage'.$pathurl))
        {
            File::delete('storage'.$pathurl);
        }

        return response()->json(['status' => true, 'msg' => 'Image delete from storage.']);
    }


}
