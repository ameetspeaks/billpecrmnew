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
use App\Imports\ImportCentralLibrary;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CentralLibrary;
use App\Models\Product;
use App\Models\SubscriptionPackage;
use App\Models\Module;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Store;
use App\Models\Coupan;

class CoupanController extends Controller
{
    public function index()
    {
        return view('admin.coupan.index');
    }

    public function add()
    {
        $stores = Store::all();
        return view('admin.coupan.add',compact('stores'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'discount' => 'required',
            'discountType' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $stores = DB::table('stores');
            if ($request->package !== 'all') {
                $stores = $stores->where('package_id', $request->package === 'trial' ? 1 : 2);
            }
            if (!empty($selectedStores)) {
                $stores = $stores->whereIn('id', $selectedStores);
            }
            $stores = $stores->get()->pluck('id')->toarray();

            $coupan = Coupan::create([
                'name'              => $request->name,
                'code'              => $request->code,
                'discount'          => $request->discount,
                'discountType'      => $request->discountType,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'package_type'      => $request->package,
                'minimum_purchase'  => $request->minimum_purchase,
                'store_id'          => implode(',',$stores),

            ]);
            DB::commit();
            return redirect()->route('admin.coupan.index')->with('message', 'Coupan generate successfully');
        }
    }

    public function getStoreByPackage(Request $request)
    {
        if($request->packageSelect == 'all')
        {
            $stores = Store::all();
        }
        if($request->packageSelect == 'trial')
        {
            $stores = Store::where('package_id', 1)->get();
        }

        if($request->packageSelect == 'paid')
        {
            $stores = Store::where('package_id', '!=', 1)->get();
        }
        return response()->json(['stores' => $stores]);
    }

    public function delete($id)
    {
        $coupan = Coupan::where('id',$id)->first();
        $coupan->destroy($id);
        return response()->json(['status' => true,'message' => 'Coupan Deleted successfully']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Coupan::all();
            // print_r($data->toarray()); die;
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.coupan.index');
    }
}
