@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar Cliente') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('clientes.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ci_number" class="form-label">C.I. Número</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('ci') is-invalid @enderror" id="ci_number" name="ci_number" value="{{ old('ci_number') }}" required>
                                <select class="form-select @error('ci') is-invalid @enderror" id="ci_extension" name="ci_extension" required>
                                    <option value="" disabled selected>Ext.</option>
                                    <option value="CH" {{ old('ci_extension') == 'CH' ? 'selected' : '' }}>CH</option>
                                    <option value="LP" {{ old('ci_extension') == 'LP' ? 'selected' : '' }}>LP</option>
                                    <option value="CB" {{ old('ci_extension') == 'CB' ? 'selected' : '' }}>CB</option>
                                    <option value="OR" {{ old('ci_extension') == 'OR' ? 'selected' : '' }}>OR</option>
                                    <option value="PT" {{ old('ci_extension') == 'PT' ? 'selected' : '' }}>PT</option>
                                    <option value="TJ" {{ old('ci_extension') == 'TJ' ? 'selected' : '' }}>TJ</option>
                                    <option value="SC" {{ old('ci_extension') == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="BN" {{ old('ci_extension') == 'BN' ? 'selected' : '' }}>BN</option>
                                    <option value="PA" {{ old('ci_extension') == 'PA' ? 'selected' : '' }}>PA</option>
                                </select>
                                @error('ci_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="Estudiante" {{ old('rol') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="Docente" {{ old('rol') == 'Docente' ? 'selected' : '' }}>Docente</option>
                                <option value="Personal" {{ old('rol') == 'Personal' ? 'selected' : '' }}>Personal</option>
                            </select>
                            @error('rol')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                                <option value="" disabled selected>Seleccione un estado</option>
                                <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
