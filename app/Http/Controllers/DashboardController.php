<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        try {
            $user = $request->user();
            $query = Task::query();

            if ($user->hasRole('User')) {
                $query->where('assigned_to', $user->id);
            }

            return response()->json([
                'total_projects' => Project::count(),
                'total_tasks' => $query->count(),
                'pending_tasks' => (clone $query)->where('status', 'pending')->count(),
                'in_progress_tasks' => (clone $query)->where('status', 'in_progress')->count(),
                'completed_tasks' => (clone $query)->where('status', 'completed')->count()
            ]);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
