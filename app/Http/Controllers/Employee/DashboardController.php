<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $taskQuery = Task::where('user_id', $userId);

        $stats = [
            'pending' => (clone $taskQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $taskQuery)->where('status', 'in_progress')->count(),
            'awaiting_review' => (clone $taskQuery)->where('status', 'awaiting_review')->count(),
            'overdue' => (clone $taskQuery)
                ->whereDate('due_date', '<', now()->toDateString())
                ->whereNotIn('status', ['done'])
                ->count(),
            'done' => (clone $taskQuery)->where('status', 'done')->count(),
            'total' => (clone $taskQuery)->count(),
        ];

        $upcomingTasks = Task::where('user_id', $userId)
            ->whereNotIn('status', ['done'])
            ->whereDate('due_date', '>=', now()->toDateString())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('employee.dashboard', compact('stats', 'upcomingTasks'));
    }
}
