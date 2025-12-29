<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'pending' => Task::where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress' => Task::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'awaiting_review' => Task::where('user_id', $userId)->where('status', 'awaiting_review')->count(),
            'overdue' => Task::where('user_id', $userId)->where('status', 'overdue')->count(),
            'done' => Task::where('user_id', $userId)->where('status', 'done')->count(),
        ];

        return view('employee.dashboard', compact('stats'));
    }
}
