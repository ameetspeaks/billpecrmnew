<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\Store;
use App\Models\Module;
use App\Models\StoreType;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\BillDetail;
use App\Models\Testing;
use App\Models\Attribute;
use App\Models\AppVersion;
use App\Models\TemplateCategory;
use App\Models\TemplateMarket;
use App\Models\TemplateOffer;
use App\Models\VendorStockPurchase;
use App\Models\Coupan;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Verifications;
use App\Models\Kot;
use App\Models\BillToken;
use App\Models\StockTransfer;
use App\Models\ProductVariation;
use App\Models\WarehouseProduct;
use App\Models\AppActivity;

use App\Models\SubscriptionPackage;
use App\Models\WholesellerBillcreate;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Models\CentralLibrary;
use Illuminate\Support\Facades\Auth;

use App\Models\SubCategory;
use App\Models\PackageOrder;
use App\Models\PackageTransection;
use App\Models\TemplateType;
use App\Models\SubUnit;

use Illuminate\Support\Str; 
use App;
use Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

use App\Exports\BillExport;
use Excel;

class WarehouseApiController extends Controller
{
    public function stockTransfer(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'stock_transfer_data' => 'required|array',
                'stock_transfer_data.*.product_id' => 'required|exists:products,id|numeric',
                'stock_transfer_data.*.staff_id' => 'required|exists:users,id|numeric',
                'stock_transfer_data.*.assign_stock' => 'required',
            ];
             
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                
                foreach($request->stock_transfer_data as $stock_transfer)
                {
                    $staffData = User::where('id',$stock_transfer['staff_id'])->first();
                    
                    $product = Product::where('id',$stock_transfer['product_id'])->first();
                    $totalproductStock = $product->stock*$product->sub_quantity+$product->sub_stock;
                    $totalAsignStock = $stock_transfer['assign_stock']*$product->sub_quantity+$stock_transfer['assign_sub_stock'];
                    
                    $availableStock = $totalproductStock-($totalAsignStock);
                    $openpack = $availableStock % $product->sub_quantity;

                    // print_r($product->stock);  echo"====="; print_r($product->sub_stock);  echo"=====";  print_r($totalproductStock); echo"====="; print_r($totalAsignStock);  echo"====="; print_r($availableStock); echo"====="; print_r($openpack); die;

                    //boxAvailable
                    $boxval = $availableStock -  $openpack;
                    $boxaav = $boxval / $product->sub_quantity;

                    // $sum = int($totalAsignStock); // type casting int to string
                    // print_r($boxaav); echo "========="; print_r($openpack); die;
                   
                    //  die;

                    $stockAssign = new StockTransfer();
                    $stockAssign->product_id = $stock_transfer['product_id'];
                    $stockAssign->staff_id = $stock_transfer['staff_id'];
                    $stockAssign->assign_stock = $stock_transfer['assign_stock'];
                    $stockAssign->assign_sub_stock = $stock_transfer['assign_sub_stock'];
                    $stockAssign->save();

                    $productbyUser = Product::where('id', $stock_transfer['product_id'])->whereNotNull('unit')->first();
                   
                    if ($productbyUser) {
                        if ((int)$productbyUser->stock > 0) {
                            $productbyUser->stock = $boxaav;
                            $productbyUser->sub_stock = $openpack;
                            $productbyUser->save();
                        }
                    }else{
                        $productbyUser = ProductVariation::where('product_id', $stock_transfer['product_id'])->where('unit',$stock_transfer['unit'])->first();
                        if ((int)$product->stock > 0) {
                            $productbyUser->stock = $boxaav;
                            $productbyUser->sub_stock = $openpack;
                            $productbyUser->save();
                        }
                    }

                    $activity = AppActivity::create([
                        'action'  => 'Transfer Stock',
                        'message' => Auth::user()->name.' transferred Stock to '.$staffData->name.'',
                    ]);
                    $activity->save();
                }

                DB::commit();
                $response = ['success' => true, 'message' => 'Stock Transfer successfully'];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getSubUnit(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'unit_id' => 'required|exists:units,id',
            ];    
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $subUnits = SubUnit::where('unit_id',$request->unit_id)->get();
                $response = ['success' => true, 'message' => 'Sub Unit List', 'data' => $subUnits];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addSubUnit(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'unit_id' => 'required|exists:units,id|numeric',
                'name' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $subunit = SubUnit::create([
                    'unit_id'       => $request->unit_id,
                    'name'          => $request->name,
                ]);
                DB::commit();
                $response = ['success' => true, 'message' => 'Unit added successfully' , 'data' => $subunit];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }


