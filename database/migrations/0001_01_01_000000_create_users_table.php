<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//  Se crea una migración anónima (clase sin nombre)
return new class extends Migration
{
    /**
     * Método que se ejecuta cuando se aplica la migración.
     * Crea la tabla "users" con sus respectivas columnas.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); //  Clave primaria autoincremental (BIGINT)
            $table->string('name'); //  Nombre del usuario (VARCHAR)
            $table->string('surnames'); //  Apellidos del usuario (VARCHAR)
            $table->string('email')->unique(); //  Email único para autenticación
            $table->string('password'); //  Contraseña encriptada del usuario
            $table->string('image_path')->nullable(); //  Ruta opcional de la imagen del usuario
            $table->boolean('status')->default(true); //  Estado del usuario (activo por defecto)
            $table->enum('role', ['admin', 'vendedor', 'cliente'])->default('cliente'); //  Rol del usuario con valores específicos
            $table->timestamps(); //  Campos "created_at" y "updated_at"
        });
    }

    /**
     * Método que se ejecuta cuando se revierte la migración.
     * Elimina la tabla "users" si existe.
     */
    public function down()
    {
        Schema::dropIfExists('users'); //  Borra la tabla si existe
    }
};
