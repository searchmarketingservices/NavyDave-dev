<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Declare the properties
    public $email;
    public $user;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param \App\Models\User $user
     */
    public function __construct($email, $user)
    {
        // Assign the parameters to class properties
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Use the properties correctly in the handle method
        Mail::to($this->email)->send(new WelcomeMail($this->user));
    }
}
