<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and prefixed with /api.
| 
| All routes return JSON responses.
|
*/

// RESTful routes for Organizations, Projects, Tasks
Route::apiResource('organizations', OrganizationController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);

Route::post('tasks/{task}/assign-users', [TaskController::class, 'assignUsers']);

