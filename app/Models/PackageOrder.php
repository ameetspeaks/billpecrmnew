<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    use HasFactory;

    protected $table = 'package_orders';

    protected $fillable = [

        'store_id',
        'user_id',
        'product_details',
        'shipping_name',
        'shipping_address',
        'shipping_latitude',
        'shipping_longitude',
        'shipping_city',
        'shipping_code',
        'shipping_state',
        'copanCode',
        'coupanAmount',
        'TotalAmount',
        'order_comment',
        'unique_id',
        'combined_id',
        'order_number',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id')->with('user');;
    }

    public function packagetransection()
    {
        return $this->belongsTo(PackageTransection::class, 'id', 'productOrder_id');
    }
}
