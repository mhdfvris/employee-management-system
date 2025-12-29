<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Manager\TaskController as ManagerTaskController;
use App\Http\Controllers\Manager\EmployeeController as ManagerEmployeeController;
use App\Http\Controllers\Admin\ManagerController as AdminManagerController;

use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


Route::middleware(['auth', 'employee'])->group(function () {

    // Employee dashboard (WITH controller)
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');

    // Employee task CRUD
    Route::resource('tasks', TaskController::class);
});

Route::middleware(['auth', 'manager'])
    ->prefix('manage')
    ->name('manager.')
    ->group(function () {

        // Manager dashboard
        Route::get('/dashboard', [ManagerDashboardController::class, 'index'])
            ->name('dashboard');

        // Manager task management
        Route::get('tasks', [ManagerTaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/create', [ManagerTaskController::class, 'create'])->name('tasks.create');
        Route::post('tasks', [ManagerTaskController::class, 'store'])->name('tasks.store');
        Route::get('tasks/{task}', [ManagerTaskController::class, 'show'])->name('tasks.show');

        Route::patch('tasks/{task}/status', [ManagerTaskController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::patch('tasks/{task}/assignee', [ManagerTaskController::class, 'updateAssignee'])->name('tasks.updateAssignee');
        Route::patch('tasks/{task}/approve', [ManagerTaskController::class, 'approve'])->name('tasks.approve');
        Route::patch('tasks/{task}/send-back', [ManagerTaskController::class, 'sendBack'])->name('tasks.sendBack');

        // Manager CRUD employees
        Route::resource('employees', ManagerEmployeeController::class);
    });

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Admin manage managers
        Route::resource('managers', AdminManagerController::class);

        // Reassign employees between managers
        Route::get('managers/{manager}/reassign', [AdminManagerController::class, 'showReassign'])
            ->name('managers.reassign');

        Route::post('managers/{manager}/reassign', [AdminManagerController::class, 'storeReassign'])
            ->name('managers.reassign.store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->latest()->get();

        auth()->user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');
});


require __DIR__.'/auth.php';
