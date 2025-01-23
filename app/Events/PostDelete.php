<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class PostDelete implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function broadcastOn()
    {
        return new Channel('post-delete-channel');

    }

    public function broadcastWith()
    {
        return ['postId' => $this->postId];
    }


    public function broadcastAs()
    {
        return 'post-delete-event';
    }
}