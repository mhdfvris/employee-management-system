<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TaskReview;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')
            ->whereHas('user', function ($q) {
                $q->where('manager_id', auth()->id());
            })
            ->orderBy('due_date', 'asc')
            ->get();

        return view('manager.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::where('role', 'employee')
            ->where('manager_id', auth()->id())
            ->withCount([
                'tasks',
                'tasks as pending_tasks_count' => function ($query) {
                    $query->where('status', 'pending');
                },
                'tasks as in_progress_tasks_count' => function ($query) {
                    $query->where('status', 'in_progress');
                },
                'tasks as awaiting_review_tasks_count' => function ($query) {
                    $query->where('status', 'awaiting_review');
                },
                'tasks as overdue_tasks_count' => function ($query) {
                    $query->whereDate('due_date', '<', now()->toDateString())
                          ->whereNotIn('status', ['done']);
                },
            ])
            ->orderBy('tasks_count')
            ->orderBy('name')
            ->get();

        return view('manager.tasks.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'employee')
                          ->where('manager_id', auth()->id());
                }),
            ],
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string|in:pending,in_progress,awaiting_review,done,overdue',
            'due_date'    => 'required|date',
        ]);

        // Extra defensive check
        $employee = $this->getManagedEmployeeOrAbort((int) $data['user_id']);

        $task = Task::create([
            'user_id'     => $employee->id,
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
            'due_date'    => $data['due_date'],
        ]);

        $task->logActivity('manager_created', [
            'assigned_to' => $task->user_id,
            'status'      => $task->status,
            'due_date'    => $task->due_date,
        ]);

        return redirect()
            ->route('manager.tasks.index')
            ->with('success', 'Task created for employee.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->ensureTaskBelongsToManager($task);

        $employees = User::where('role', 'employee')
            ->where('manager_id', auth()->id())
            ->orderBy('name')
            ->get();

        $task->load('reviews.manager');

        return view('manager.tasks.show', compact('task', 'employees'));
    }

    /**
     * Update task status.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->ensureTaskBelongsToManager($task);

        $data = $request->validate([
            'status' => 'required|string|in:pending,in_progress,awaiting_review,done,overdue',
        ]);

        $before = $task->status;

        $task->status = $data['status'];
        $task->save();

        $task->logActivity('status_changed', [
            'from' => $before,
            'to'   => $task->status,
        ]);

        return redirect()
            ->route('manager.tasks.show', $task)
            ->with('success', 'Task status updated.');
    }

    /**
     * Reassign task to another employee under the same manager.
     */
    public function updateAssignee(Request $request, Task $task)
    {
        $this->ensureTaskBelongsToManager($task);

        $data = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'employee')
                          ->where('manager_id', auth()->id());
                }),
            ],
        ]);

        $employee = $this->getManagedEmployeeOrAbort((int) $data['user_id']);
        $before = $task->user_id;

        $task->user_id = $employee->id;
        $task->save();

        $task->logActivity('reassigned', [
            'from_user_id' => $before,
            'to_user_id'   => $task->user_id,
        ]);

        return redirect()
            ->route('manager.tasks.show', $task)
            ->with('success', 'Task reassigned to another employee.');
    }

    /**
     * Approve task.
     */
    public function approve(Request $request, Task $task)
    {
        $this->ensureTaskBelongsToManager($task);

        $data = $request->validate([
            'comment' => 'nullable|string|max:2000',
        ]);

        $before = $task->status;

        $task->update(['status' => 'done']);

        if (!empty($data['comment'])) {
            TaskReview::create([
                'task_id'    => $task->id,
                'manager_id' => auth()->id(),
                'comment'    => $data['comment'],
                'decision'   => 'approved',
            ]);
        }

        $task->logActivity('approved', [
            'from'    => $before,
            'to'      => 'done',
            'comment' => $data['comment'] ?? null,
        ]);

        return redirect()
            ->route('manager.tasks.show', $task)
            ->with('success', 'Task approved as done.');
    }

    /**
     * Send task back.
     */
    public function sendBack(Request $request, Task $task)
    {
        $this->ensureTaskBelongsToManager($task);

        $data = $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $before = $task->status;

        $task->update(['status' => 'in_progress']);

        TaskReview::create([
            'task_id'    => $task->id,
            'manager_id' => auth()->id(),
            'comment'    => $data['comment'],
            'decision'   => 'sent_back',
        ]);

        $task->logActivity('sent_back', [
            'from'    => $before,
            'to'      => 'in_progress',
            'comment' => $data['comment'],
        ]);

        return redirect()
            ->route('manager.tasks.show', $task)
            ->with('success', 'Task sent back to in progress.');
    }

    /**
     * Ensure the task belongs to an employee managed by the current manager.
     */
    private function ensureTaskBelongsToManager(Task $task): void
    {
        $task->load('user');

        if (!$task->user || $task->user->role !== 'employee' || $task->user->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized task access.');
        }
    }

    /**
     * Retrieve an employee under the current manager or abort.
     */
    private function getManagedEmployeeOrAbort(int $userId): User
    {
        $employee = User::where('id', $userId)
            ->where('role', 'employee')
            ->where('manager_id', auth()->id())
            ->first();

        if (!$employee) {
            abort(403, 'Unauthorized employee selection.');
        }

        return $employee;
    }
}