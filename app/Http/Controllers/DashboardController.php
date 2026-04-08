<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $stats = [
                'total_tasks'      => Task::count(),
                'pending'          => Task::where('status', 'pending')->count(),
                'in_progress'      => Task::where('status', 'in_progress')->count(),
                'completed'        => Task::where('status', 'completed')->count(),
                'total_employees'  => User::where('role', 'employee')->count(),
                'overdue'          => Task::where('status', '!=', 'completed')
                    ->where('due_date', '<', now())->count(),
            ];
            $recentTasks = Task::with(['assignee', 'creator'])
                ->latest()->take(8)->get();
            $employees   = User::where('role', 'employee')
                ->withCount('assignedTasks')->get();
        } else {
            $stats = [
                'total_tasks'  => Task::where('assigned_to', $user->id)->count(),
                'pending'      => Task::where('assigned_to', $user->id)->where('status', 'pending')->count(),
                'in_progress'  => Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
                'completed'    => Task::where('assigned_to', $user->id)->where('status', 'completed')->count(),
            ];
            $recentTasks = Task::where('assigned_to', $user->id)
                ->with('creator')->latest()->take(8)->get();
            $employees   = collect();
        }

        return view('dashboard', compact('stats', 'recentTasks', 'employees'));
    }
}
