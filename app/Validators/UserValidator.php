<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    public static function validateLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
    }

    public static function validateCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,vendedor,cliente'
        ]);
    }

    public static function validateUpdate(array $data)
    {
        return Validator::make($data, [
            'name' => 'sometimes|string|max:255',
            'surnames' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$data['id'],
            'password' => 'sometimes|string|min:8',
            'status' => 'sometimes|boolean'
        ]);
    }

    public static function validateImage(array $data)
    {
        return Validator::make($data, [
            'image' => 'required|image|mimes:jpeg,png|max:1024'
        ]);
    }
}
