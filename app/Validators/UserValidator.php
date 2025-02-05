<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    /**
     * Valida los datos de inicio de sesión.
     */
    public static function validateLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email', // El email es obligatorio y debe ser válido.
            'password' => 'required|string' // La contraseña es obligatoria y debe ser un string.
        ]);
    }

    /**
     * Valida los datos para la creación de un usuario.
     *
     * @param array $data Datos proporcionados para crear el usuario.
     * @return \Illuminate\Contracts\Validation\Validator Retorna el validador con las reglas aplicadas.
     */
    public static function validateCreate(array $data)
    {
        // Verifica si la validación es precognitiva
        $isPrecognitive = isset($data['is_precognitive']) && $data['is_precognitive'];

        return Validator::make($data, [
            'name' => 'required|string|max:255', // Nombre obligatorio, debe ser un string y máximo de 255 caracteres.
            'surnames' => 'required|string|max:255', // Apellidos obligatorios, con las mismas restricciones.
            'email' => 'required|email|unique:users', // El email debe ser único en la tabla de usuarios.
            'password' => [
                'required',
                'string',
                'min:8',
                // Si es precognitiva, solo valida que tenga al menos 8 caracteres, de lo contrario valida que no esté comprometida
                $isPrecognitive ? 'nullable' : 'uncompromised', // Si es precognitiva, la contraseña solo necesita tener 8 caracteres y no es necesario validarla como "no comprometida"
            ],
            'role' => 'required|in:admin,vendedor,cliente' // El rol es obligatorio y debe ser uno de los valores permitidos.
        ]);
    }

    public static function validateToggleStatus(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|exists:users,id'
        ]);
    }

    /**
     * Valida los datos para la actualización de un usuario.
     *
     */
    public static function validateUpdate(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'user_id' => 'required|exists:users,id', // Asegura que el user_id sea válido
            'name' => 'sometimes|string|max:255',    // Solo permite actualizar el nombre
            'surnames' => 'sometimes|string|max:255', // Solo permite actualizar los apellidos
            'email' => 'sometimes|email|unique:users,email,' . $data['user_id'], // Solo permite actualizar el email
        ]);
    }

    /**
     * Valida la imagen subida por el usuario.
     *
     */
    public static function validateImage(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024', // Máximo 1MB, formatos permitidos: jpeg, png, jpg
        ]);
    }
}
