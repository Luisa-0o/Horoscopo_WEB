<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Lecturas de horóscopo que cada usuario guarda
    public function up(): void
    {
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('signo_id')->constrained('signos')->cascadeOnDelete();
            $table->date('fecha');
            $table->text('texto');                 // texto del horóscopo
            $table->string('nota')->nullable();    // nota personal del usuario
            $table->boolean('favorita')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturas');
    }
};
