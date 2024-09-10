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

use DataTables;

use App\Models\Store;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function add()
    {
        $modules = Module::all();
        return view('admin.category.add', compact('modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required',
            'module_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

             #save image
             $categry_image = $request->image;
             if ($categry_image) {
                 $path  = config('image.profile_image_path_view');
                 $categry_image = CommonController::saveImage($categry_image, $path , 'category');
             }else{
                 $categry_image = null;
             }

             $category = Category::create([
                'name'               => $request->name,
                'module_id'          => $request->module_id,
                'status'             => '1',
                'image'              => $categry_image,
            ]);
            DB::commit();
            return redirect()->route('admin.category.index')->with('message', 'Category added successfully');
        }
    }

    public function edit($id)
    {
        $modules = Module::all();
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('modules','category'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required',
            'module_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $category = Category::where('id', $request->catid)->first();

            #save image
            $categry_image = $request->image;
            if ($categry_image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $category->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $categry_image = CommonController::saveImage($categry_image, $path , 'category');
            }else{
                $categry_image = $category->image;
            }

            $category->name = $request->name;
            $category->module_id = $request->module_id;
            $category->image = $categry_image;
            $category->save();

            DB::commit();
            return redirect()->route('admin.category.index')->with('message', 'Category updated successfully');
        }
    }

    public function delete($id)
    {
        $category = Category::where('id',$id)->first();
        $category->destroy($id);
        return response()->json(['status' => true,'message' => 'Category Deleted successfully']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Category::with('module')->whereNotNull('module_id')->get();
            // print_r($data->toarray()); die;
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.category.index');
    }
}