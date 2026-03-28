<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\TaskOverdue;

class CheckDueTasks extends Command
{
    protected $signature = 'tasks:check-due';
    protected $description = 'Mark overdue tasks based on due_date and status';

    public function handle(): int
    {
        $tasks = Task::with(['user.manager']) 
            ->whereDate('due_date', '<', now()->toDateString())
            ->whereIn('status', ['pending', 'in_progress'])
            ->get();

        $count = 0;

        foreach ($tasks as $task) {
            $task->status = 'overdue';
            $task->save();

            
            if ($task->user && $task->user->manager) {
                $task->user->manager->notify(new TaskOverdue($task));
            }

            $task->logActivity('marked_overdue', [
                'due_date' => $task->due_date,
                'from'     => 'pending/in_progress',
                'to'       => 'overdue',
            ]);

            $count++;
        }

        $this->info("Marked {$count} tasks as overdue.");
        return self::SUCCESS;
    }
}
