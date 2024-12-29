<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Private routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/projects/create', [ProjectController::class, 'createProject'])->name('createProject')->middleware('isAdmin');
    Route::put('/projects/{projectId}', [ProjectController::class, 'updateProject'])->name('updateProject')->middleware('isAdmin');
    Route::delete('/projects/{projectId}', [ProjectController::class, 'deleteProject'])->name('deleteProject')->middleware('isAdmin');
    Route::get('/projects', [ProjectController::class, 'getProjects'])->name('getProjects');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
