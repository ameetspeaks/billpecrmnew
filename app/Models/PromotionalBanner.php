<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionalBanner extends Model
{
    use HasFactory;

    protected $table = 'promotional_banners';

    protected $fillable = [
        'module_id',
        'package_type',
        'redirect_to',
        'banner_image',
        'status',
    ];
}
