<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PostCreatedNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Use the database channel
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Post Created',
            'message' => 'New post created by ' . $this->post->user->name,
            'post_content' => $this->post->content,
            'created_by' => $this->post->user->name,
            'time' => now()->toDateTimeString(),
            'user_id' => $this->post->user->id,
            'user_name' => $this->post->user->name,
            'post_id' => $this->post->id,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Post Created',
            'message' => 'New post created by ' . $this->post->user->name,
            'post_content' => $this->post->content,
            'created_by' => $this->post->user->name,
            'time' => now()->toDateTimeString(),
            'user_id' => $this->post->user->id,
            'user_name' => $this->post->user->name,
            'post_id' => $this->post->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'New Post Created',
            'message' => 'New post created by ' . $this->post->user->name,
            'post_content' => $this->post->content,
            'created_by' => $this->post->user->name,
            'time' => now()->toDateTimeString(),
            'user_id' => $this->post->user->id,
            'user_name' => $this->post->user->name,
            'post_id' => $this->post->id,
        ]);
    }
}
