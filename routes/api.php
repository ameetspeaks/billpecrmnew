<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiUpdateController;
use App\Http\Controllers\WarehouseApiController;
use App\Http\Controllers\CustomerAppController;
use App\Http\Controllers\ApiDeliveryPartnerController;
use App\Http\Controllers\ApiMerchantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/send-OTP', [ApiController::class, 'sendOTP']);
Route::post('/verify-OTP', [ApiController::class, 'verifyOTP']);
Route::post('/add-User', [ApiController::class, 'addUser']);
Route::get('/getRoles', [ApiController::class, 'getRoles']);
Route::get('/getModule', [ApiController::class, 'getModule']);
Route::get('/get-StoreType', [ApiController::class, 'getStoreType']);
Route::post('/force-update', [ApiController::class, 'forceUpdate']);

//verify Otpless
Route::post('/verify-token', [ApiController::class, 'verifyToken']);

// Delivery Partner
Route::post('/verify-delivery-partner-OTP', [ApiController::class, 'verifyDPOTP']);

Route::group(
    [
        'middleware' => ['auth:api', 'throttle:100,1'],
    ],function(){
    
    Route::get('/logout', [ApiController::class, 'logout']);
    Route::get('/profile', [ApiController::class, 'profile']);

    Route::get('/getPackage', [ApiController::class, 'getPackage']);

    //Attribues
        Route::get('/getAttribute', [ApiController::class, 'getAttribute']);
        Route::post('/searchByAttributeName', [ApiController::class, 'searchByAttributeName']);
        Route::post('/add-Attribute', [ApiController::class, 'addAttribute']);
    //

    //Unit
        Route::get('/getUnit', [ApiController::class, 'getUnit']);
        Route::post('/add-Unit', [ApiController::class, 'addUnit']);
    //

    Route::post('/update-StoreImage', [ApiController::class, 'updateStoreImage']);

    Route::post('/getCategory', [ApiController::class, 'getCategory']);
    Route::post('/add-Category', [ApiController::class, 'addCategory']);
    Route::post('/add-SubCategory', [ApiController::class, 'addSubCategory']);
    Route::post('/getSubCategory', [ApiController::class, 'getSubCategory']);
    Route::post('/add-Product', [ApiController::class, 'addProduct']);
    Route::post('/update-Product', [ApiController::class, 'updateProduct']);
    Route::post('/delete-Product', [ApiController::class, 'deleteProduct']);
    Route::post('/getProduct', [ApiController::class, 'getProduct']);
    Route::post('/searchByBarcodeProduct', [ApiController::class, 'searchByBarcodeProduct']);
    Route::post('/searchByProductName', [ApiController::class, 'searchByProductName']);
    Route::post('/get-categoryProduct', [ApiController::class, 'categoryProduct']);
    Route::post('/get-storeProductCategory', [ApiController::class, 'storeProductCategory']);

    Route::post('/add-Customer', [ApiController::class, 'addCustomer']);
    Route::post('/create-Bill', [ApiController::class, 'createBill']);

    //language  test
        Route::get('testing-language/{language?}', [ApiController::class, 'testLanguage']);
        Route::post('testing-add/{language?}', [ApiController::class, 'addTestingData']);
    //

    Route::post('/sendBillToWhatsapp', [ApiController::class, 'sendBillToWhatsapp']);
    Route::post('/update-package', [ApiController::class, 'updatePackage']);
    Route::post('/create-Wholesale-Bill', [ApiController::class, 'createWholesaleBill']);
    Route::post('/report', [ApiController::class, 'report']);
    Route::post('/home-dashboard', [ApiController::class, 'homeDashboard']);
    
    //store
    Route::post('/getStore', [ApiController::class, 'getStore']);
    Route::post('/add-store', [ApiController::class, 'addStore']);
    Route::post('/edit-store', [ApiController::class, 'editStore']);
    Route::post('/Change-StoreStatus', [ApiController::class, 'changeStoreStatus']);
    
    //Delivery Partner
    Route::post('/getMyDeliveryPartners', [ApiController::class, 'getMyDeliveryPartners']);
    Route::post('/assignOrderToDeliveryBoy', [ApiController::class, 'assignOrderToDeliveryBoy']);
    Route::post('/orderStatusChange', [ApiController::class, 'orderStatusChange']);
    Route::post('/getShiftTimings', [ApiController::class, 'getShiftTimings']);
    Route::post('/saveDeliveryPartnersDetail', [ApiController::class, 'saveDeliveryPartnersDetail']);
    Route::post('/currentWorkStatusUpdate', [ApiController::class, 'currentWorkStatusUpdate']);


    //customers
    Route::post('/getCustomer', [ApiController::class, 'getCustomer']);
    Route::post('/getAllCustomers', [ApiController::class, 'getAllCustomers']);
    Route::post('/getCustomerBill', [ApiController::class, 'getCustomerBill']);
    Route::post('/delete-CustomerBill', [ApiController::class, 'deletCustomerBill']);
    Route::post('/update-CustomerDueAmount', [ApiController::class, 'updatecustomerDueAmount']);
    Route::post('/filte-CustomerBill', [ApiController::class, 'filterCustomerBill']);


    //vendor-wholeseller
    Route::post('/getVendor', [ApiController::class, 'getVendor']);
    Route::post('/add-VendorStockPurchase', [ApiController::class, 'addVendorStockPurchase']);
    Route::post('/stock-purchaseHistory', [ApiController::class, 'stockPurchaseHistory']);
    Route::post('/update-venderDueAmount', [ApiController::class, 'updatevenderDueAmount']);
    Route::post('/delete-VendorStockPurchase', [ApiController::class, 'deleteVendorStockPurchase']);
    Route::post('/getAllVendors', [ApiController::class, 'getAllVendors']);
    
    //coupan
    Route::get('/getCoupan', [ApiController::class, 'getCoupan']);
    Route::post('/verifyCoupan', [ApiController::class, 'verifyCoupan']);

    //template 
    Route::get('/getTemplateCategory', [ApiController::class, 'getTemplateCategory']);
    Route::get('/get-TemplateType', [ApiController::class, 'getTemplateType']);
    Route::post('/MarketingTemplate', [ApiController::class, 'MarketingTemplate']);
    Route::post('/OfferTemplate', [ApiController::class, 'OfferTemplate']);

    //subscription order
    Route::post('/subscriptionOrder', [ApiController::class, 'subscriptionOrder']);

    //Expense
    Route::post('/get-ExpenseCategory', [ApiController::class, 'getExpenseCategory']);
    Route::post('/add-ExpenseCategory', [ApiController::class, 'addExpenseCategory']);
    Route::post('/add-Expense', [ApiController::class, 'addExpense']);
    Route::post('/get-Expense', [ApiController::class, 'getExpense']);
    Route::post('/delete-Expense', [ApiController::class, 'deleteExpense']);

    //staff
    Route::post('/get-Staff', [ApiController::class, 'getstaff']);
    Route::post('/delete-User', [ApiController::class, 'deleteUser']);
    Route::post('/staff-Status', [ApiController::class, 'staffStatus']);

    //Send push notification
    Route::post('/Send-Notification', [ApiController::class, 'sendNotification']);
    Route::post('/Get-Notification', [ApiController::class, 'getNotification']);
    Route::post('/Delete-Notification', [ApiController::class, 'deleteNotification']);

    //User-Detail-Add
    Route::post('/Upi-Bank-Verification', [ApiController::class, 'upiBankVerify']);
    Route::post('/Social-Media', [ApiController::class, 'socialMedia']);

    //kots
    Route::post('/add-KotSetting', [ApiController::class, 'addKotSetting']);

    //Excel and PDF
    Route::post('/Generate-Pdf', [ApiController::class, 'generatepdf']);
    Route::post('/Generate-BillExcel', [ApiController::class, 'generateBillExcel']);

    //Tutorial
    Route::post('/get-Tutorial', [ApiController::class, 'getTutorial']);

    //ApiUpdateController
    Route::post('/add-ProductByVariant', [ApiUpdateController::class, 'addProductByVariant']);
    Route::post('/edit-ProductByVariant', [ApiUpdateController::class, 'editProductByVariant']);
    Route::post('/get-UnitByModule', [ApiUpdateController::class, 'getUnitByModule']);
    

    //Warehouse Apis
    Route::post('/stock-transfer', [WarehouseApiController::class, 'stockTransfer']);
    Route::post('/get-SubUnit', [WarehouseApiController::class, 'getSubUnit']);
    Route::post('/get-ProductArray', [WarehouseApiController::class, 'getProductArray']);
    Route::post('/get-StaffStock', [WarehouseApiController::class, 'getStaffStock']);
    Route::post('/stock-refund', [WarehouseApiController::class, 'stockRefund']);
    Route::post('/get-staffProductCategory', [WarehouseApiController::class, 'staffProductCategory']);
    Route::post('/get-staffCategoryProduct', [WarehouseApiController::class, 'staffCategoryProduct']);
    Route::post('/get-StaffStockArray', [WarehouseApiController::class, 'StaffStockArray']);
    Route::post('/add-SubUnit', [WarehouseApiController::class, 'addSubUnit']);

    Route::post('/Home-Delivery-Detail', [ApiController::class, 'homedeliveryDetail']);
    Route::post('/Upi-Verification', [ApiController::class, 'upiVerify']);
    Route::post('/GST-Verification', [ApiController::class, 'gstVerify']);

    //Customer Support App
        Route::post('/add-MultipleAddress', [CustomerAppController::class, 'addMultipleAddress']);
        Route::post('/customer-HomeDashboard', [CustomerAppController::class, 'customerHomeDashboard']);
        Route::post('/get-MultipleAddress', [CustomerAppController::class, 'getMultipleAddress']);
        Route::post('/update-MultipleAddress', [CustomerAppController::class, 'updateMultipleAddress']);
        Route::post('/delete-Address', [CustomerAppController::class, 'deleteAddress']);

        Route::post('/update-Profile', [CustomerAppController::class, 'updateProfile']);
        Route::post('/customer-Order', [CustomerAppController::class, 'customerOrder']);

        Route::post('/food-StoreList', [CustomerAppController::class, 'foodStoreList']);
        Route::post('/get-CategoryStoreList', [CustomerAppController::class, 'getCategoryStoreList']);
        Route::post('/get-storeDetail', [CustomerAppController::class, 'getstoreDetail']);
        
        Route::post('/SearchStoreBy-productName-StoreName', [CustomerAppController::class, 'searchStorebyproductandStore']);
        Route::get('/Get-Filters', [CustomerAppController::class, 'getFilters']);
        Route::post('/filter-Store', [CustomerAppController::class, 'filterStore']);
        Route::post('/Add-To-Cart', [CustomerAppController::class, 'addtocart']);
        Route::post('/Get-AddToCart', [CustomerAppController::class, 'getAddToCart']);
        Route::post('/Delete-AddToCart', [CustomerAppController::class, 'deleteAddToCart']);

        Route::post('/Checkout', [CustomerAppController::class, 'checkout']);
        Route::get('/Get-CustomerCoupan', [CustomerAppController::class, 'getCustomerCoupan']);
        Route::post('/Verify-CustomerCoupan', [CustomerAppController::class, 'verifyCustomerCoupan']);
        Route::post('/Order-List', [CustomerAppController::class, 'orderList']);
        Route::get('/Get-OrderStatus', [CustomerAppController::class, 'getOrderStatus']);
    //Close Customer Support

    Route::post('/Get-HomeDelivery', [ApiController::class, 'getHomeDelivery']);
    Route::post('/Store-OnlineStatus', [ApiController::class, 'storeOnlineStatus']);
    Route::post('/Merchant-OrderHistory', [ApiController::class, 'MerchantOrderHistory']);
    Route::post('/Withrawal-Amount', [ApiController::class, 'WithrawalAmount']);
    

    // Delivery Partner Merchant
    Route::post('/get-my-delivery-boys', [ApiController::class, 'getMyDeliveryBoys']);

    // Delivery Partner App
    Route::group(['prefix' => 'delivery-partner', 'as' => 'deliveryPartner.'], function () {
        Route::post('get-home-detail', [ApiDeliveryPartnerController::class, 'getHomePageDetail']);
        Route::post('get-profile-detail', [ApiDeliveryPartnerController::class, 'getProfileDetail']);
        Route::post('save-lat-long', [ApiDeliveryPartnerController::class, 'saveLatLong']);
        Route::post('order-confirm-cancel', [ApiDeliveryPartnerController::class, 'orderConfirmCancel']);
        Route::post('current-order-detail', [ApiDeliveryPartnerController::class, 'currentOrderDetail']);
        Route::post('/order-detail-by-date', [ApiDeliveryPartnerController::class, 'orderDetailByDate']);
        Route::post('/order-status-change', [ApiDeliveryPartnerController::class, 'orderStatusChange']);
    });
    Route::group(['prefix' => 'merchant', 'as' => 'merchant.'], function () {
        Route::post('/order-status-change', [ApiMerchantController::class, 'orderStatusChange']);
    });
});

Route::post('/get-ModuleByStoreType', [ApiUpdateController::class, 'getModuleByStoreType']);
Route::post('/verify-ReferralCode', [ApiController::class, 'verifyReferralCode']);

Route::get('/get-CFID', [ApiController::class, 'CFID']);
Route::post('/testApi', [ApiController::class, 'testApi']);

//customer
Route::post('/verify-tokenWithRole', [CustomerAppController::class, 'verifyTokenWithRole']);
Route::post('/add-customerAddress', [CustomerAppController::class, 'addCustomerAddress']);
Route::post('/send-OTPCustomer', [CustomerAppController::class, 'sendOTP']);
Route::post('/verify-OTPCustomer', [CustomerAppController::class, 'verifyOTP']);
//close customer

Route::post('/get-all-d-p-order-status', [ApiController::class, 'getAllDPOrderStatus']);
Route::post('/get-all-merchant-order-status', [ApiController::class, 'getAllMerchantOrderStatus']);