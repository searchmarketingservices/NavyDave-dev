<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory ;
    protected $table = 'staff';

    const STATUS = [1 =>'active', 2=>'inactive'];
   protected $fillable = ['user_id', 'image', 'service_id','status','notes'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
