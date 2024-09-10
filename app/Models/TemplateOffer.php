<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateOffer extends Model
{
    use HasFactory;

    protected $table = 'template_offers';

    protected $fillable = [
        'category_id',
        'product_id',
        'name',
        'image',
    ];
}
