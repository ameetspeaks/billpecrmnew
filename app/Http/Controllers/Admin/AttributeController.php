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

use App\Models\Unit;
use App\Models\Attribute;

use DataTables;

class AttributeController extends Controller
{
    public function index()
    {
        return view('admin.attribute.index');
    }

    public function add()
    {
        return view('admin.attribute.add');
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
          
            $attribute = Attribute::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.attribute.index')->with('message', 'Attribute added successfully');
        }
    }

    public function edit($id)
    {
        $attribute = Attribute::where('id',$id)->first();
        return view('admin.attribute.edit', compact('attribute'));
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
            
            $attribute = Attribute::where('id',$request->attribute_id)->first();
            $attribute->name = $request->name;
            $attribute->save();
            DB::commit();
            return redirect()->route('admin.attribute.index')->with('message', 'Attribute updated successfully');
        }
    }

    public function delete($id)
    {
        $attribute = Attribute::where('id',$id)->first();
        $attribute->destroy($id);
        return response()->json(['status' => true,'message' => 'Attribute Deleted successfully']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Attribute::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.attribute.index');
    }
}
