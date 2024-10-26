<?php


Route::get('migrate', function () {
    Artisan::call('migrate');
    return 'migrated';
});

Route::get('notification-history', function () {
    return \App\Models\NotificationHistory::latest()->limit(10)->get();
});
