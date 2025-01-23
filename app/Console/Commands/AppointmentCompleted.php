<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Appointment;

class AppointmentCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:appointment-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get today’s date
        $today = Carbon::today();

        // Find all appointments where date is before today and status is confirmed
        $appointments = Appointment::where('appointment_date', '<', $today)
            ->where('status', 'confirmed')
            ->get();

        foreach ($appointments as $appointment) {

            if ($appointment->completed_slots < $appointment->total_slots) {
                $appointment->status = 'completed';
            } else {
                $appointment->status = 'completed';
            }

            if($appointment->completed_slots == $appointment->total_slots){
                $appointment->active = '0';
            }else{
                $appointment->active = '1';
            }

            $appointment->save();
        }

        $this->info('Old appointments have been marked as completed.');
    }
}
