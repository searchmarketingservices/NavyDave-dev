<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Notifications\Messages\BroadcastMessage;

class LikeOnCommentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $post;
    public function __construct($post)
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
            'title' => 'Someone liked your Comment',
            'message' => 'Your comment has been liked by ' . auth()->user()->name,
            'post_id' => $this->post->id,
            'post_content' => $this->post->content,
            'liked_by' => auth()->user()->name,
            'time' => now()->toDateTimeString(), // Adding the time of the like
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Someone liked your Comment',
            'message' =>  'Your comment has been liked by ' . auth()->user()->name,
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
                'title' => 'Someone liked your Comment',
                'message' =>  'Your comment has been liked by ' . auth()->user()->name,
                'post_id' => $this->post->id,
                'post_content' => $this->post->content,
                'liked_by' => auth()->user()->name,
                'time' => now()->toDateTimeString(), // Adding the time of the like
            ],
        ]);
    }
}
