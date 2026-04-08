<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name'       => 'Admin User',
            'email'      => 'admin@taskflow.com',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'department' => 'Management',
        ]);

        // Employees
        $emp1 = User::create([
            'name'       => 'Ali Hassan',
            'email'      => 'ali@taskflow.com',
            'password'   => Hash::make('password'),
            'role'       => 'employee',
            'department' => 'Development',
            'phone'      => '0300-1234567',
        ]);

        $emp2 = User::create([
            'name'       => 'Sara Khan',
            'email'      => 'sara@taskflow.com',
            'password'   => Hash::make('password'),
            'role'       => 'employee',
            'department' => 'Design',
            'phone'      => '0321-9876543',
        ]);

        // Tasks
        $tasks = [
            ['title' => 'Build Login Page',      'priority' => 'high',   'status' => 'completed',  'assigned_to' => $emp1->id],
            ['title' => 'Design Dashboard UI',   'priority' => 'medium', 'status' => 'in_progress','assigned_to' => $emp2->id],
            ['title' => 'Setup Database Schema', 'priority' => 'urgent', 'status' => 'completed',  'assigned_to' => $emp1->id],
            ['title' => 'Write API Docs',        'priority' => 'low',    'status' => 'pending',    'assigned_to' => $emp2->id],
            ['title' => 'Test Authentication',   'priority' => 'high',   'status' => 'pending',    'assigned_to' => $emp1->id],
            ['title' => 'Create Mobile Layout',  'priority' => 'medium', 'status' => 'in_progress','assigned_to' => $emp2->id],
        ];

        foreach ($tasks as $task) {
            Task::create(array_merge($task, [
                'created_by' => $admin->id,
                'due_date'   => now()->addDays(rand(1, 30)),
                'description'=> 'Task description for: ' . $task['title'],
            ]));
        }
    }
}
