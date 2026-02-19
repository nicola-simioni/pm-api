<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;

// RESTful routes for Organizations, Projects, Tasks
Route::middleware('auth:sanctum')->group(function () {

    // All routes below require a valid Sanctum token

    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tasks', TaskController::class);

    // Only users with role "admin" can assign users to tasks
    Route::post('tasks/{task}/assign-users', [TaskController::class, 'assignUsers'])
        ->middleware('role:admin');
});