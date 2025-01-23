<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $post;
    public function __construct($post)
    {
        $this->post = $post;
        Log::info('Event Constructor: ', ['post' => $post]); // Check logs
    }

    public function broadcastOn()
    {
        Log::info('Broadcasting on Channel: community-feed'); // Check logs
        return new Channel('community-feed');
    }

    public function broadcastAs()
    {
        return 'post-created';
    }
}
