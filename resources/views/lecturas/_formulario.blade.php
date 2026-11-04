{{-- Campos del formulario de lecturas (se usa en crear y editar) --}}
@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="signo_id" class="form-label">Signo</label>
        <select name="signo_id" id="signo_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach ($signos as $signo)
                <option value="{{ $signo->id }}" @selected(old('signo_id', $lectura->signo_id ?? auth()->user()->signo_id) == $signo->id)>
                    {{ $signo->simbolo }} {{ $signo->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control"
               value="{{ old('fecha', $lectura->fecha?->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>
    </div>
</div>

<div class="mb-3">
    <label for="texto" class="form-label">Texto de la lectura</label>
    <textarea name="texto" id="texto" rows="5" class="form-control" required>{{ old('texto', $lectura->texto) }}</textarea>
</div>

<div class="mb-3">
    <label for="nota" class="form-label">Mi nota (opcional)</label>
    <input type="text" name="nota" id="nota" class="form-control" value="{{ old('nota', $lectura->nota) }}"
           placeholder="Ej: ¡Hoy sí se cumplió!">
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="favorita" id="favorita" value="1" class="form-check-input" @checked(old('favorita', $lectura->favorita))>
    <label for="favorita" class="form-check-label">Marcar como favorita ⭐</label>
</div>

<button type="submit" class="btn btn-morado">Guardar</button>
<a href="{{ route('lecturas.index') }}" class="btn btn-secondary">Cancelar</a>
