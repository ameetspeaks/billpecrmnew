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
use App\Models\TemplateType;

class TemplateTypeController extends Controller
{
    public function templateType()
    {
        if(\request()->ajax()){
            $data = TemplateType::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.template.type.index');
    }

    public function add()
    {
        return view('admin.template.type.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:template_types',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $type = TemplateType::create([
                'name'  => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.template.type')->with('message', 'Template Type added successfully');
        }
    }

    public function edit($id)
    {
        $type = TemplateType::where('id', $id)->first();
        return view('admin.template.type.edit', compact('type'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:template_types,name,'.$request->temTypeId,
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $type = TemplateType::where('id', $request->temTypeId)->first();
            $type->name       = $request->name;
            $type->save();
            
            DB::commit();
            return redirect()->route('admin.template.type')->with('message', 'Template Type updated successfully');
        }
    }
}
