<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskAwaitingReview extends Notification
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'task_awaiting_review',
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'employee_id' => $this->task->user_id,
            'due_date' => $this->task->due_date,
        ];
    }
}
