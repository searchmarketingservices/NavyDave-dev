<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = [
        'app_name',
        'logo',
        'phone',
        'location',
        'email',
        'footer_description',
        'copyright',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
    ];

}
