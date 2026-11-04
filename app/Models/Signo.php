<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signo extends Model
{
    protected $table = 'signos';

    protected $fillable = [
        'nombre',
        'slug',
        'simbolo',
        'fecha_inicio',
        'fecha_fin',
        'elemento',
        'descripcion',
        'imagen',
    ];

    // Usuarios que tienen este signo
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Lecturas guardadas de este signo
    public function lecturas()
    {
        return $this->hasMany(Lectura::class);
    }

    public function imagenUrl(): ?string
    {
        return $this->imagen ? asset('storage/'.$this->imagen) : null;
    }
}
