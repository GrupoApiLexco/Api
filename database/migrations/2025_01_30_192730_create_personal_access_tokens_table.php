<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crea la tabla 'personal_access_tokens' con los siguientes campos
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' autoincremental como clave primaria
            $table->morphs('tokenable'); // Crea las columnas 'tokenable_type' y 'tokenable_id' para establecer una relación polimórfica
            $table->string('name'); // Crea una columna 'name' para almacenar el nombre del token
            $table->string('token', 64)->unique(); // Crea una columna 'token' con un límite de 64 caracteres y la hace única
            $table->text('abilities')->nullable(); // Crea una columna 'abilities' para almacenar las habilidades asociadas al token, que puede ser nula
            $table->timestamp('last_used_at')->nullable(); // Crea una columna 'last_used_at' para almacenar la fecha y hora de la última vez que se usó el token, que puede ser nula
            $table->timestamp('expires_at')->nullable(); // Crea una columna 'expires_at' para almacenar la fecha y hora de expiración del token, que puede ser nula
            $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at' para el seguimiento de la creación y actualización del registro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabla 'personal_access_tokens' si existe
        Schema::dropIfExists('personal_access_tokens');
    }
};
