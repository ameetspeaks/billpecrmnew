<?php

namespace App\Http\Controllers;

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
use App\Models\BillDetail;
use App\Models\WholesellerBillcreate;

use App\Models\PackageOrder;
use App\Models\PackageTransection;

class InvoiceController extends Controller
{
    public function invoice($store_id, $combined_id)
    {
        $billHistory = BillDetail::with('store','token')->where('store_id',$store_id)->where('combined_id', $combined_id)->first();

        if (!$billHistory) {
            return response()->view('not_found', [], 404);
        }
        return view('invoice',compact('billHistory'));
    }

    public function invoiceWholesale($store_id, $combined_id)
    {
        $wholesalebillHistory = WholesellerBillcreate::with('store')->where('store_id',$store_id)->where('combined_id', $combined_id)->first();
        if (!$wholesalebillHistory) {
            return response()->view('not_found', [], 404);
        }
        return view('invoiceWholesale',compact('wholesalebillHistory'));
    }

    public function subscriptionInvoice($combined_id)
    {
        $packageOrder = PackageOrder::with('store','packagetransection')->where('combined_id',$combined_id)->first();
        // print_r($packageOrder->toarray()); die;
        return view('subscriptionInvoice', compact('packageOrder'));
    }

    public function sharebilltowhatsapp(Request $request)
    {
        try {
            $rules = [
                'customer_name' => 'required|string',
                'customer_number' => 'required|numeric|digits:10',
                'bill_id' =>  'required|exists:bill_details,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            } else {

                $checkBill = BillDetail::with('store')->where('id',$request->bill_id)->first();
                $invoiceUrl = url('invoice/'.$checkBill->store_id. '/' . $checkBill->combined_id);

                // $whatsappSendURL = 'https://web.whatsapp.com/send?phone=918077013392&text=https://admin.billpe.co.in/invoice/71/3895qVmm3ecI1710308178%0AHi!%20amit%0AInvoice%20Amount:%20%E2%82%B9280%0Amystore%0A7894561234%0AThanks%20you!%20Visit%20Again%0APowered%20by%20BillPe';

                $whatsappSendURL = 'https://web.whatsapp.com/send?phone=91'.$request->customer_number.'&text='.$invoiceUrl.'%0AHi!%20'.str_replace(' ', '%20', $request->name).'%0AInvoice%20Amount:%20'.$checkBill->total_amount.'%0A'.str_replace(' ', '%20', $checkBill->store->shop_name).'%0A'.$checkBill->store->user->whatsapp_no.'%0AThanks%20you!%20Visit%20Again%0APowered%20by%20BillPe';
                // print_r($whatsappSendURL); die;

                return redirect()->away($whatsappSendURL);
            }

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function checkInvoice($store_id, $combined_id)
    {
        $billHistory = BillDetail::with('store','token')->where('store_id',$store_id)->where('combined_id', $combined_id)->first();

        if (!$billHistory) {
            return response()->view('not_found', [], 404);
        }
        return view('checkInvoice', compact('billHistory'));
    }
}
