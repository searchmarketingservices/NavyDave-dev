<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CommentRepliedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $comment;
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Reply to Your Comment',
            'message' => $this->comment->comment, // The content of the reply
            'comment_id' => $this->comment->id, // ID of the reply
            'post_id' => $this->comment->post_id, // ID of the post
            'user_id' => $this->comment->user_id, // ID of the user who made the reply
            'user_name' => $this->comment->user['name'], // Name of the user who made the reply
            'parent_comment_id' => $this->comment->parent_id, // ID of the original comment
            'created_at' => now(), // Timestamp of the notification
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Reply to Your Comment',
            'message' => $this->comment->comment, // The content of the reply
            'comment_id' => $this->comment->id, // ID of the reply
            'post_id' => $this->comment->post_id, // ID of the post
            'user_id' => $this->comment->user_id, // ID of the user who made the reply
            'user_name' => $this->comment->user['name'], // Name of the user who made the reply
            'parent_comment_id' => $this->comment->parent_id, // ID of the original comment
            'created_at' => now(), // Timestamp of the notification
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'post' => [
                'title' => 'New Reply to Your Comment',
                'message' => $this->comment->comment, // The content of the reply
                'comment_id' => $this->comment->id, // ID of the reply
                'post_id' => $this->comment->post_id, // ID of the post
                'user_id' => $this->comment->user_id, // ID of the user who made the reply
                'user_name' => $this->comment->user['name'], // Name of the user who made the reply
                'parent_comment_id' => $this->comment->parent_id, // ID of the original comment
                'created_at' => now(), // Timestamp of the notification
                'time' => now()->toDateTimeString(),
            ],
        ]);
    }
}
