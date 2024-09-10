<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    use HasFactory;

    protected $table = 'warehouse_products';

    protected $fillable =
    [
        'user_id',
        'store_id',
        'module_id',
        'category',
        'subCategory_id',
        'barcode',
        'product_image',
        'product_name',
        'primary_unit',
        'secondary_unit',
        'primary_qtn',
        'secondary_qtn',
        'mrp_box',
        'mrp_pc',
        'stock_box',
        'stock_pc',
        'low_stock',
        'gst',
        'hsn',
        'cess',
        'expiry',
        'tags',
        'brand',
        'color',
        'status',
    ];
}
