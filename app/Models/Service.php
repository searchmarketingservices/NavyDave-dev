<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = [
        'image',
        'name',
        'category_id',
        'price',
        'slots',
        'duration',
        'type_duration',
        'buffer_time_before',
        'type_buffer_time_before',
        'buffer_time_after',
        'type_buffer_time_after',
        'min_capacity',
        'max_capacity',
        'description',
        'is_admin'
    ];
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }
}
