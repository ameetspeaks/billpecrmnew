<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\DashboardController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\AuthController;
use App\Http\Controllers\Store\BillController;
use App\Http\Controllers\Store\UserController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\Store\QRCodeController;


Route::group(['as' => 'store.'], function () {

    Route::get('login', [AuthController::class, 'loginOtpless'])->name('login');
    Route::post('login', [AuthController::class, 'verifyotpless'])->name('login.post');

    Route::get('register-store', [AuthController::class, 'registerStore'])->name('registerStore');
    Route::post('AddNewStore', [AuthController::class, 'AddNewStore'])->name('AddNewStore');

    // Route::post('verify-otpLess', [AuthController::class, 'verifyotpless'])->name('login.verifyotpless');

    // Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('send-otp', [AuthController::class, 'sendOtp'])->name('login.sendotp');
    Route::post('send-msg91-otp', [AuthController::class, 'sendMsg91Otp'])->name('login.sendotpnew');
    Route::post('verify-otp', [AuthController::class, 'verifyotp'])->name('login.verifyotp');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    
    //Dashboard
    Route::get('directStoreLogin/{store_id}/{user_id}',[DashboardController::Class, 'directStoreLogin']);
    Route::get('changeStore/{id}',[DashboardController::Class, 'changeStore'])->name('changeStore')->middleware('userLogin');

    //product
    Route::get('product-list', [ProductController::class, 'index'])->name('product-list')->middleware('userLogin');
    Route::get('add-product', [ProductController::class, 'add'])->name('add-product')->middleware('userLogin');
    Route::get('getCategory/{id}', [ProductController::class, 'getCategory'])->name('product.getCategory')->middleware('userLogin');
    Route::get('getsubCategory/{id}', [ProductController::class, 'getsubCategory'])->name('product.getsubCategory')->middleware('userLogin');
    Route::get('getUnit/{id}', [ProductController::class, 'getUnit'])->name('product.getUnit')->middleware('userLogin');
    Route::post('storeProduct', [ProductController::class, 'store'])->name('product.store');
    Route::get('editProduct/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware('userLogin');
    Route::post('updateProduct', [ProductController::class, 'update'])->name('product.update');
    Route::get('getProductDatatable', [ProductController::class, 'getDatatable'])->name('product.getDatatable');
    Route::get('deleteProduct/{id}', [ProductController::class, 'delete'])->name('product.delete')->middleware('userLogin');
    Route::get('productExport', [ProductController::class, 'productExport'])->name('product.productExport');
    Route::post('uploadProductExcel', [ProductController::class, 'uploadProductExcel'])->name('product.uploadProductExcel');
    Route::get('expired-products', [ProductController::class, 'exportProduct'])->name('expired-products')->middleware('userLogin');
    Route::get('low-stocks', [ProductController::class, 'lowstocks'])->name('low-stocks')->middleware('userLogin');
    Route::post('addStock', [ProductController::class, 'addStock'])->name('product.addStock');

    //store dashboard
    Route::get('dashboard',[DashboardController::Class, 'dashboard'])->name('dashboard')->middleware('userLogin');

    Route::get('/sales-dashboard', function () {
        return view('store.storeAdmin.sales-dashboard');
    })->name('sales-dashboard');

    
    Route::get('/barcode', function () {
        return view('store.storeAdmin.barcode');
    })->name('barcode');

    Route::get('/qrcode', function () {
        return view('store.storeAdmin.qrcode');
    })->name('qrcode');

    Route::get('manage-stocks', [ProductController::class, 'manageStock'])->name('manage-stocks')->middleware('userLogin');

    Route::get('/stock-adjustment', function () {                         
        return view('store.storeAdmin.stock-adjustment');
    })->name('stock-adjustment');

    Route::get('/sales-list', [BillController::class, 'salesList'])->name('sales-list')->middleware('userLogin');
    Route::get('/salesDetail/{id}', [BillController::class, 'salesDetail'])->name('salesDetail')->middleware('userLogin');
    Route::get('/invoice-report', [BillController::class, 'invoiceReport'])->name('invoice-report')->middleware('userLogin');
    
    Route::get('/sales-returns', function () {                         
        return view('store.storeAdmin.sales-returns');
    })->name('sales-returns'); 
    
    Route::get('/quotation-list', function () {                         
        return view('store.storeAdmin.quotation-list');
    })->name('quotation-list'); 

    Route::get('pos', [BillController::class, 'pos'])->name('pos')->middleware('userLogin');
    Route::post('getProductByName', [BillController::class, 'getProductByName'])->name('pos.getProductByName');
    Route::post('getProductByBarcode', [BillController::class, 'getProductByBarcode'])->name('pos.getProductByBarcode');
    Route::post('getProductByCategory', [BillController::class, 'getProductByCategory'])->name('pos.getProductByCategory');
    Route::post('quickAddProduct', [BillController::class, 'quickAddProduct'])->name('pos.quickAddProduct');
    Route::post('addCustomer', [BillController::class, 'addCustomer'])->name('pos.addCustomer');
    Route::post('createBill', [BillController::class, 'createBill'])->name('pos.createBill');


    Route::get('customers', [UserController::class, 'customers'])->name('customers')->middleware('userLogin');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
    Route::post('update', [UserController::class, 'update'])->name('user.update');
    Route::get('deleteUser/{id}', [UserController::class, 'delete'])->name('user.delete')->middleware('userLogin');

    Route::get('suppliers', [UserController::class, 'suppliers'])->name('suppliers')->middleware('userLogin');
    
    Route::get('store-list', [StoreController::class, 'storeList'])->name('store-list')->middleware('userLogin');
    Route::get('add-store', [StoreController::class, 'add'])->name('add-store')->middleware('userLogin');
    Route::post('Addstore', [StoreController::class, 'store'])->name('Addstore');
    Route::get('editStore/{id}', [StoreController::class, 'edit'])->name('editStore');
    Route::post('updateStore', [StoreController::class, 'update'])->name('update');
    Route::get('deleteStore/{id}', [StoreController::class, 'delete'])->name('delete')->middleware('userLogin');

    Route::get('staff', [UserController::class, 'staff'])->name('staff')->middleware('userLogin');
    
    Route::get('qrcode', [QRCodeController::class, 'qrcode'])->name('qrcode');
});

