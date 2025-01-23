<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\Slot;

class AppointmentSlot extends Model
{
    use HasFactory;

    protected $table = 'appointment_slots';
    protected $fillable = [
        'appointment_id',
        'slot_id',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
