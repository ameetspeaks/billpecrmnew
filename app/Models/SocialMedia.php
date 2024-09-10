<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media';

    protected $fillable = [
        'user_id',
        'store_id',
        'facebook_link',
        'facebook_followers',
        'instagram_link',
        'instagram_followers',
        'youTube_link',
        'website_link',
        'app_link',
        'google_review_link',
        'kirana_club_link',
    ];
}
