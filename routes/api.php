<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('assistants')->group(function() {
    Route::post('', [AssistantController::class, 'create'])->middleware('auth:sanctum');
    Route::get('', [AssistantController::class, 'list'])->middleware('auth:sanctum');
    Route::delete('/{id}', [AssistantController::class, 'delete'])->middleware('auth:sanctum');
});

Route::prefix('chats')->group(function () {
    Route::post('', [ChatController::class, 'create'])->middleware('auth:sanctum');
    Route::get('', [ChatController::class, 'list'])->middleware('auth:sanctum');
    Route::delete('/{id}', [ChatController::class, 'delete'])->middleware('auth:sanctum');
    Route::get('/{id}', [ChatController::class, 'get'])->middleware('auth:sanctum');
});

Route::prefix('messages')->group(function () {
    Route::post('', [MessageController::class, 'create'])->middleware('auth:sanctum');
    Route::get('', [MessageController::class, 'list'])->middleware('auth:sanctum');
    Route::delete('/{id}', [MessageController::class, 'delete'])->middleware('auth:sanctum');
});

Route::prefix('/gpt')->group(function () {
    Route::get('/recommendation', [OpenAIController::class, 'recommendation']);
    Route::get('/startChat', [OpenAIController::class, 'startChat']);
});