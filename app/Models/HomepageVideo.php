<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageVideo extends Model
{
    use HasFactory;

    protected $table = 'homepage_videos';

    protected $fillable = [
        'module_id',
        'package_type',
        'module_condition',
        'homepage_video_image',
        'status',  
    ];
}
