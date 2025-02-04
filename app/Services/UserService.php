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
        // Se define la ruta donde se almacenará la imagen.
        $path = "user_image/user_{$user->id}.".$image->extension();

        // Se almacena la imagen en el disco 'public'.
        Storage::disk('public')->put($path, file_get_contents($image));

        // Se actualiza la ruta de la imagen en el perfil del usuario.
        $user->update(['image_path' => $path]);

        return $path;
    }
}
