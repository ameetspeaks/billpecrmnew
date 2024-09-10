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
use App\Models\Module;
use App\Models\Store;
use App\Models\PromotionalBanner;
use App\Models\HomepageVideo;
use App\Models\Tutorial;

use DataTables;

class TutorialController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Tutorial::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.tutorial.index');
    }

    public function add()
    {
        $stores = Store::all();
        $modules = Module::where('status',1)->get();
        return view('admin.tutorial.add', compact('stores','modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'modules_id' => 'required',
            'title' => 'required',
            'discription' => 'required',
            'url' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $tutorial = Tutorial::create([
                'module_id'            => implode(',',$request->modules_id),
                'title'                => $request->title,
                'discription'          => $request->discription,
                'video_url'            => $request->url,
                'status'               => '1',
            ]);
            DB::commit();
            return redirect()->route('admin.tutorial.index')->with('message', 'Tutorial added successfully');
        }
    }


    public function edit($id)
    {
        $tutorial = Tutorial::where('id',$id)->first();
        $stores = Store::all();
        $modules = Module::where('status',1)->get();
        return view('admin.tutorial.edit', compact('stores','modules','tutorial'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'modules_id' => 'required',
            'title' => 'required',
            'discription' => 'required',
            'url' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $tutorial = Tutorial::where('id', $request->tutorial_id)->first();
            $tutorial->module_id = implode(',',$request->modules_id);
            $tutorial->title = $request->title;
            $tutorial->discription = $request->discription;
            $tutorial->video_url = $request->url;
            $tutorial->save();

            DB::commit();
            return redirect()->route('admin.tutorial.index')->with('message', 'Tutorial updated successfully');
        }
    }

    public function delete($id)
    {
        $tutorial = Tutorial::where('id',$id)->first();
        $tutorial->destroy($id);
        return response()->json(['status' => true,'message' => 'Tutorial Deleted.']);
    }
}
