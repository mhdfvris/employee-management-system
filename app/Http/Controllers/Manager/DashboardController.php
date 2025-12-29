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

        $stats = [
            'employees' => $employeeIds->count(),
            'tasks_total' => Task::whereIn('user_id', $employeeIds)->count(),
            'pending' => Task::whereIn('user_id', $employeeIds)->where('status', 'pending')->count(),
            'in_progress' => Task::whereIn('user_id', $employeeIds)->where('status', 'in_progress')->count(),
            'awaiting_review' => Task::whereIn('user_id', $employeeIds)->where('status', 'awaiting_review')->count(),
            'overdue' => Task::whereIn('user_id', $employeeIds)->where('status', 'overdue')->count(),
            'done' => Task::whereIn('user_id', $employeeIds)->where('status', 'done')->count(),
        ];

        return view('manager.dashboard', compact('stats'));
    }
}
