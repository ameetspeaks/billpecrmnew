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

use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.subcategory.index');
    }

    public function add()
    {
        $categorys = Category::all();
        return view('admin.subcategory.add', compact('categorys'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'categoryId' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            foreach($request->name as $name){
                $category = SubCategory::create([
                    'name'               => $name,
                    'category_id'        => $request->categoryId,
                    'status'             => '1',
                ]);
            }
           
            DB::commit();
            return redirect()->route('admin.subcategory.index')->with('message', 'Sub Category added successfully');
        }
    }

    public function edit($id)
    {
        $categorys = Category::all();
        $subCat = SubCategory::where('id', $id)->first();
        return view('admin.subcategory.edit', compact('categorys','subCat'));
    }


    public function update(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required',
            'categoryId' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $subcategory = SubCategory::where('id', $request->subcatid)->first();

            #save image
            $subcategry_image = $request->image;
            if ($subcategry_image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $subcategory->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $subcategry_image = CommonController::saveImage($subcategry_image, $path , 'subcategory');
            }else{
                $subcategry_image = $category->image;
            }

            $subcategory->name = $request->name;
            $subcategory->category_id = $request->categoryId;
            $subcategory->image = $subcategry_image;
            $subcategory->save();

            DB::commit();
            return redirect()->route('admin.subcategory.index')->with('message', 'Sub Category updated successfully');
        }
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = SubCategory::with('category')->whereNotNull('category_id')->get();
            // print_r($data->toarray()); die;
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.subcategory.index');
    }
}
