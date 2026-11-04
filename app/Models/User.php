<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'signo_id', 'foto'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Signo del usuario
    public function signo()
    {
        return $this->belongsTo(Signo::class);
    }

    // Lecturas que ha guardado el usuario
    public function lecturas()
    {
        return $this->hasMany(Lectura::class);
    }

    // URL de la foto de perfil (o una por defecto)
    public function fotoUrl(): string
    {
        if ($this->foto) {
            return asset('storage/'.$this->foto);
        }

        return asset('img/avatar.svg');
    }
}
