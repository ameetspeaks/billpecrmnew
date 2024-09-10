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

use DataTables;
use App\Models\TemplateCategory;

class TemplateCategoryController extends Controller
{
    public function category()
    {
        return view('admin.template.category.index');
    }

    public function add()
    {
        return view('admin.template.category.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:roles',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $category = TemplateCategory::create([
                'name'  => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.template.category')->with('message', 'Category added successfully');
        }
    }

    public function edit($id)
    {
        $category = TemplateCategory::where('id', $id)->first();
        return view('admin.template.category.edit', compact('category'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:roles,name,'.$request->roleID,
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $category = TemplateCategory::where('id', $request->categoryID)->first();
            $category->name       = $request->name;
            $category->save();
            
            DB::commit();
            return redirect()->route('admin.template.category')->with('message', 'Category updated successfully');
        }
    }

    public function getDatatable()
    {
        $data = TemplateCategory::get();

        if(\request()->ajax()){
            $data = TemplateCategory::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.template.category');
    }
}
