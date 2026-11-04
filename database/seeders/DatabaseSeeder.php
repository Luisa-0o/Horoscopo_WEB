<?php

namespace Database\Seeders;

use App\Models\Signo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Primero los 12 signos
        $this->call(SignoSeeder::class);

        // Usuario de prueba (contraseña: password)
        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Usuario de Prueba',
            'password' => 'password',
            'signo_id' => Signo::where('slug', 'leo')->value('id'),
        ]);
    }
}
