<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIController as OldAIController;
use App\Http\Controllers\Api\AIController as NewAIController;
use App\Http\Controllers\Api\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('ai')->group(function () {
    Route::post('/chat', [NewAIController::class, 'chat']);
    Route::post('/summarize', [NewAIController::class, 'summarize']);
    Route::apiResource('/tasks', TaskController::class); // 👈 CRUD endpoints
});
Route::post('/analyze', [OldAIController::class, 'analyze']);
//Route::post('/chat', [NewAIController::class, 'chat']);
//Route::post('/summarize', [NewAIController::class, 'summarize']);