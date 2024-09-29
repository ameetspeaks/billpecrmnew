<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdral extends Model
{
    use HasFactory;

    protected $table = 'withdrals';

    protected $fillable = [
        'store_id',
        'order_id',
        'transection_id',
        'amount',
        'status',
    ];

    public function store(){
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function statusvalue(){
        return $this->belongsTo(WithdralStatus::class, 'status');
    }
}
