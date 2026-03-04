<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Task::with(['project', 'assignee']);
        // Role-based visibility
        if ($user->hasRole('User')) {
            $query->where('assigned_to', $user->id);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'project_id' => 'required|exists:projects,id',
                'assigned_to' => 'required|exists:users,id',
                'status' => 'in:pending,in_progress,completed'
            ]);

            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            Task::create($validated);
            return response()->json(['message' => 'Task Created!'], 201);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task->load(['project', 'assignee']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->only(['title', 'description', 'status', 'assigned_to']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task Deleted!'], 200);
    }
}
