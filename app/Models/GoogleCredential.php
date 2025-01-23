<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCredential extends Model
{
    use HasFactory;
    protected $fillable = ['id','client_id', 'client_secret', 'access_token', 'refresh_token'];
}
