@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white">{{ __('Editar Almacén') }}</div>

                <div class="card-body bg-light">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('almacenes.update', ['almacene' => $almacen->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="sector" class="form-label text-secondary">{{ __('Sector') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('sector') is-invalid @enderror" id="sector" name="sector" value="{{ old('sector', $almacen->sector) }}" required pattern="[A-Z]" title="Debe ser una sola letra mayúscula (A-Z)">
                            @error('sector')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pasillo" class="form-label text-secondary">{{ __('Pasillo') }}</label>
                            <input type="number" class="form-control bg-light border-secondary @error('pasillo') is-invalid @enderror" id="pasillo" name="pasillo" value="{{ old('pasillo', $almacen->pasillo) }}" required min="1" max="10" title="Debe ser un número entre 1 y 10">
                            @error('pasillo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="numero" class="form-label text-secondary">{{ __('Número') }}</label>
                            <input type="number" class="form-control bg-light border-secondary @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $almacen->numero) }}" required min="1" max="999" title="Debe ser un número entre 1 y 999">
                            @error('numero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="capacidad" class="form-label text-secondary">{{ __('Capacidad en metros') }}</label>
                            <div class="input-group">
                                @php
                                    $capacidad = explode('x', $almacen->capacidad);
                                    $capacidad_width = $capacidad[0] ?? '';
                                    $capacidad_height = $capacidad[1] ?? '';
                                @endphp
                                <input type="number" class="form-control @error('capacidad_width') is-invalid @enderror" id="capacidad_width" name="capacidad_width" value="{{ old('capacidad_width', $capacidad_width) }}" required placeholder="Largo" min="1">
                                <span class="input-group-text">x</span>
                                <input type="number" class="form-control @error('capacidad_height') is-invalid @enderror" id="capacidad_height" name="capacidad_height" value="{{ old('capacidad_height', $capacidad_height) }}" required placeholder="Ancho" min="1">
                            </div>
                            @error('capacidad_width')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('capacidad_height')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label text-secondary">{{ __('Tipo') }}</label>
                            <select class="form-select bg-light border-secondary @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="" disabled>{{ __('Seleccione el tipo') }}</option>
                                <option value="Aclimatado" {{ old('tipo', $almacen->tipo) == 'Aclimatado' ? 'selected' : '' }}>Aclimatado</option>
                                <option value="Estandar" {{ old('tipo', $almacen->tipo) == 'Estandar' ? 'selected' : '' }}>Estandar</option>
                            </select>
                            @error('tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label text-secondary">{{ __('Estado') }}</label>
                            <select class="form-select bg-light border-secondary @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="" disabled>{{ __('Seleccione un estado') }}</option>
                                <option value="Activo" {{ old('estado', $almacen->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado', $almacen->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-secondary">{{ __('Actualizar') }}</button>
                        <a href="{{ route('almacenes.index') }}" class="btn btn-light border-secondary">{{ __('Cancelar') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection