<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentChange extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'previous_date',
        'old_slot_id',
        'new_slot_id',
        'new_date',
        'changed_by',
        'reason',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function oldSlot()
    {
        return $this->belongsTo(Slot::class, 'old_slot_id');
    }

    public function newSlot()
    {
        return $this->belongsTo(Slot::class, 'new_slot_id');
    }
}
