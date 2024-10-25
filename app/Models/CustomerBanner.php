<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBanner extends Model
{
    use HasFactory;

    protected $table = 'customer_banners';

    protected $fillable = [
//        'module_id',
//        'category_id',
        'name',
        'image',
        'status',
        'position',
//        'zone',
        'store_id',
    ];

//    public function module()
//    {
//        return $this->belongsTo(Module::class, 'module_id');
//    }
//
//    public function category()
//    {
//        return $this->belongsTo(Category::class, 'category_id');
//    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
