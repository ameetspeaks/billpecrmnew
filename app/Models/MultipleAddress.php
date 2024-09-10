<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleAddress extends Model
{
    use HasFactory;

    protected $table = 'multiple_addresses';

    protected $fillable = [
        'user_id',
        'address',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'label',
    ];
}
