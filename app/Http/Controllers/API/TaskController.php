<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     *
     * GET /api/tasks
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Load tasks with their project and assigned users
        $tasks = Task::with('project', 'users')->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created task in storage.
     *
     * POST /api/tasks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'status' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($request->only('name', 'description', 'project_id', 'status', 'due_date'));

        return response()->json($task, 201);
    }

    /**
     * Display the specified task.
     *
     * GET /api/tasks/{id}
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $task = Task::with('project', 'users')->findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified task in storage.
     *
     * PUT /api/tasks/{id}
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
            'project_id' => 'sometimes|required|exists:projects,id',
            'status' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->only('name', 'description', 'project_id', 'status', 'due_date'));

        return response()->json($task);
    }

    /**
     * Remove the specified task from storage.
     *
     * DELETE /api/tasks/{id}
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }

    /**
     * Assign users to a task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUsers(Request $request, Task $task)
    {
        // Expecting an array of user IDs
        $userIds = $request->input('user_ids', []);

        // Sync users to task (replace existing)
        $task->users()->sync($userIds);

        return response()->json([
            'task_id' => $task->id,
            'assigned_users' => $task->users
        ]);
    }
}
