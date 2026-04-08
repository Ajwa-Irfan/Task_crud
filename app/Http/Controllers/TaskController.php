<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = $user->isAdmin()
            ? Task::with(['assignee', 'creator'])
            : Task::where('assigned_to', $user->id)->with('creator');

        if ($request->status)   $query->where('status',   $request->status);
        if ($request->priority) $query->where('priority', $request->priority);
        if ($request->search)   $query->where('title', 'like', '%'.$request->search.'%');

        $tasks     = $query->latest()->paginate(10);
        $employees = User::where('role', 'employee')->get();

        return view('tasks.index', compact('tasks', 'employees'));
    }

    public function create()
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $employees = User::where('role', 'employee')->where('is_active', true)->get();
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date|after:today',
        ]);

        Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'created_by'  => auth()->id(),
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
            'status'      => 'pending',
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = User::where('role', 'employee')->where('is_active', true)->get();
        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status'      => 'required|in:pending,in_progress,completed,cancelled',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
        ]);

        $data = $request->only(['title','description','assigned_to','status','priority','due_date']);

        if ($request->status === 'completed' && $task->status !== 'completed') {
            $data['completed_at'] = now();
        }

        $task->update($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate(['status' => 'required|in:pending,in_progress,completed,cancelled']);
        $task->update(['status' => $request->status]);
        return back()->with('success', 'Status updated!');
    }
}
