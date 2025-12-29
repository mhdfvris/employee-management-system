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
        $tasks = Task::whereDate('due_date', '<', now()->toDateString())
            ->whereIn('status', ['pending', 'in_progress']) // only these should become overdue
            ->get();

        $count = 0;

        foreach ($tasks as $task) {
            $task->status = 'overdue';
            $task->save();

            $task->load('user');
            
            if ($task->user && $task->user->manager_id) {
                $manager = User::find($task->user->manager_id);

                if ($manager) {
                    $manager->notify(new TaskOverdue($task));
                }
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
