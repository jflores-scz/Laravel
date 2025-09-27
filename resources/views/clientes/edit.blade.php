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

                        @php
                            $ci_number = substr($cliente->ci, 0, -2);
                            $ci_extension = substr($cliente->ci, -2);
                        @endphp
                        <div class="mb-3">
                            <label for="ci_number" class="form-label text-secondary">{{ __('C.I. Número') }}</label>
                            <div class="input-group">
                                <input type="number" class="form-control bg-light border-secondary @error('ci_number') is-invalid @enderror" id="ci_number" name="ci_number" value="{{ old('ci_number', $ci_number) }}" required>
                                <select class="form-select bg-light border-secondary @error('ci_extension') is-invalid @enderror" id="ci_extension" name="ci_extension" required>
                                    <option value="" disabled>Ext.</option>
                                    <option value="CH" {{ old('ci_extension', $ci_extension) == 'CH' ? 'selected' : '' }}>CH</option>
                                    <option value="LP" {{ old('ci_extension', $ci_extension) == 'LP' ? 'selected' : '' }}>LP</option>
                                    <option value="CB" {{ old('ci_extension', $ci_extension) == 'CB' ? 'selected' : '' }}>CB</option>
                                    <option value="OR" {{ old('ci_extension', $ci_extension) == 'OR' ? 'selected' : '' }}>OR</option>
                                    <option value="PT" {{ old('ci_extension', $ci_extension) == 'PT' ? 'selected' : '' }}>PT</option>
                                    <option value="TJ" {{ old('ci_extension', $ci_extension) == 'TJ' ? 'selected' : '' }}>TJ</option>
                                    <option value="SC" {{ old('ci_extension', $ci_extension) == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="BN" {{ old('ci_extension', $ci_extension) == 'BN' ? 'selected' : '' }}>BN</option>
                                    <option value="PA" {{ old('ci_extension', $ci_extension) == 'PA' ? 'selected' : '' }}>PA</option>
                                </select>
                                @error('ci_number')
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
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary">{{ __('Correo Electrónico') }}</label>
                            <input type="email" class="form-control bg-light border-secondary @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rol" class="form-label text-secondary">{{ __('Rol') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('rol') is-invalid @enderror" id="rol" name="rol" value="{{ old('rol', $cliente->rol) }}" required>
                            @error('rol')
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