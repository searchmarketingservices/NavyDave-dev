<?php

namespace App\Jobs;

use App\Mail\UserMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $adminEmail;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($adminEmail, $data)
    {
        $this->adminEmail = $adminEmail;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->adminEmail)->send(new UserMessage($this->data));
    }
}
