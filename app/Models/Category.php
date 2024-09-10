<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;
use Session;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'module_id',
        'image',
        'status',
        'featured',
    ];


    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'category');
    }

    public function productsByStore()
    {
        return $this->hasMany(Product::class,'category')->where('store_id',Session::get('store_id'));
    }

}
