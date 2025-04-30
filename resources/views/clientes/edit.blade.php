@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white">{{ __('Editar Cliente') }}</div>

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

                    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label text-secondary">{{ __('Nombre') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label text-secondary">{{ __('Apellido') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido', $cliente->apellido) }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ci" class="form-label text-secondary">{{ __('C.I.') }}</label>
                            <div class="input-group">
                                @php
                                    // Ensure the CI is split correctly into the numeric part and extension
                                    $ci_number = preg_replace('/[A-Z]+$/', '', $cliente->ci); // Extract numeric part
                                    $ci_extension = preg_replace('/^\d+/', '', $cliente->ci); // Extract extension
                                @endphp
                                <input type="text" class="form-control bg-light border-secondary @error('ci') is-invalid @enderror" id="ci" name="ci" value="{{ old('ci', $ci_number) }}" required placeholder="Ej: 12345678" maxlength="8" pattern="\d{8}" title="Debe contener exactamente 8 dígitos">
                                <select id="ci-extension" class="form-select bg-light border-secondary @error('ci_extension') is-invalid @enderror" name="ci_extension" required>
                                    <option value="" disabled>{{ __('Seleccione un departamento') }}</option>
                                    <option value="LP" {{ old('ci_extension', $ci_extension) == 'LP' ? 'selected' : '' }}>LP</option>
                                    <option value="SC" {{ old('ci_extension', $ci_extension) == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="CB" {{ old('ci_extension', $ci_extension) == 'CB' ? 'selected' : '' }}>CB</option>
                                    <option value="OR" {{ old('ci_extension', $ci_extension) == 'OR' ? 'selected' : '' }}>OR</option>
                                    <option value="PT" {{ old('ci_extension', $ci_extension) == 'PT' ? 'selected' : '' }}>PT</option>
                                    <option value="CH" {{ old('ci_extension', $ci_extension) == 'CH' ? 'selected' : '' }}>CH</option>
                                    <option value="TJ" {{ old('ci_extension', $ci_extension) == 'TJ' ? 'selected' : '' }}>TJ</option>
                                    <option value="BE" {{ old('ci_extension', $ci_extension) == 'BE' ? 'selected' : '' }}>BE</option>
                                    <option value="PA" {{ old('ci_extension', $ci_extension) == 'PA' ? 'selected' : '' }}>PA</option>
                                </select>
                            </div>
                            @error('ci')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('ci_extension')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label text-secondary">{{ __('Teléfono') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label text-secondary">{{ __('Dirección') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}">
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label text-secondary">{{ __('Estado') }}</label>
                            <select class="form-select bg-light border-secondary @error('estado') is-invalid @enderror" id="estado" name="estado">
                                <option value="" disabled>{{ __('Seleccione un estado') }}</option>
                                <option value="Activo" {{ old('estado', $cliente->estado) == 'Activo' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                                <option value="Inactivo" {{ old('estado', $cliente->estado) == 'Inactivo' ? 'selected' : '' }}>{{ __('Inactivo') }}</option>
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-secondary">{{ __('Actualizar') }}</button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-light border-secondary">{{ __('Cancelar') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection