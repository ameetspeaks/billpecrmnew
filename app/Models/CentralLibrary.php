<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentralLibrary extends Model
{
    use HasFactory;

    protected $table = 'central_libraries';

    protected $fillable =
    [
        'user_id',
        'product_id',
        'store_id',
        'module_id',
        'category',
        'subCategory_id',
        'barcode',
        'barcode_two',
        'product_image',
        'product_name',
        'unit',
        'package_weight',
        'package_size',
        'quantity',
        'mrp',
        'retail_price',
        'wholesale_price',
        'members_price',
        'purchase_price',
        'stock',
        'low_stock',
        'gst',
        'hsn',
        'cess',
        'expiry',
        'tags',
        'brand',
        'color',
        'status',
        'food_type'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function productCategory()
    {
        return $this->belongsTo(Category::class, 'category');
    }
}

