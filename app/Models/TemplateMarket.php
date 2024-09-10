<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMarket extends Model
{
    use HasFactory;

    protected $table = 'template_markets';

    protected $fillable = [
        'category_id',
        'template_type_id',
        'template_name',
        'template_image',
    ];
}
