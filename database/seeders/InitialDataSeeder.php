<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'        => 'System Admin',
                'password'    => Hash::make('password123'),
                'role'        => 'admin',
                'employee_id' => null,
            ]
        );
        
        //Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name'        => 'Default Manager',
                'password'    => Hash::make('password123'),
                'role'        => 'manager',
                'employee_id' => null,
            ]
        );

        // Employee 1
        $employee1 = User::firstOrCreate(
            ['email' => 'employee1@example.com'],
            [
                'name'        => 'Employee One',
                'password'    => Hash::make('password123'),
                'role'        => 'employee',
                'employee_id' => 'EMP-1001',
                'manager_id'  => $manager->id,
            ]
        );

        // Employee 2
        $employee2 = User::firstOrCreate(
            ['email' => 'employee2@example.com'],
            [
                'name'        => 'Employee Two',
                'password'    => Hash::make('password123'),
                'role'        => 'employee',
                'employee_id' => 'EMP-1002',
                'manager_id'  => $manager->id,
            ]
        );

        // Sample tasks for employee1
        Task::firstOrCreate(
            ['title' => 'Prepare weekly report', 'user_id' => $employee1->id],
            [
                'description' => 'Summarise tasks completed this week.',
                'status'      => 'pending',
                'due_date'    => now()->addDays(2)->toDateString(),
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Client follow-up emails', 'user_id' => $employee1->id],
            [
                'description' => 'Send follow-up emails to pending clients.',
                'status'      => 'in_progress',
                'due_date'    => now()->addDays(1)->toDateString(),
            ]
        );

        // Sample task for employee2
        Task::firstOrCreate(
            ['title' => 'Update internal documentation', 'user_id' => $employee2->id],
            [
                'description' => 'Review and update outdated internal docs.',
                'status'      => 'done',
                'due_date'    => now()->subDay()->toDateString(),
            ]
        );
    }
}
