<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;

class SendWelcomeMail2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email;
    protected $userId;
    public function __construct($email, $userId)
    {
        $this->email = $email;
        $this->userId = $userId;
    }

    public function handle()
    {
        // Retrieve the user from the database using the passed ID
        $user = User::find($this->userId);

        // Now you can send the email or perform any necessary actions
        if ($user) {
            Mail::to($this->email)->send(new WelcomeMail($user));
        }
    }

}
