<?php


Route::get('migrate', function () {
    Artisan::call('migrate');
    return 'migrated';
});

Route::get('notification-history', function () {
    return \App\Models\NotificationHistory::latest()->limit(10)->get();
});

Route::get('pusher-test', function () {
    event(new \App\Events\AdminNewOrder('test'));
    return 'pusher test';
});

Route::get('pusher-output', function () {
    return view('test');
});
