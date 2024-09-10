<?php

namespace App\Http\Controllers\Store;

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

use App\Models\SubscriptionPackage;
use App\Models\Store;
use App\Models\Module;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use App\Models\CentralLibrary;
use App\Models\Attribute;
use App\Models\User;
use App\Models\BillDetail;

use Session;
use DataTables;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProduct;
use App\Imports\ImportProduct;
use Auth;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function pos()
    {
        $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();
        $store = Store::where('id',Session::get('store_id'))->first();
        $categories = Category::withCount('productsByStore')->where('module_id',$store->module_id)->where('status',1)->get();

        $products = Product::with('productCategory')->where('store_id',$store->id)->where('stock', '>' , 0)->get();
        $customers = User::where('role_type', 4)->get();
        // print_r($customers->toarray()); die;
        return view('store.storeAdmin.pos', compact('categories','products','customers'));
    }

    public function getProductByName(Request $request)
    {
        $storeInvertry = Product::with('productCategory')->where('product_name', 'LIKE', '%'.$request->dInput.'%')->where('store_id',Session::get('store_id'))->where('status', '1')->where('stock', '>' , 0)->get();
        if(count($storeInvertry) > 0)
        {
            return response()->json(['success' => 1, 'message' => 'Inventory Products detail', 'Product' => $storeInvertry]);
        }
        
        // Products check in Centrallib_product
        $centralProducts = CentralLibrary::with('productCategory')->where('product_name', 'LIKE', '%'.$request->product_name.'%')->where('status', '1')->get();
        
        if (count($centralProducts) > 0) {
            return response()->json(['success' => 2, 'message' => 'Library Product List', 'Product' => $centralProducts]);
        } else {
            return response()->json(['success' => false, 'message' => 'Products not found, Considered from adding.']);
        } 
    }


    public function getProductByBarcode(Request $request)
    {
        $storeInvertry = Product::with('productCategory')->where('barcode', 'LIKE', '%'.$request->dInput.'%')->where('store_id',Session::get('store_id'))->where('status', '1')->where('stock', '>' , 0)->first();
        if($storeInvertry)
        {
            return response()->json(['success' => 1, 'message' => 'Inventory Products detail', 'Product' => $storeInvertry]);
        }else {
            return response()->json(['success' => false, 'message' => 'Products not found, Considered from adding.']);
        } 
    }

    
    public function getProductByCategory(Request $request)
    {
        if($request->catid == 'all')
        {
            $storeInvertry = Product::with('productCategory')->where('store_id',Session::get('store_id'))->where('status', '1')->where('stock', '>' , 0)->get();
        }else{
            $storeInvertry = Product::with('productCategory')->where('store_id',Session::get('store_id'))->where('status', '1')->where('category', $request->catid)->where('stock', '>' , 0)->get();
        }
        return response()->json(['success' => true, 'message' => 'Inventory Products detail', 'Product' => $storeInvertry]);
    }

    public function quickAddProduct(Request $request)
    {
        $store = Store::where('id',Session::get('store_id'))->first();
        $product = CentralLibrary::where('id',$request->product_id)->first();

        //check product exist or not
        $exists = Product::where('product_name', $product->product_name)
        ->where('quantity', $product->quantity)
        ->where('unit', $product->unit)
        ->where('store_id', $store->id)
        ->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'A product with the same name, qtn, and unit already exists in this store.']);
        }
        

        //check barcode
        $existingProductWithSameName = Product::where('product_name', $product->product_name)
        ->where('store_id', $store->id)
        ->first();

        $barcode = $product->barcode;

        if ($existingProductWithSameName != null) {
            // If a product with the same name and store exists, use its barcode
            $barcode = $existingProductWithSameName->barcode;
        } elseif ($barcode != null) {
            // If a barcode is provided, check for its uniqueness
            $existingProductWithSameBarcode = Product::where('barcode', $barcode)
                ->where('store_id', $store->id)
                ->first();

            if ($existingProductWithSameBarcode != null) {
                // If a product with the same barcode exists, return an error
                return response()->json(['success' => false, 'message' => 'Add a unique barcode.']);
            }
        }
        
        $product = Product::create([
            'store_id'           => $store->id,
            'module_id'          => $store->module_id,
            'category'           => $product->category,
            'subCategory_id'     => $product->subCategory_id,
            'barcode'            => $barcode,
            'product_image'      => $product->product_image,
            'product_name'       => $product->product_name,
            'quantity'           => $product->quantity,
            'mrp'                => $product->mrp,
            'retail_price'       => $product->retail_price,
            'wholesale_price'    => $product->wholesale_price,
            'members_price'      => $product->members_price,
            'purchase_price'     => $product->purchase_price,
            'stock'              => $request->stock,
            'status'             => '1',  
        ]);

        return response()->json(['success' => true, 'message' => 'Product added successfully']);
    }

    public function addCustomer(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
               'whatsapp_no' => 'required|numeric|digits:10|unique:users',
            ];
             
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
            } else {
                
                $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();
                $roleID = Role::where('id',4)->first();

                $password = $request->password;
                if($request->password){
                  $password = bcrypt($request->password);
                }
                #add user
                $userAdd = User::create([
                    'user_id'           => $userLogin->id,
                    'name'              => $request->name,
                    'role_type'         => $roleID->id,
                    'whatsapp_no'       => $request->whatsapp_no,
                ]);
                #assign role to user
                $userAdd->syncRoles($roleID->id);
                $userAdd->save();
                // $token = $userAdd->createToken('billpe.cloud')->accessToken;
               
                DB::commit();

                $customers = User::where('user_id',$userLogin->id)->get();
                return response()->json(['success' => true, 'message' => 'Customer added successfully', 'customer' => $customers]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function createBill(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_details' => 'required|array',
                'product_details.*.id' => 'required|numeric',
                'product_details.*.product_name' => 'required|string',
                'product_details.*.qtn' => 'required|numeric',
                'product_details.*.price' => 'required|numeric',
                // 'customerName' => 'required|string',
                // 'customerNumber' => 'required|numeric|digits:10',
                'subtotal'=>'required|numeric',
                'discount'=>'required|numeric',
                'grandtotal'=>'required|numeric',
                'payment_method'=>'required|string',
            ];
             
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $billCount = BillDetail::where('store_id', Session::get('store_id'))->count();
                $uniqueId = Str::random(8) . time();

                $newBillGenerate = new BillDetail();
                $newBillGenerate->store_id = Session::get('store_id');
                $newBillGenerate->product_detail = json_encode($request->product_details);
                $newBillGenerate->customer_name = $request->customerName;
                $newBillGenerate->customer_number = $request->customerNumber;
                $newBillGenerate->amount = $request->subtotal;
                $newBillGenerate->discount = $request->discount;
                $newBillGenerate->total_amount = $request->grandtotal;
                $newBillGenerate->payment_methord = $request->payment_method;
                $newBillGenerate->due_amount = $request->due_amount;
                $newBillGenerate->due_date = $request->due_date;
                $newBillGenerate->unique_id = $uniqueId;
                $newBillGenerate->combined_id = $billCount + 1 . $uniqueId;
                $newBillGenerate->bill_number = $billCount + 1;
                $newBillGenerate->save();

                foreach ($request->product_details as $productDetail) {
                    
                    $product = Product::where('id', $productDetail['id'])->first();
                   
                    if ($product) {
                        if ((int)$product->stock > 0 && (int) $request->qtn<=(int)$product->stock) {
                            $product->stock = (int)$product->stock - (int) $productDetail['qtn'];
                            $product->save();
                        }
                    }
                }

                $invoiceUrl = url('invoice/'.$newBillGenerate->store_id. '/' . $newBillGenerate->combined_id);
                DB::commit();
                $response = ['success' => true, 'message' => 'Bill created successfully', 'invoiceUrl'=> $invoiceUrl, 'data' => $newBillGenerate];
            }

            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function salesList(Request $request)
    {
        $data = BillDetail::where('store_id',Session::get('store_id'))->orderBY('created_at','ASC')->get();
        if(\request()->ajax()){
            $data = BillDetail::where('store_id',Session::get('store_id'))->orderBY('created_at','ASC')->get();

            foreach($data as $datas)
            {
                $datas->createBillDate = date('Y-m-d', strtotime($datas->created_at));
            }

            return DataTables::of($data)
                ->make(true);
        }
        return view('store.storeAdmin.sales-list');
    }

    public function salesDetail($id)
    {
        $sale = BillDetail::with('store')->where('id',$id)->first();   
        // print_r($sale->toarray()); die;
        return view('store.storeAdmin.sales-detail', compact('sale'));
    }

    public function invoiceReport(Request $request)
    {
        $data = BillDetail::where('store_id',Session::get('store_id'))->orderBY('created_at','ASC')->get();
        if(\request()->ajax()){
            $data = BillDetail::where('store_id',Session::get('store_id'))->orderBY('created_at','ASC')->get();

            foreach($data as $datas)
            {
                $datas->createBillDate = date('Y-m-d', strtotime($datas->created_at));
                $datas->grandTotal = $datas->total_amount + $datas->due_amount;
            }

            return DataTables::of($data)
                ->make(true);
        }
        return view('store.storeAdmin.invoice-report');
    }
}
