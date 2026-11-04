<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    protected $table = 'lecturas';

    protected $fillable = [
        'user_id',
        'signo_id',
        'fecha',
        'texto',
        'nota',
        'favorita',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'favorita' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function signo()
    {
        return $this->belongsTo(Signo::class);
    }
}
