<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = User::where('role', 'manager')
            ->withCount('employees','managedTasks')
            ->orderBy('name')
            ->get();

        return view('admin.managers.index', compact('managers'));
    }

    public function create()
    {
        return view('admin.managers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => 'manager',
            'employee_id' => null,
        ]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager created.');
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
        // Safety: ensure this really is a manager
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $employees = $manager->employees()->orderBy('name')->get();

        $otherManagers = User::where('role', 'manager')
            ->where('id', '!=', $manager->id)
            ->orderBy('name')
            ->get();

        return view('admin.managers.reassign', compact('manager', 'employees', 'otherManagers'));
    }

    public function storeReassign(Request $request, User $manager)
    {
        if ($manager->role !== 'manager') {
            abort(404);
        }

        $data = $request->validate([
            'new_manager_id' => 'required|exists:users,id',
        ]);

        // Extra safety: new manager must actually be a manager and not same as current
        $newManager = User::where('role', 'manager')->findOrFail($data['new_manager_id']);

        if ($newManager->id === $manager->id) {
            return back()->with('error', 'Please choose a different manager.');
        }

        // Move all employees
        $manager->employees()->update([
            'manager_id' => $newManager->id,
        ]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Employees reassigned successfully.');
    }
}
