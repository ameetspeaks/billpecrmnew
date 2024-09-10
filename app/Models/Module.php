<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = [
        'user_id',
        'store_type_id',
        'name',
        'status',
        'online',
    ];

    public function store_type()
    {
        return $this->belongsTo(StoreType::class, 'store_type_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'module_id');
    }

}
