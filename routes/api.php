<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group( function()
{
    Route::post('register-employee', [AuthController::class , 'register_employee']);
    Route::post('register-supervisor', [AuthController::class , 'register_supervisor']);
    Route::post('login', [AuthController::class , 'login']);
    Route::post('logout', [AuthController::class , 'logout']);
    // supervisor
    Route::middleware((['auth:api' , 'role:supervisor']))->group(function(){

        // project 
        Route::post('create-project', [ProjectsController::class , 'create']);
        Route::post('view-project', [ProjectsController::class , 'view']);
        Route::post('update-project', [ProjectsController::class , 'update']);
        Route::post('delete-project', [ProjectsController::class , 'delete']);

        // task
        Route::post('create-task', [TasksController::class , 'create']);
        Route::post('view-task', [TasksController::class , 'view']);
        Route::post('update-task', [TasksController::class , 'update']);
        Route::post('delete-task', [TasksController::class , 'delete']);

    });
        // employee
    Route::middleware((['auth:api' , 'role:employee']))->group(function(){

        Route::post('view-task', [TasksController::class , 'view']);
        Route::post('submit-task', [TasksController::class , 'submit']);
    });

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
