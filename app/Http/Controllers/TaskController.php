<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\TaskAwaitingReview;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = auth()->user()
            ->tasks()
            ->orderBy('due_date', 'asc')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string|in:pending,in_progress,awaiting_review',
            'due_date'    => 'required|date',
        ]);

        $data['user_id'] = auth()->id();

        $task = Task::create($data);

        $task->logActivity('created', [
            'title' => $task->title,
            'status' => $task->status,
            'due_date' => $task->due_date,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Ensure user is editing their own task
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $this->ensureTaskIsEditable($task);

        $task->load('reviews.manager');

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        $this->ensureTaskIsEditable($task);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string|in:pending,in_progress,awaiting_review',
            'due_date'    => 'required|date',
        ]);

        $before = $task->only(['title', 'description', 'status', 'due_date']);

        $task->update($data);

        $after = $task->only(['title', 'description', 'status', 'due_date']);

        // Notify manager when employee submits for review
        if (($before['status'] ?? null) !== 'awaiting_review' && ($after['status'] ?? null) === 'awaiting_review') {
            $employee = auth()->user();

            if ($employee->manager_id) {
                $manager = User::find($employee->manager_id);

                if ($manager) {
                    $manager->notify(new TaskAwaitingReview($task));
                }
            }
        }

        $task->logActivity('updated', [
            'before' => $before,
            'after'  => $after,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    private function ensureTaskIsEditable(Task $task): void
    {
        if ($task->status === 'overdue') {
            abort(403, 'This task is overdue and cannot be edited.');
        }
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $this->ensureTaskIsEditable($task);
        
        $task->logActivity('deleted', [
            'title' => $task->title,
            'status' => $task->status,
            'due_date' => $task->due_date,
        ]);
        
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
