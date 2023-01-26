<?php

namespace App\Notifications;

use App\Models\Comments;
use App\Models\Ideas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;

    public $idea;

    public function __construct(Comments $comment, Ideas $idea)
    {
        $this->comment = $comment;
        $this->idea = $idea;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(config('app.name').' U Have new Comment on your Idea')
            ->markdown('mails.comment-added', [
                'comment' => $this->comment,
                'idea' => $this->idea,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'comment_body' => $this->comment->body,
            'user_avatar' => $this->comment->user->getAvatar(),
            'user_name' => $this->comment->user->name,
            'idea_id' => $this->idea->id,
            'idea_slug' => $this->idea->slug,
            'idea_title' => $this->idea->title,
        ];
    }
}
