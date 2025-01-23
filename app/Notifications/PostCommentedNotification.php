<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PostCommentedNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Use database and broadcast channels
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Comment on Your Post',
            'message' => 'Someone commented: ' . $this->comment->content,
            'post_id' => $this->comment->post->id,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'commented_by' => $this->comment->user->name,
            'time' => now()->toDateTimeString(),
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Comment on Your Post',
            'message' => 'Someone commented: ' . $this->comment->comment,
            'post_id' => $this->comment->post->id,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->comment,
            'commented_by' => $this->comment->user->name,
            'time' => now()->toDateTimeString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'post' => [
                'title' => 'New Comment on Your Post',
                'message' => 'Someone commented: ' . $this->comment->comment,
                'post_id' => $this->comment->post->id,
                'comment_id' => $this->comment->id,
                'comment_content' => $this->comment->comment,
                'commented_by' => $this->comment->user->name,
                'time' => now()->toDateTimeString(),
            ],
        ]);
    }
    
}
