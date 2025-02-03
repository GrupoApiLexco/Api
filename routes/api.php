<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

$version = config('app.api_version');

// Rutas públicas
Route::post('/test', [AuthController::class, 'test']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware(['auth:sanctum', 'check_active'])->group(function () use ($version) {
    // Rutas de administración
    Route::prefix("$version/admin")
        ->middleware(AdminMiddleware::class)
        ->group(function () {
            Route::post('/users/add', [UserController::class, 'store']);
            Route::get('/users', [UserController::class, 'index']);
            Route::post('/users/{user}', [UserController::class, 'show']);
            Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus']);
        });

    // Rutas generales de usuario
    Route::prefix($version)->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::post('/users/image', [UserController::class, 'uploadImage']);
        Route::get('/users/image/{filename}', function ($filename) {
            return response()->file(storage_path("app/public/user_image/$filename"));
        })->where('filename', 'user_\d+\.(png|jpg|jpeg)'); // Validación de nombre de archivo
    });
});

