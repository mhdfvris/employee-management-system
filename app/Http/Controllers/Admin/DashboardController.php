<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'managers' => User::where('role', 'manager')->count(),
            'employees' => User::where('role', 'employee')->count(),
            'tasks_total' => Task::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'awaiting_review' => Task::where('status', 'awaiting_review')->count(),
            'overdue' => Task::whereDate('due_date', '<', now()->toDateString())
                ->whereNotIn('status', ['done'])
                ->count(),
            'done' => Task::where('status', 'done')->count(),
        ];

        $managerInsights = User::where('role', 'manager')
            ->withCount([
                'employees',
                'managedTasks',
                'managedTasks as done_tasks_count' => function ($query) {
                    $query->where('status', 'done');
                },
                'managedTasks as overdue_tasks_count' => function ($query) {
                    $query->whereDate('due_date', '<', now()->toDateString())
                          ->whereNotIn('status', ['done']);
                },
            ])
            ->orderBy('name')
            ->get();

        $topManager = $managerInsights
            ->sortByDesc(function ($manager) {
                return [$manager->done_tasks_count, $manager->managed_tasks_count];
            })
            ->first();

        $overloadedManager = $managerInsights
            ->sortByDesc(function ($manager) {
                return [$manager->overdue_tasks_count, $manager->employees_count, $manager->managed_tasks_count];
            })
            ->first();

        $recentManagers = User::where('role', 'manager')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'managerInsights',
            'topManager',
            'overloadedManager',
            'recentManagers'
        ));
    }
}
