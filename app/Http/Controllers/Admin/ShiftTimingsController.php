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

use App\Models\ShiftTimings;

use DataTables;

class ShiftTimingsController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = ShiftTimings::all();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.shiftTimings.index');
    }

    public function edit($id)
    {
        $shiftTimings = ShiftTimings::where('id',$id)->first();
        if(empty($shiftTimings)){
            return redirect()->back();
        }
        return view('admin.shiftTimings.edit', compact('shiftTimings'));
    }
    public function delete($id)
    {
        $shiftTimings = ShiftTimings::where('id', $id)->delete();
        return redirect()->route('admin.shiftTimings.index')->with('message', 'Shift deleted successfully');
    }
    public function add()
    {
        return view('admin.shiftTimings.add');
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'type' => 'required|string',
            'name' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $shiftTimings = new ShiftTimings;
            $shiftTimings->type = $request->type;
            $shiftTimings->name = $request->name;
            $shiftTimings->from = $request->from;
            $shiftTimings->to = $request->to;
            $shiftTimings->save();
            
            DB::commit();
            return redirect()->route('admin.shiftTimings.index')->with('message', 'Shift added successfully');
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'shiftID' => 'required|numeric',
            'type' => 'required|string',
            'name' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $shiftTimings = ShiftTimings::where('id', $request->shiftID)->first();
            $shiftTimings->type = $request->type;
            $shiftTimings->name = $request->name;
            $shiftTimings->from = $request->from;
            $shiftTimings->to = $request->to;
            $shiftTimings->save();
            
            DB::commit();
            return redirect()->route('admin.shiftTimings.index')->with('message', 'Shift updated successfully');
        }
    }
}
