<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(User::all());
        } catch (\Exception $e) {
            Log::error("Error fetching users: " . $e->getMessage());
            return $this->errorResponse('Error al obtener usuarios');
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = UserValidator::validateCreate($request->all());
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $user = $this->userService->createUser($request->all());
            return response()->json($user, 201);
            
        } catch (\Exception $e) {
            Log::error("User creation error: " . $e->getMessage());
            return $this->errorResponse('Error al crear usuario', 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        try {
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error("Error fetching user: " . $e->getMessage());
            return $this->errorResponse('Usuario no encontrado', 404);
        }
    }

    public function update(Request $request): JsonResponse
{
    $validator = UserValidator::validateUpdate($request->all());
    
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $response = null;

    try {
        // Obtener el usuario
        $user = User::findOrFail($request->input('user_id'));

        // Filtrar los datos permitidos
        $allowedFields = ['name', 'surnames', 'email'];
        $updateData = array_intersect_key($request->all(), array_flip($allowedFields));

        // Capturar los cambios antes de guardar
        $changes = [];
        foreach ($updateData as $field => $value) {
            if ($user->$field != $value) {
                $changes[$field] = $value;
            }
        }

        // Si no hay cambios, retornar un mensaje
        if (empty($changes)) {
            $response = response()->json([
                'message' => 'No se realizaron cambios',
                'changes' => []
            ], 200);
        } else {
            // Aplicar los cambios
            $user->fill($changes);
            $user->save();

            // Retornar solo los campos modificados
            $response = response()->json([
                'message' => 'Usuario actualizado correctamente',
                'changes' => $changes
            ], 200);
        }
        
    } catch (\Exception $e) {
        Log::error("User update error: " . $e->getMessage());
        $response = $this->errorResponse('Error al actualizar usuario', 500);
    }

    return $response;
}

    public function toggleStatus(Request $request): JsonResponse
    {
        $validator = UserValidator::validateToggleStatus($request->all());
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $response = null;
    
        try {
            $user = User::findOrFail($request->input('user_id'));
            
            // Verificación adicional de permisos
            if (!$request->user()->isAdmin()) {
                $response = $this->errorResponse('Acción no autorizada', 403);
            } else {
                $updatedUser = $this->userService->toggleStatus($user);
                $response = response()->json($updatedUser);
            }
            
        } catch (\Exception $e) {
            Log::error("Status toggle error: " . $e->getMessage());
            $response = $this->errorResponse('Error al cambiar estado', 500);
        }
    
        return $response;
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $validator = UserValidator::validateImage($request->all());
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            // Subir la imagen usando el servicio
            $path = $this->userService->uploadImage($request->user(), $request->file('image'));
            
            // Retornar la ruta de la imagen
            return response()->json([
                'message' => 'Imagen subida correctamente',
                'path' => $path
            ]);
            
        } catch (\Exception $e) {
            Log::error("Image upload error: " . $e->getMessage());
            return $this->errorResponse('Error al subir imagen', 500);
        }
    }

    private function errorResponse(string $message, int $code = 500): JsonResponse
    {
        return response()->json([
            'error' => $message,
            'code' => $code
        ], $code);
    }
}
