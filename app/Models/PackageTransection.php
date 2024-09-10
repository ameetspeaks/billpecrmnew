<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTransection extends Model
{
    use HasFactory;

    protected $table = 'package_transections';

    protected $fillable = [
        'productOrder_id',
        'store_id',
        'cf_payment_id',
        'order_amount',
        'order_id',
        'payment_amount',
        'payment_completion_time',
        'payment_currency',
        'payment_group',
        'payment_status',
        'payment_time'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
