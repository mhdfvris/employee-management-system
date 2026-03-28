<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $managerId = auth()->id();

        $employeeIds = User::where('role', 'employee')
            ->where('manager_id', $managerId)
            ->pluck('id');

        $taskQuery = Task::whereIn('user_id', $employeeIds);

        $stats = [
            'employees' => $employeeIds->count(),
            'tasks_total' => (clone $taskQuery)->count(),
            'pending' => (clone $taskQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $taskQuery)->where('status', 'in_progress')->count(),
            'awaiting_review' => (clone $taskQuery)->where('status', 'awaiting_review')->count(),
            'overdue' => (clone $taskQuery)
                ->whereDate('due_date', '<', now()->toDateString())
                ->whereNotIn('status', ['done'])
                ->count(),
            'done' => (clone $taskQuery)->where('status', 'done')->count(),
        ];

        $employeePerformance = User::where('role', 'employee')
            ->where('manager_id', $managerId)
            ->withCount([
                'tasks',
                'tasks as done_tasks_count' => function ($query) {
                    $query->where('status', 'done');
                },
                'tasks as overdue_tasks_count' => function ($query) {
                    $query->whereDate('due_date', '<', now()->toDateString())
                          ->whereNotIn('status', ['done']);
                },
            ])
            ->orderByDesc('done_tasks_count')
            ->orderBy('name')
            ->take(6)
            ->get();

        $upcomingDeadlines = Task::with('user')
            ->whereIn('user_id', $employeeIds)
            ->whereNotIn('status', ['done'])
            ->whereDate('due_date', '>=', now()->toDateString())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $recentTasks = Task::with('user')
            ->whereIn('user_id', $employeeIds)
            ->latest()
            ->take(5)
            ->get();

        return view('manager.dashboard', compact(
            'stats',
            'employeePerformance',
            'upcomingDeadlines',
            'recentTasks'
        ));
    }
}
