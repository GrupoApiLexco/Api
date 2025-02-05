<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Crea un nuevo usuario en la base de datos.
     *
     */
    public function createUser(array $data): User
    {
        // Se encripta la contraseña antes de guardarla en la base de datos.
        $data['password'] = bcrypt($data['password']);
        
        // Se crea el usuario con los datos proporcionados.
        return User::create($data);
    }

    /**
     * Actualiza la información de un usuario existente.
     *
     */public function updateUser(User $user, array $data): User
    {
    // Solo actualiza los campos proporcionados en $data
    $user->fill($data);
    $user->save();

    return $user;
    }

    /**
     * Alterna el estado de un usuario entre activo e inactivo.
     *
     */
    public function toggleStatus(User $user): User
    {
        // Se cambia el estado actual del usuario (true <-> false).
        $user->update(['status' => !$user->status]);

        return $user;
    }

    /**
     * Sube una imagen de perfil para el usuario y actualiza su ruta en la base de datos.
     *
     */
    public function uploadImage(User $user, $image): string
    {
        // Eliminar la imagen anterior si existe
        if ($user->image_path && Storage::exists($user->image_path)) {
            Storage::delete($user->image_path);
        }
    
        // Generar el nombre del archivo
        $extension = $image->getClientOriginalExtension(); // Obtener la extensión del archivo
        $filename = 'user_' . $user->id . '.' . $extension; // Formato: user_<id>.<extensión>
    
        // Guardar la imagen en la ruta especificada
        $path = $image->storeAs('public/user_image', $filename);
    
        // Actualizar la ruta de la imagen en el usuario
        $user->image_path = $path;
        $user->save();
    
        // Retornar la ruta relativa de la imagen
        return str_replace('public/', 'storage/', $path);
    }
}
