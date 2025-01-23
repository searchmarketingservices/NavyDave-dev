<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';
    protected $fillable = ['service_id', 'percentage', 'start_date', 'end_date', 'status'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
