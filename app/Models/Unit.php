<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = "units";

    protected $fillable = [

        'name',
        'module_id',
        'attribute_id',
    ];

    public function module()
    {
            return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
