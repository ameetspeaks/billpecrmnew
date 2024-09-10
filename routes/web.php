<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\PricingController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BlogController;

use App\Http\Controllers\WebSocketController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->group(base_path('routes/admin.php'));
Route::prefix('store')->group(base_path('routes/store.php'));
Route::get('invoice/{store_id}/{combined_id}',[InvoiceController::Class, 'invoice']);
Route::get('subscriptionInvoice/{combined_id}',[InvoiceController::Class, 'subscriptionInvoice']);
Route::get('invoiceWholesale/{store_id}/{combined_id}',[InvoiceController::Class, 'invoiceWholesale']);

Route::post('sharebilltowhatsapp',[InvoiceController::Class, 'sharebilltowhatsapp'])->name('sharebilltowhatsapp');

Route::get('checkInvoice/{store_id}/{combined_id}',[InvoiceController::Class, 'checkInvoice'])->name('checkInvoice');


Route::get('/',[HomeController::Class, 'index'])->name('index');
Route::post('/', [HomeController::class, 'checkoutdata'])->name('checkoutpackage');

Route::get('about', function () {
        return view('billpeapp.about');
})->name('about');

Route::get('feature', function () {
        return view('billpeapp.feature');
})->name('feature');

Route::get('checkout-1',[CheckoutController::Class, 'checkout'])->name('checkout-1');
Route::post('checkout-1', [CheckoutController::class, 'checkoutOrder'])->name('checkoutOrder');
Route::post('getCoupanByCode', [CheckoutController::class, 'getCoupanByCode'])->name('getCoupanByCode');
Route::any('cashfree/payments/success', [CheckoutController::class, 'success'])->name('success');

Route::get('pricing',[PricingController::Class, 'index'])->name('pricing');
Route::post('pricing', [PricingController::class, 'checkoutdata'])->name('checkoutpackage');


Route::get('contact', function () {
        return view('billpeapp.contact');
})->name('contact');

Route::get('team', function () {
        return view('billpeapp.team');
})->name('team');

Route::get('testimonials', function () {
        return view('billpeapp.testimonials');
})->name('testimonials');

Route::get('blogs',[BlogController::Class, 'index'])->name('blogs');

Route::get('faq', function () {
        return view('billpeapp.faq');
})->name('faq');

Route::get('404', function () {
        return view('billpeapp.404');
})->name('404');

Route::get('coming', function () {
        return view('billpeapp.coming');
})->name('coming');

Route::get('terms&condition', function () {
        return view('billpeapp.terms&condition');
})->name('terms&condition');

Route::get('privacypolicy', function () {
        return view('billpeapp.privacypolicy');
})->name('privacypolicy');

Route::get('refundandreturns', function () {
        return view('billpeapp.refundandreturns');
})->name('refundandreturns');

Route::get('Subscription-Expire',[CheckoutController::Class, 'subscriptionExpire'])->name('subscriptionExpire');

Route::get('/fblogin', function () {
        return view('fblogin');
    })->name('fblogin');

Route::post('eventfire', [WebSocketController::class, 'eventfire'])->name('eventfire');

// Route::get('eventfire', function () {
//         print_r(); die;
//         event(new App\Events\webappchat());
//         dd('fired');
// })->name('eventfire');
Route::get('UserSendChat',[WebSocketController::Class, 'UserSendChat'])->name('UserSendChat');



