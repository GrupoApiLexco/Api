<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function createUser(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function toggleStatus(User $user): User
    {
        $user->update(['status' => !$user->status]);
        return $user;
    }

    public function uploadImage(User $user, $image): string
    {
        $path = "user_image/user_{$user->id}.".$image->extension();
        Storage::disk('public')->put($path, file_get_contents($image));
        $user->update(['image_path' => $path]);
        return $path;
    }
}
