<?php

namespace Tests\Feature;

use App\Models\Lectura;
use App\Models\Signo;
use App\Models\User;
use Database\Seeders\SignoSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HoroscopoWebTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SignoSeeder::class);
        config(['services.ninjas.key' => 'clave-prueba']);

        // Simulamos la API de API Ninjas para no hacer peticiones reales
        Http::fake([
            'api.api-ninjas.com/*' => Http::response([
                'date' => now()->toDateString(),
                'sign' => 'leo',
                'horoscope' => 'Hoy es un gran día para empezar algo nuevo.',
            ]),
        ]);
    }

    private function usuario(): User
    {
        return User::factory()->create(['signo_id' => Signo::where('slug', 'leo')->value('id')]);
    }

    public function test_la_landing_es_publica(): void
    {
        $this->get('/')->assertOk()->assertSee('Horóscopo Web')->assertSee('Escorpio');
    }

    public function test_las_rutas_privadas_piden_login(): void
    {
        foreach (['/dashboard', '/horoscopo', '/signos', '/lecturas', '/perfil', '/horoscopo/leo/pdf'] as $ruta) {
            $this->get($ruta)->assertRedirect('/login');
        }
    }

    public function test_registro_login_y_logout(): void
    {
        $this->post('/registro', [
            'name' => 'Luisa',
            'email' => 'luisa@example.com',
            'signo_id' => 1,
            'password' => 'secreto123',
            'password_confirmation' => 'secreto123',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->post('/login', ['email' => 'luisa@example.com', 'password' => 'malo'])->assertSessionHasErrors('email');
        $this->post('/login', ['email' => 'luisa@example.com', 'password' => 'secreto123'])->assertRedirect('/dashboard');
    }

    public function test_recuperar_contrasena(): void
    {
        Notification::fake();
        $user = $this->usuario();

        $this->post('/olvide-contrasena', ['email' => $user->email])->assertSessionHas('exito');

        Notification::assertSentTo($user, ResetPassword::class, function ($notificacion) use ($user) {
            $this->post('/restablecer-contrasena', [
                'token' => $notificacion->token,
                'email' => $user->email,
                'password' => 'nueva-clave-1',
                'password_confirmation' => 'nueva-clave-1',
            ])->assertRedirect('/login');

            return true;
        });

        $this->post('/login', ['email' => $user->email, 'password' => 'nueva-clave-1'])->assertRedirect('/dashboard');
    }

    public function test_dashboard_muestra_usuario_horoscopo_y_graficas(): void
    {
        $user = $this->usuario();

        $this->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Hoy es un gran día')
            ->assertSee('graficaUsuarios')
            ->assertSee('Cerrar sesión');
    }

    public function test_ver_horoscopo_de_otro_signo_guardarlo_y_descargar_pdf(): void
    {
        $user = $this->usuario();

        $this->actingAs($user)->get('/horoscopo/aries')->assertOk()->assertSee('Aries');
        $this->actingAs($user)->post('/horoscopo/aries/guardar')->assertSessionHas('exito');
        $this->assertDatabaseHas('lecturas', ['user_id' => $user->id, 'signo_id' => 1]);

        $respuesta = $this->actingAs($user)->get('/horoscopo/aries/pdf');
        $respuesta->assertOk()->assertHeader('content-type', 'application/pdf');
    }

    public function test_crud_de_signos_con_imagen(): void
    {
        Storage::fake('public');
        $user = $this->usuario();
        Signo::where('slug', 'pisces')->delete();

        $this->actingAs($user)->post('/signos', [
            'nombre' => 'Piscis',
            'slug' => 'pisces',
            'simbolo' => '♓',
            'fecha_inicio' => '19 de febrero',
            'fecha_fin' => '20 de marzo',
            'elemento' => 'Agua',
            'imagen' => UploadedFile::fake()->image('piscis.png'),
        ])->assertRedirect('/signos');

        $signo = Signo::where('slug', 'pisces')->first();
        Storage::disk('public')->assertExists($signo->imagen);

        $this->actingAs($user)->get('/signos')->assertOk()->assertSee('tablaSignos');
        $this->actingAs($user)->put("/signos/{$signo->id}", [
            'nombre' => 'Piscis editado', 'slug' => 'pisces', 'fecha_inicio' => 'a', 'fecha_fin' => 'b', 'elemento' => 'Agua',
        ])->assertRedirect('/signos');
        $this->assertDatabaseHas('signos', ['nombre' => 'Piscis editado']);

        $this->actingAs($user)->delete("/signos/{$signo->id}")->assertRedirect('/signos');
        $this->assertDatabaseMissing('signos', ['id' => $signo->id]);
    }

    public function test_crud_de_lecturas_y_que_otro_usuario_no_pueda_verlas(): void
    {
        $user = $this->usuario();

        $this->actingAs($user)->post('/lecturas', [
            'signo_id' => 5, 'fecha' => now()->toDateString(), 'texto' => 'Mi lectura', 'nota' => 'nota', 'favorita' => 1,
        ])->assertRedirect('/lecturas');

        $lectura = Lectura::first();
        $this->actingAs($user)->get('/lecturas')->assertOk()->assertSee('Mi lectura');
        $this->actingAs($user)->put("/lecturas/{$lectura->id}", [
            'signo_id' => 5, 'fecha' => now()->toDateString(), 'texto' => 'Editada',
        ])->assertRedirect('/lecturas');
        $this->assertFalse($lectura->fresh()->favorita);
        $this->actingAs($user)->get("/lecturas/{$lectura->id}/pdf")->assertHeader('content-type', 'application/pdf');

        $otro = User::factory()->create();
        $this->actingAs($otro)->get("/lecturas/{$lectura->id}")->assertForbidden();
        $this->actingAs($otro)->delete("/lecturas/{$lectura->id}")->assertForbidden();

        $this->actingAs($user)->delete("/lecturas/{$lectura->id}")->assertRedirect('/lecturas');
        $this->assertDatabaseCount('lecturas', 0);
    }

    public function test_editar_perfil_con_foto(): void
    {
        Storage::fake('public');
        $user = $this->usuario();

        $this->actingAs($user)->put('/perfil', [
            'name' => 'Nombre Nuevo',
            'signo_id' => 2,
            'foto' => UploadedFile::fake()->image('yo.jpg'),
        ])->assertRedirect('/perfil');

        $user->refresh();
        $this->assertSame('Nombre Nuevo', $user->name);
        Storage::disk('public')->assertExists($user->foto);
    }

    public function test_api_publica(): void
    {
        $this->getJson('/api/signos')->assertOk()->assertJsonCount(12, 'data');
        $this->getJson('/api/signos/leo')->assertOk()->assertJsonPath('data.nombre', 'Leo');
        $this->getJson('/api/horoscopo/leo')->assertOk()->assertJsonPath('horoscopo', 'Hoy es un gran día para empezar algo nuevo.');
        $this->getJson('/api/signos/noexiste')->assertNotFound();
    }
}
