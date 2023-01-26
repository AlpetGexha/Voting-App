<?php

namespace App\Http\Livewire\Action;

use App\Models\Comments;
use App\Models\Ideas;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use WireUi\Traits\Actions;

class CommentNotification extends Component
{
    use Actions;

    const NOTIFICATION_THRESHOLD = 20;

    const NOTIFICATION_SHOW = 6;

    public $notifications;

    public $notificationCount;

    public $isLoading;

    protected $listeners = ['getNotifications'];

    public function mount()
    {
        $this->notifications = collect([]);
        $this->isLoading = true;
        $this->getNotificationCount();
    }

    public function getNotificationCount()
    {
        $this->notificationCount = auth()->user()->unreadNotifications()->count();

        if ($this->notificationCount > self::NOTIFICATION_THRESHOLD) {
            $this->notificationCount = self::NOTIFICATION_THRESHOLD.'+';
        }
    }

    public function getNotifications()
    {
        $this->notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(self::NOTIFICATION_SHOW)
            ->get();

        $this->isLoading = false;
    }

    public function markAllRead()
    {
        abort_if(! auth()->check(), 403);

        auth()->user()->unreadNotifications->markAsRead();
        $this->getNotificationCount();
        $this->getNotifications();
    }

    public function markAsRead($notificationId)
    {
        abort_if(! auth()->check(), 403);

        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();

        $this->scrollToComment($notification);
    }

    public function scrollToComment($notification)
    {
        $idea = Ideas::find($notification->data['idea_id']);
        if (! $idea) {
            $this->notification()->error('Error', 'This comment no longer exists!');

            return to_route('ideas.ideas');
        }

        $comment = Comments::find($notification->data['comment_id']);
        if (! $comment) {
            $this->notification()->error('Error', 'This comment no longer exists!');

            return to_route('ideas.ideas');
        }

        $comments = $idea->comments()->pluck('id');
        $indexOfComment = $comments->search($comment->id);

        // $page = (int) ($indexOfComment / $comment->getPerPage()) + 1;

        session()->flash('scrollToComment', $comment->id);

        return redirect()->route('ideas.show', [
            'slug' => $notification->data['idea_slug'],
            // 'page' => $page,
        ]);
    }

    public function render()
    {
        return view('livewire.action.comment-notification');
    }
}
