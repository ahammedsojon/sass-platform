<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $usersPerRole = User::get()->mapWithKeys(function ($user) {
            return [$user->name => $user->roles->pluck('name')];
        });

        $activeTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $projectsCount = Project::count();
        $usersCount = User::count();
        return response()->json([
            'total_users' => $usersCount,
            'users_per_role' => $usersPerRole,
            'active_tasks' => $activeTasks,
            'completed_tasks' => $completedTasks,
            'projects_count' => $projectsCount
        ]);
    }
}
