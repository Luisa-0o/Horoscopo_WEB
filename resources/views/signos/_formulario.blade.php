{{-- Campos del formulario de signos (se usa en crear y editar) --}}
@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $signo->nombre) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="slug" class="form-label">Nombre en inglés (para la API)</label>
        <select name="slug" id="slug" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach (['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'] as $opcion)
                <option value="{{ $opcion }}" @selected(old('slug', $signo->slug) == $opcion)>{{ $opcion }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 mb-3">
        <label for="simbolo" class="form-label">Símbolo</label>
        <input type="text" name="simbolo" id="simbolo" class="form-control" value="{{ old('simbolo', $signo->simbolo) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
        <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control" placeholder="21 de marzo"
               value="{{ old('fecha_inicio', $signo->fecha_inicio) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="fecha_fin" class="form-label">Fecha de fin</label>
        <input type="text" name="fecha_fin" id="fecha_fin" class="form-control" placeholder="19 de abril"
               value="{{ old('fecha_fin', $signo->fecha_fin) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="elemento" class="form-label">Elemento</label>
        <select name="elemento" id="elemento" class="form-select" required>
            @foreach (['Fuego', 'Tierra', 'Aire', 'Agua'] as $elemento)
                <option value="{{ $elemento }}" @selected(old('elemento', $signo->elemento) == $elemento)>{{ $elemento }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion', $signo->descripcion) }}</textarea>
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Imagen (opcional, máx. 2 MB)</label>
    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
    @if ($signo->imagen)
        <div class="mt-2">
            <small>Imagen actual:</small><br>
            <img src="{{ $signo->imagenUrl() }}" alt="imagen actual" class="imagen-signo">
        </div>
    @endif
</div>

<button type="submit" class="btn btn-morado">Guardar</button>
<a href="{{ route('signos.index') }}" class="btn btn-secondary">Cancelar</a>
