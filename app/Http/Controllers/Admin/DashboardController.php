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
            'overdue' => Task::where('status', 'overdue')->count(),
            'done' => Task::where('status', 'done')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
