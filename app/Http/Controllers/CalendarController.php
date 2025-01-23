<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class CalendarController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('service.category', 'staff.user', 'slot', 'payment')->get();
        return view('dashboard.admin.calendar.index', compact('appointments'));
    }
}
