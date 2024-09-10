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
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = BlogCategory::all();
            // print_r($data->toarray()); die;
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.blog.category.index');
    }

    public function add()
    {
        return view('admin.blog.category.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $category = BlogCategory::create([
                'name'               => $request->name,
                'status'             => '1',
            ]);
            DB::commit();
            return redirect()->route('admin.blog.category')->with('message', 'BLog category added successfully');
        }
    }

    public function edit($id)
    {
        $blogCategory = BlogCategory::where('id',$id)->first();
        return view('admin.blog.category.edit', compact('blogCategory'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $category = BlogCategory::where('id', $request->blogcatid)->first();
            $category->name = $request->name;
            $category->save();

            DB::commit();
            return redirect()->route('admin.blog.category')->with('message', 'Blog category updated successfully');
        }
    }

    public function delete($id)
    {
        $category = BlogCategory::where('id',$id)->first();
        $category->destroy($id);
        return response()->json(['status' => true,'message' => 'Blog category Deleted successfully']);
    }
}
