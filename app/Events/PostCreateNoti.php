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

class PostCreateNoti implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * The event's broadcast channel.
     */
    public function broadcastOn()
    {
        return new Channel('post-notification-channel');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs()
    {
        return 'post-notification';
    }
}
