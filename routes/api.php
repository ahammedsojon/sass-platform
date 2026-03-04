<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/users', [AuthController::class, 'users']);
});


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::middleware('role:Admin,Manager')->post('/projects', [ProjectController::class, 'store']);
    Route::middleware('role:Admin,Manager')->put('/projects/{project}', [ProjectController::class, 'update']);
    Route::middleware('role:Admin')->delete('/projects/{project}', [ProjectController::class, 'destroy']);

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::middleware('role:Admin,Manager')->post('/tasks', [TaskController::class, 'store']);
    Route::middleware('role:Admin,Manager')->put('/tasks/{task}', [TaskController::class, 'update']);
    Route::middleware('role:Admin')->delete('/tasks/{task}', [TaskController::class, 'destroy']);

    Route::middleware('role:Admin')->get('/dashboard/stats', [DashboardController::class, 'stats']);
});
