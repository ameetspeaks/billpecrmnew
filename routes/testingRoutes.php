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

Route::get('handlingCharge', function () {


    $query = App\Models\Store::with('customer_orders')->where('id','<=', 833)->where('id','>', 800);

    $data = $query->get()->map(function ($item) {
        $handlingCharge = 0;
        $otherFees = 0;
        foreach ($item->customer_orders as $order) {
            $anyOtherFee = json_decode($order->any_other_fee);
            foreach ($anyOtherFee as $fee) {
                if (isset($fee->id, $fee->amount)) {
                    if ($fee->id == 1) {
                        $handlingCharge += floatval($fee->amount);
                    } else {
                        $otherFees += floatval($fee->amount);
                    }
                }
            }
        }

        // Attach the calculated totals to the store item
        $item->handlingChargeTotal = $handlingCharge;
        $item->otherFeesTotal = $otherFees;

        return $item;
    });

    dd($data);


});

Route::get('otp', function () {
    $data = \App\Models\Otp::latest()->limit(10)->get();
    return response()->json($data);
});
