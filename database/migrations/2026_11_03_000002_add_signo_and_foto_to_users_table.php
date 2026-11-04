<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Agrega el signo y la foto de perfil a los usuarios
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('signo_id')->nullable()->after('email')
                ->constrained('signos')->nullOnDelete();
            $table->string('foto')->nullable()->after('signo_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('signo_id');
            $table->dropColumn('foto');
        });
    }
};
