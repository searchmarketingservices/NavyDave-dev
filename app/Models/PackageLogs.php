<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageLogs extends Model
{
    use HasFactory;

    protected $table = 'packagelogs';

    protected $fillable = [
        'user_id',
        'package_id',
        'action_type',
        'slots_used',
        'amount_paid',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(UserPackage::class);
    }
}
