<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PostDeleteNotification extends Notification
{
    use Queueable;

    protected $post;

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
            'title' => 'Your post has been deleted',
            'message' => 'Your post has been deleted by ' . auth()->user()->name . ' It may have violated our community guidelines.',
            'post_id' => $this->post['id'],
            'post_content' => $this->post['content'],
            'deleted_by' => auth()->user()->name,
            'time' => now()->toDateTimeString(), // Adding the time of the like
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Your post has been deleted',
            'message' => 'Your post has been deleted by ' . auth()->user()->name . ' It may have violated our community guidelines.',
            'post_id' => $this->post['id'],
            'post_content' => $this->post['content'],
            'deleted_by' => auth()->user()->name,
            'time' => now()->toDateTimeString(), // Adding the time of the like
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'post' => [
                'title' => 'Your post has been deleted',
                'message' => 'Your post has been deleted by ' . auth()->user()->name . ' It may have violated our community guidelines.',
                'post_id' => $this->post['id'],
                'post_content' => $this->post['content'],
                'deleted_by' => auth()->user()->name,
                'time' => now()->toDateTimeString(), // Adding the time of the like
            ],
        ]);
    }
}
