<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageExtentDate extends Model
{
    use HasFactory;

    protected $table = 'package_extent_dates';

    protected $fillable = [
        'store_id',
        'package_id',
        'expiry_date',
        'extend_day',
    ];
}
