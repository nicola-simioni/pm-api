<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Organization;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     *
     * GET /api/projects
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Load projects with their organization and tasks
        $projects = Project::with('organization', 'tasks')->get();
        return response()->json($projects);
    }

    /**
     * Store a newly created project in storage.
     *
     * POST /api/projects
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $project = Project::create($request->only('name', 'description', 'organization_id'));

        return response()->json($project, 201);
    }

    /**
     * Display the specified project.
     *
     * GET /api/projects/{id}
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $project = Project::with('organization', 'tasks')->findOrFail($id);
        return response()->json($project);
    }

    /**
     * Update the specified project in storage.
     *
     * PUT /api/projects/{id}
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'organization_id' => 'sometimes|required|exists:organizations,id',
        ]);

        $project = Project::findOrFail($id);
        $project->update($request->only('name', 'description', 'organization_id'));

        return response()->json($project);
    }

    /**
     * Remove the specified project from storage.
     *
     * DELETE /api/projects/{id}
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
