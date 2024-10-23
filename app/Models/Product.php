<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable =
    [
        'user_id',
        'store_id',
        'module_id',
        'category',
        'subCategory_id',
        'barcode',
        'barcode_two',
        'product_image',
        'product_name',
        'attributes',
        'unit',
        'sub_unit',
        'variant_combination',
        'package_weight',
        'package_size',
        'quantity',
        'sub_quantity',
        'mrp',
        'sub_mrp',
        'retail_price',
        'sub_retail_price',
        'wholesale_price',
        'members_price',
        'purchase_price',
        'sub_purchase_price',
        'stock',
        'sub_stock',
        'low_stock',
        'gst',
        'hsn',
        'cess',
        'expiry',
        'tags',
        'brand',
        'color',
        'status',
        'food_type',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function productCategory()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function productSubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subCategory_id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function cart()
    {
        return $this->hasOne(AddtoCart::class, 'product_id');  // Adjust foreign key if necessary
    }
}
