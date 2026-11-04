<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Se encarga de pedirle el horóscopo a la API de API Ninjas
class HoroscopoService
{
    /**
     * Devuelve ['fecha' => ..., 'texto' => ...] o null si no se pudo obtener.
     * $signo es el nombre en inglés que pide la API (aries, taurus, ...).
     */
    public function obtener(string $signo): ?array
    {
        $clave = 'horoscopo_'.$signo.'_'.now()->toDateString();

        // Guardamos la respuesta en caché hasta medianoche para no gastar peticiones
        $resultado = Cache::get($clave);

        if (! $resultado) {
            $resultado = $this->pedirALaApi($signo);

            if ($resultado) {
                Cache::put($clave, $resultado, now()->endOfDay());
            }
        }

        return $resultado;
    }

    private function pedirALaApi(string $signo): ?array
    {
        $apiKey = config('services.ninjas.key');

        if (! $apiKey) {
            Log::warning('Falta NINJAS_API_KEY en el archivo .env');

            return null;
        }

        try {
            $respuesta = Http::withHeaders(['X-Api-Key' => $apiKey])
                ->timeout(10)
                ->get(config('services.ninjas.url'), ['zodiac' => $signo]);

            if ($respuesta->failed() || ! $respuesta->json('horoscope')) {
                Log::warning('Error de la API de horóscopo', ['status' => $respuesta->status(), 'body' => $respuesta->body()]);

                return null;
            }

            return [
                'fecha' => $respuesta->json('date') ?? now()->toDateString(),
                'texto' => $respuesta->json('horoscope'),
            ];
        } catch (\Throwable $e) {
            Log::error('No se pudo conectar con la API de horóscopo: '.$e->getMessage());

            return null;
        }
    }
}
