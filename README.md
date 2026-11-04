# Horóscopo Web

Proyecto en Laravel para leer el horóscopo del día del usuario que inició sesión, ver el de otros signos,
guardar lecturas y descargarlas en PDF. Las lecturas vienen de la API de
[API Ninjas](https://api-ninjas.com/api/horoscope).

## Qué incluye

| Requisito | Dónde está |
|---|---|
| Vistas con plantillas maestras | `resources/views/layouts/` (`base`, `guest` y `panel`) |
| Base de datos PostgreSQL con migraciones | `database/migrations/` (tablas `signos`, `lecturas` y cambios a `users`) |
| Landing page | `/` → `resources/views/inicio.blade.php` |
| Registro y login propios | `/registro`, `/login` → `app/Http/Controllers/Auth/` |
| Recuperar contraseña | `/olvide-contrasena` → `PasswordController` |
| Rutas protegidas | `routes/web.php` (grupos `guest` y `auth`), y cada usuario solo ve sus lecturas |
| Dashboard con usuario activo y menú | `/dashboard` (inicio, horóscopos, listar lecturas, listar signos, editar perfil, cerrar sesión) |
| DataTables en dos tablas | `/signos` y `/lecturas` |
| Editar perfil | `/perfil` (nombre, signo y foto) |
| Gráficas (Chart.js) | En el dashboard: usuarios por signo y lecturas por signo |
| CRUD en dos tablas | `signos` (`SignoController`) y `lecturas` (`LecturaController`) |
| Consumir API de terceros | `app/Services/HoroscopoService.php` (API Ninjas) |
| API propia para externos | `routes/api.php` (ver abajo) |
| Informe PDF | Botón "Descargar PDF" en cada horóscopo y en cada lectura guardada |
| Subir imágenes | Foto de perfil del usuario e imagen de cada signo |

## Cómo instalarlo

Necesitas PHP 8.3 o superior, Composer y PostgreSQL.

1. Instalar las dependencias:
   ```bash
   composer install
   ```
2. Crear el archivo `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Crear una base de datos en PostgreSQL llamada `horoscopo_web` y poner tu usuario y contraseña en el `.env`:
   ```
   DB_CONNECTION=pgsql
   DB_DATABASE=horoscopo_web
   DB_USERNAME=postgres
   DB_PASSWORD=tu_contraseña
   ```
4. Crear una cuenta gratis en [api-ninjas.com](https://api-ninjas.com), copiar tu API key y ponerla en el `.env`:
   ```
   NINJAS_API_KEY=tu_api_key
   ```
5. Crear las tablas, los 12 signos y el usuario de prueba:
   ```bash
   php artisan migrate --seed
   ```
6. Crear el enlace para que se vean las imágenes subidas:
   ```bash
   php artisan storage:link
   ```
7. Encender el servidor:
   ```bash
   php artisan serve
   ```
   y abrir http://localhost:8000

**Usuario de prueba:** `test@example.com` / `password`

## Recuperar contraseña (correos)

Por defecto `MAIL_MAILER=log`, así que el correo con el enlace no se envía de verdad: queda guardado en
`storage/logs/laravel.log` y de ahí se puede copiar el enlace. Para enviarlo a un correo real (por ejemplo
con Gmail o [Mailtrap](https://mailtrap.io)) hay que cambiar las variables `MAIL_` del `.env`.

## API propia

Cualquier aplicación externa puede consumir estas rutas (máximo 60 peticiones por minuto):

| Método | Ruta | Respuesta |
|---|---|---|
| GET | `/api/signos` | Lista de los signos |
| GET | `/api/signos/{slug}` | Un signo, por ejemplo `/api/signos/leo` |
| GET | `/api/horoscopo/{slug}` | Horóscopo de hoy, por ejemplo `/api/horoscopo/leo` |

Ejemplo de respuesta de `/api/horoscopo/leo`:

```json
{
  "signo": "Leo",
  "slug": "leo",
  "fecha": "2026-11-03",
  "horoscopo": "Today brings fresh energy...",
  "fuente": "api-ninjas.com"
}
```

## Notas

- El horóscopo de cada signo se guarda en caché hasta la medianoche, para no gastar peticiones de la API.
- La API de API Ninjas responde en inglés, por eso el texto de las lecturas aparece en inglés.
- Si falta la API key o la API no responde, la página muestra un aviso en lugar de fallar.
- Para correr las pruebas: `php artisan test`
