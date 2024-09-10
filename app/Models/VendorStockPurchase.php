<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorStockPurchase extends Model
{
    use HasFactory;

    protected $table = 'vendor_stock_purchases';

    protected $fillable = [
        'store_id',
        'bill_number',
        'vendor_name',
        'vendor_number',
        'bill_amount',
        'paid_amount',
        'payment_mode',
        'credit_amount',
        'due_date',
        'bill_image',
        'gst_number',
        'gst_amount',
        'notes',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->with('user');
    }
}
