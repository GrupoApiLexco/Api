<?php

namespace App\Models;
// En el modelo User:
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory; // ¡Este trait es esencial!
    
    const STATUS_ACTIVE = true;
    const STATUS_INACTIVE = false;

    protected $fillable = [
        'name',
        'surnames',
        'email',
        'password',
        'status',
        'role'
    ];
}
