<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdated;

class SendStatusMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $appointment;
    public $role;

    /**
     * Create a new job instance.
     */
    public function __construct($email, Appointment $appointment, $role)
    {
        $this->email = $email;
        $this->appointment = $appointment;
        $this->role = $role;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new AppointmentStatusUpdated($this->appointment, $this->role));
    }
}
