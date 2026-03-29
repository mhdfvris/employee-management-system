<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'employee')
            ->where('manager_id', auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest()->paginate(8)->withQueryString();

        return view('manager.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'employee_id' => 'required|string|max:255',
            'password'    => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
        ], [
            'password.min'   => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
        ]);

        User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'employee_id' => $data['employee_id'],
            'password'    => Hash::make($data['password']),
            'role'        => 'employee',
            'manager_id'  => auth()->id(),
        ]);

        return redirect()
            ->route('manager.employees.index')
            ->with('success', 'Employee created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $employee)
    {
        $this->ensureEmployeeBelongsToManager($employee);

        $employee->load([
            'tasks' => function ($query) {
                $query->latest();
            }
        ]);

        $tasks = $employee->tasks()->latest()->paginate(6);

        $stats = [
            'total' => $employee->tasks()->count(),
            'pending' => $employee->tasks()->where('status', 'pending')->count(),
            'in_progress' => $employee->tasks()->where('status', 'in_progress')->count(),
            'awaiting_review' => $employee->tasks()->where('status', 'awaiting_review')->count(),
            'done' => $employee->tasks()->where('status', 'done')->count(),
            'overdue' => $employee->tasks()
                ->whereDate('due_date', '<', now()->toDateString())
                ->whereNotIn('status', ['done'])
                ->count(),
        ];

        return view('manager.employees.show', compact('employee', 'tasks', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        $this->ensureEmployeeBelongsToManager($employee);

        return view('manager.employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $employee)
    {
        $this->ensureEmployeeBelongsToManager($employee);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $employee->id,
            'employee_id' => 'required|string|max:255',
        ]);

        $employee->update($data);

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $employee)
    {
        $this->ensureEmployeeBelongsToManager($employee);

        $employee->delete();

        return redirect()->route('manager.employees.index')
            ->with('success', 'Employee deleted.');
    }

    private function ensureEmployeeBelongsToManager(User $user): void
    {
        if (
            $user->role !== 'employee' ||
            $user->manager_id !== auth()->id()
        ) {
            abort(403);
        }
    }
}
