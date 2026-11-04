<?php

// Mensajes de validación en español (solo las reglas que usa el proyecto)
return [
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado no es válido.',
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'max' => [
        'file' => 'El archivo :attribute no debe pesar más de :max kilobytes.',
        'string' => 'El campo :attribute no debe tener más de :max caracteres.',
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',
    ],
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'unique' => 'Ese :attribute ya está registrado.',

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo',
        'password' => 'contraseña',
        'signo_id' => 'signo',
        'foto' => 'foto',
        'nombre' => 'nombre',
        'slug' => 'nombre en inglés (API)',
        'simbolo' => 'símbolo',
        'fecha_inicio' => 'fecha de inicio',
        'fecha_fin' => 'fecha de fin',
        'elemento' => 'elemento',
        'descripcion' => 'descripción',
        'imagen' => 'imagen',
        'fecha' => 'fecha',
        'texto' => 'texto',
        'nota' => 'nota',
    ],
];
