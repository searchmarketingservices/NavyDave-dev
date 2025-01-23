<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestrictSlot extends Model
{
    use HasFactory;
    protected $table = "restrict_slots";
    protected $fillable = ['date'];
}
