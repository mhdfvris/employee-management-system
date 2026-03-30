<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\StoreManagerRequest;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'manager')
            ->withCount(['employees', 'managedTasks']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filter === 'has_employees') {
            $query->has('employees');
        }

        if ($request->filter === 'no_employees') {
            $query->doesntHave('employees');
        }

        $managers = $query->orderBy('name')->get();

        return view('admin.managers.index', compact('managers'));
    }

    public function create()
    {
        return view('admin.managers.create');
    }

    public function store(StoreManagerRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => 'manager',
            'employee_id' => null,
        ]);

        Log::info('Manager created', [
            'admin_id' => auth()->id(),
            'manager_email' => $data['email'],
        ]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager created.');
    }

    public function show(User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $manager->loadCount([
            'employees',
            'managedTasks',
            'managedTasks as done_tasks_count' => function ($query) {
                $query->where('status', 'done');
            },
            'managedTasks as pending_tasks_count' => function ($query) {
                $query->where('status', 'pending');
            },
            'managedTasks as in_progress_tasks_count' => function ($query) {
                $query->where('status', 'in_progress');
            },
            'managedTasks as awaiting_review_tasks_count' => function ($query) {
                $query->where('status', 'awaiting_review');
            },
            'managedTasks as overdue_tasks_count' => function ($query) {
                $query->whereDate('due_date', '<', now()->toDateString())
                      ->whereNotIn('status', ['done']);
            },
        ]);

        $employees = $manager->employees()
            ->orderBy('name')
            ->get();

        $recentTasks = Task::with('user')
            ->whereIn('user_id', $manager->employees()->pluck('id'))
            ->latest()
            ->take(6)
            ->get();

        return view('admin.managers.show', compact('manager', 'employees', 'recentTasks'));
    }

    public function edit(User $manager)
    {
        return view('admin.managers.edit', compact('manager'));
    }

    public function update(Request $request, User $manager)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $manager->id,
        ]);

        $manager->update($data);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager updated.');
    }

    public function destroy(User $manager)
    {
        if ($manager->employees()->exists()) {
            return redirect()
                ->route('admin.managers.index')
                ->with('error', 'Cannot delete manager with assigned employees. Reassign employees first');
        }

        $manager->delete();

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager deleted.');
    }

    public function showReassign(User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $employees = $manager->employees()->orderBy('name')->get();

        $otherManagers = User::where('role', 'manager')
            ->where('id', '!=', $manager->id)
            ->withCount(['employees', 'managedTasks'])
            ->orderBy('employees_count')
            ->orderBy('managed_tasks_count')
            ->orderBy('name')
            ->get();

        $recommendedManager = $otherManagers->first();

        return view('admin.managers.reassign', compact(
            'manager',
            'employees',
            'otherManagers',
            'recommendedManager'
        ));
    }

    public function storeReassign(Request $request, User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $data = $request->validate([
            'new_manager_id' => 'required|exists:users,id',
        ]);

        $newManager = User::where('role', 'manager')->findOrFail($data['new_manager_id']);

        if ($newManager->id === $manager->id) {
            return back()->with('error', 'Please choose a different manager.');
        }

        $manager->employees()->update([
            'manager_id' => $newManager->id,
        ]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Employees reassigned successfully.');
    }
}
