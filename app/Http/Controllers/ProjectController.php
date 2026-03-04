<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with('creator');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);
            if($validator->fails()){
                return response()->json(['error' => $validator->errors()], 422);
            }
            $validated = $validator->validated();
            Project::create([
               'name' => $validated['name'],
               'description' => $validated['description'],
               'created_by' => auth()->id()
            ]);
            return response()->json(['message' => 'Project Created!'], 201);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $project->load('tasks');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->only(['name', 'description']));
        return response()->json(['message' => 'Project Updated!', $project], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project Deleted!'], 200);
    }
}
