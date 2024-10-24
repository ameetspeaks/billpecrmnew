<?php


Route::get('migrate', function () {
    Artisan::call('migrate');
    return 'migrated';
});

