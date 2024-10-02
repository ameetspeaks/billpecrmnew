<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantOrderStatus extends Model
{
    use HasFactory;

    protected $table = 'merchant_order_statuses';

    protected $fillable= [
        'name',
        'created_at',
        'updated_at'
    ];
}
