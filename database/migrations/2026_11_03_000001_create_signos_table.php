<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabla de los 12 signos del zodiaco
    public function up(): void
    {
        Schema::create('signos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');                 // Ej: Aries
            $table->string('slug')->unique();         // nombre que usa la API: aries, taurus...
            $table->string('simbolo', 10)->nullable(); // ♈
            $table->string('fecha_inicio');           // Ej: 21 de marzo
            $table->string('fecha_fin');              // Ej: 19 de abril
            $table->string('elemento');               // Fuego, Tierra, Aire, Agua
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();     // ruta de la imagen subida
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signos');
    }
};
