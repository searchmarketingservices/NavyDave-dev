<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function mailCheck()
    {

        try {
            $appointment = Appointment::with('slot', 'staff.user', 'service')->first();

            // Send email

            SendMail::dispatch("talharao997az@gmail.com", $appointment, 'staff');
            // SendMail::dispatch("navydavegolf@gmail.com", $appointment, 'staff');
            SendMail::dispatch("hw13604@gmail.com", $appointment, 'staff');

            return response()->json(['success' => true, 'message' => 'Appointment created successfully', 'data' => $appointment]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create appointment', 'error' => $e->getMessage()], 500);
        }
    }
}
