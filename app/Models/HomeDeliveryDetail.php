<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeDeliveryDetail extends Model
{
    use HasFactory;

    protected $table = 'home_delivery_details';

    protected $fillable = [
        'store_id',
        'delivery_status',
        'range',
        'radius',
        'latitude',
        'longitude',
        'minimum_order_amount',
        'delivery_charge',
        'packaging_charge',
        'processing_time',
        'delivery_mode',
    ];
}