    public function getProductArray(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_id' => 'required|exists:products,id|array',
            ];    
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $products = Product::whereIn('id',$request->product_id)->get();
                $response = ['success' => true, 'message' => 'Product List', 'data' => $products];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getStaffStock(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'staff_id' => 'required|exists:users,id',
            ];    
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $staffStock = StockTransfer::with('staffProduct')->where('staff_id',$request->staff_id)->get();
                $response = ['success' => true, 'message' => 'Staff Stock List', 'data' => $staffStock];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function stockRefund(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'stock_refund_data' => 'required|array',
                'stock_refund_data.*.stock_transfer_id' => 'required|exists:stock_transfers,id|numeric',
                'stock_refund_data.*.refund_stock' => 'required',
            ];    
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                foreach($request->stock_refund_data as $stock_refund_data)
                {
                    $getStock = StockTransfer::where('id',$stock_refund_data['stock_transfer_id'])->first();
                    if($getStock)
                    {
                        $staffData = User::where('id',$getStock->staff_id)->first();

                        $product = Product::where('id',$getStock->product_id)->first();
                        $totalproductStock = $product->stock*$product->sub_quantity+$product->sub_stock;
                        $totalAsignStock = $getStock->assign_stock*$product->sub_quantity+$getStock->assign_sub_stock;
                        $refundStock = $stock_refund_data['refund_stock']*$product->sub_quantity+$stock_refund_data['refund_sub_stock'];

                        //Refund stock add to product data stock
                        $availableStock = $totalproductStock+($refundStock);
                        $openpack = $availableStock % $product->sub_quantity;
                        $boxval = $availableStock -  $openpack;
                        $boxaav = $boxval / $product->sub_quantity;
                        $product->stock = $boxaav;
                        $product->sub_stock = $openpack;
                        $product->save();

                        //Refund stock subtract to stock tranfer
                        $availableRefundStock = $totalAsignStock-($refundStock);
                        $openpackrefund = $availableRefundStock % $product->sub_quantity;
                        $boxvalrefund = $availableRefundStock -  $openpackrefund;
                        $boxaavrefund = $boxvalrefund / $product->sub_quantity;
                        $getStock->assign_stock = $boxaavrefund;
                        $getStock->assign_sub_stock = $openpackrefund;
                        $getStock->save();
                        
                        // print_r($totalAsignStock); echo"==="; print_r($refundStock); echo"==="; print_r($availableRefundStock); echo"==="; print_r($openpackrefund); echo"==="; print_r($boxaavrefund); echo"===";  die;
                        
                        $activity = AppActivity::create([
                            'action'  => 'Adjust Stock',
                            'message' => $staffData->name. ' transferred Stock to '.Auth::user()->name,
                        ]);
                        $activity->save();
                    }
                    // $getStock->destroy($getStock->id);
                }
                DB::commit();
                $response = ['success' => true, 'message' => 'Stock Refund Successfully'];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function staffProductCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'staff_id' => 'required|exists:users,id|numeric',
            ];
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {  
                $checkStaffProduct = StockTransfer::with('staffProduct')->where('staff_id',$request->staff_id)->get()->unique('product_id')->pluck('product_id');

                $products = Product::whereIn('id',$checkStaffProduct)->where('status', '1')->get()->unique('category')->pluck('category')->toarray();
                $category = Category::whereIn('id',$products)->orderBy('created_at','ASC')->get();
                $response = ['success' => true, 'message' => 'Store product category List', 'Category' => $category];            
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function staffCategoryProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'staff_id' => 'required|exists:users,id|numeric',
                'category_id' => 'required|exists:categories,id|numeric',
            ];
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {  

                $checkStaffProduct = StockTransfer::with('staffProduct')
                ->whereHas('staffProduct', function ($query) use ($request) {
                    $query->where('category', $request->category_id);
                })
                ->where('staff_id', $request->staff_id)
                ->get();

                // print_R($checkStaffProduct->toarray()); die;
                $response = ['success' => true, 'message' => 'Category Product List', 'Product' => $checkStaffProduct];            
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function StaffStockArray(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'stock_transfer_id' => 'required|exists:stock_transfers,id|array',
            ];    
    
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                
                // $staffStock = StockTransfer::with('staffProduct')->whereIn('id',$request->stock_transfer_id)->get();

                $staffStock = StockTransfer::with(['staffProduct' => function ($query) {
                    // Optionally limit the columns returned in staffProduct
                    $query->select('id', 'product_name','unit','sub_unit'); 
                }])
                ->whereHas('staffProduct', function ($query) {
                    // Add any filtering conditions for staffProduct here
                    $query->whereNotNull('product_name');
                })
                ->whereIn('id', $request->stock_transfer_id) // Filter by stock transfer IDs
                ->get(); // Get the results
                $response = ['success' => true, 'message' => 'Staff Stock List', 'data' => $staffStock];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
}
