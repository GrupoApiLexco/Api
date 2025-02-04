
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

$version = config('app.api_version'); // Se obtiene la versión de la API desde la configuración

//  RUTAS PÚBLICAS (No requieren autenticación)
Route::post('/test', [AuthController::class, 'test']); // Endpoint para verificar la API
Route::post('/login', [AuthController::class, 'login']); // Endpoint de autenticación

//  RUTAS PROTEGIDAS (Requieren autenticación con Sanctum y validación de estado)
Route::middleware(['auth:sanctum', 'check_active'])->group(function () use ($version) {
    
    //  RUTAS DE ADMINISTRACIÓN (Acceso restringido solo a administradores)
    Route::prefix("$version/admin")
        ->middleware(AdminMiddleware::class) // Middleware personalizado para admins
        ->group(function () {
            Route::post('/users/add', [UserController::class, 'store']); // Crear usuario
            Route::get('/users', [UserController::class, 'index']); // Listar usuarios
            Route::post('/users/{user}', [UserController::class, 'show']); // Ver detalles de un usuario
            Route::post('/users/delete{user}', [UserController::class, 'toggleStatus']); // Cambiar estado del usuario
        });

    //  RUTAS GENERALES PARA USUARIOS (Accesibles para cualquier usuario autenticado)
    Route::prefix($version)->group(function () {
        Route::post('/users/update', [UserController::class, 'update']); // Actualizar usuario
        Route::post('/users/image', [UserController::class, 'uploadImage']); // Subir imagen de usuario
        
        //  SERVICIO PARA OBTENER IMÁGENES DE USUARIOS
        Route::get('/users/image/{filename}', function ($filename) {
            return response()->file(storage_path("app/public/user_image/$filename"));
        })->where('filename', 'user_\d+\.(png|jpg|jpeg)'); // Validación para asegurar nombres de archivo correctos
    });
});
