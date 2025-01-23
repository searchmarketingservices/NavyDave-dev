<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PostLikedNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Use database and broadcast channels
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Post Liked',
            'message' => 'Your post has been liked by ' . auth()->user()->name,
            'post_id' => $this->post->id,
            'post_content' => $this->post->content,
            'liked_by' => auth()->user()->name,
            'time' => now()->toDateTimeString(), // Adding the time of the like
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Post Liked',
            'message' => 'Your post has been liked by ' . auth()->user()->name,
            'post_id' => $this->post->id,
            'post_content' => $this->post->content,
            'liked_by' => auth()->user()->name,
            'time' => now()->toDateTimeString(), // Adding the time of the like
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'post' => [
                'title' => 'Post Liked',
                'message' => 'Your post has been liked by ' . auth()->user()->name,
                'post_id' => $this->post->id,
                'post_content' => $this->post->content,
                'liked_by' => auth()->user()->name,
                'time' => now()->toDateTimeString(), // Adding the time of the like
            ],
        ]);
    }
}
