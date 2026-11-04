<?php

namespace Database\Seeders;

use App\Models\Signo;
use Illuminate\Database\Seeder;

class SignoSeeder extends Seeder
{
    public function run(): void
    {
        $signos = [
            ['Aries', 'aries', '♈', '21 de marzo', '19 de abril', 'Fuego', 'Valiente, enérgico y lleno de iniciativa.'],
            ['Tauro', 'taurus', '♉', '20 de abril', '20 de mayo', 'Tierra', 'Paciente, leal y amante de la tranquilidad.'],
            ['Géminis', 'gemini', '♊', '21 de mayo', '20 de junio', 'Aire', 'Curioso, comunicativo y muy adaptable.'],
            ['Cáncer', 'cancer', '♋', '21 de junio', '22 de julio', 'Agua', 'Sensible, protector y muy familiar.'],
            ['Leo', 'leo', '♌', '23 de julio', '22 de agosto', 'Fuego', 'Generoso, creativo y con mucha personalidad.'],
            ['Virgo', 'virgo', '♍', '23 de agosto', '22 de septiembre', 'Tierra', 'Ordenado, trabajador y detallista.'],
            ['Libra', 'libra', '♎', '23 de septiembre', '22 de octubre', 'Aire', 'Amable, justo y busca siempre el equilibrio.'],
            ['Escorpio', 'scorpio', '♏', '23 de octubre', '21 de noviembre', 'Agua', 'Intenso, apasionado y muy decidido.'],
            ['Sagitario', 'sagittarius', '♐', '22 de noviembre', '21 de diciembre', 'Fuego', 'Optimista, aventurero y amante de la libertad.'],
            ['Capricornio', 'capricorn', '♑', '22 de diciembre', '19 de enero', 'Tierra', 'Responsable, disciplinado y ambicioso.'],
            ['Acuario', 'aquarius', '♒', '20 de enero', '18 de febrero', 'Aire', 'Original, independiente y humanitario.'],
            ['Piscis', 'pisces', '♓', '19 de febrero', '20 de marzo', 'Agua', 'Soñador, compasivo e intuitivo.'],
        ];

        foreach ($signos as [$nombre, $slug, $simbolo, $inicio, $fin, $elemento, $descripcion]) {
            Signo::updateOrCreate(['slug' => $slug], [
                'nombre' => $nombre,
                'simbolo' => $simbolo,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
                'elemento' => $elemento,
                'descripcion' => $descripcion,
            ]);
        }
    }
}
