<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens; //  Habilita la autenticación con tokens de API (Sanctum).
use Illuminate\Foundation\Auth\User as Authenticatable; //  Extiende la funcionalidad de usuario autenticable.
use Illuminate\Database\Eloquent\Factories\HasFactory; //  Permite generar usuarios con `User::factory()`.

class User extends Authenticatable
{
    //  Usa los traits necesarios para la autenticación y generación de datos
    use HasApiTokens, HasFactory;

    /**
     *  Constantes para definir el estado del usuario
     */
    const STATUS_ACTIVE = true;   //  Usuario activo
    const STATUS_INACTIVE = false; //  Usuario inactivo

    /**
     *  Constantes para definir los roles de usuario
     */
    const ROLE_ADMIN = 'admin';     //  Administrador
    const ROLE_CLIENT = 'cliente';  //  Cliente
    const ROLE_VENDOR = 'vendedor'; //  Vendedor

    /**
     *  Campos que pueden ser llenados masivamente con `create()` o `update()`
     * Esto protege contra asignaciones masivas no deseadas.
     */
    protected $fillable = [
        'name',        //  Nombre del usuario
        'surnames',    //  Apellidos del usuario
        'email',       //  Correo electrónico único
        'password',    //  Contraseña (debe ser encriptada)
        'status',      //  Estado del usuario (activo/inactivo)
        'role',        //  Rol del usuario (admin, cliente, vendedor)
        'image_path'   //  Ruta de la imagen de perfil
    ];

    /**
     *  Campos ocultos cuando se serializa el modelo a JSON
     * Protege datos sensibles como la contraseña y el token de sesión.
     */
    protected $hidden = [
        'password',         //  Oculta la contraseña en respuestas JSON
        'remember_token',   //  Oculta el token de sesión
    ];

    /**
     *  Conversión de atributos a tipos de datos específicos
     * - `status`: Se maneja como un booleano (true/false)
     * - `email_verified_at`: Se trata como una fecha
     */
    protected $casts = [
        'status' => 'boolean', //  Convierte el estado a booleano automáticamente
        'email_verified_at' => 'datetime', //  Maneja `email_verified_at` como fecha
    ];

    /**
     *  Relación con la imagen del usuario (Ejemplo de relación polimórfica)
     * Este método se podría descomentar si se maneja imágenes en una tabla separada.
     */
    //*public function image()
   // {
    //return $this->morphOne(Image::class, 'imageable');
    //}
}


