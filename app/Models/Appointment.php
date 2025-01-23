<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'google_event_id',
        'service_id',
        'package_id',
        'user_id',
        'active',
        'staff_id',
        'slot_id',
        'total_slots',
        'completed_slots',
        'appointment_date',
        'first_name',
        'last_name',
        'email',
        'phone',
        'location',
        'price',
        'note',
        'status',
        'is_rescheduled',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPackage()
    {
        return $this->belongsTo(UserPackage::class);
    }

}
