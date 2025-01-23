<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCreated;
use App\Models\Appointment;

class SendMail implements ShouldQueue
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
    public function handle()
    {
        Mail::to($this->email)->send(new AppointmentCreated($this->appointment, $this->role));
    }
}
