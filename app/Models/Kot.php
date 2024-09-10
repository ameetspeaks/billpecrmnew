<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kot extends Model
{
    use HasFactory;

    protected $table = 'kots';

    protected $fillable = [
        'store_id',
        'refresh_token',
        'order_type',
        'min_delivery_order_amount',
        'min_delivery_fees',
        'min_packaging_order_amount',
        'min_packaging_fees',
    ];
}
