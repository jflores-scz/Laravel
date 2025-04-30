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
                            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">{{ __('Apellido') }}</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ci" class="form-label">{{ __('C.I.') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('ci') is-invalid @enderror" id="ci" name="ci" value="{{ old('ci') }}" required placeholder="Ej: 12345678" maxlength="8" pattern="\d{8}" title="Debe contener exactamente 8 dígitos">
                                <select id="ci-extension" class="form-select @error('ci_extension') is-invalid @enderror" name="ci_extension" required>
                                    <option value="" disabled selected>{{ __('Departamento') }}</option>
                                    <option value="LP" {{ old('ci_extension') == 'LP' ? 'selected' : '' }}>LP</option>
                                    <option value="SC" {{ old('ci_extension') == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="CB" {{ old('ci_extension') == 'CB' ? 'selected' : '' }}>CB</option>
                                    <option value="OR" {{ old('ci_extension') == 'OR' ? 'selected' : '' }}>OR</option>
                                    <option value="PT" {{ old('ci_extension') == 'PT' ? 'selected' : '' }}>PT</option>
                                    <option value="CH" {{ old('ci_extension') == 'CH' ? 'selected' : '' }}>CH</option>
                                    <option value="TJ" {{ old('ci_extension') == 'TJ' ? 'selected' : '' }}>TJ</option>
                                    <option value="BE" {{ old('ci_extension') == 'BE' ? 'selected' : '' }}>BE</option>
                                    <option value="PA" {{ old('ci_extension') == 'PA' ? 'selected' : '' }}>PA</option>
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
                            <label for="telefono" class="form-label">{{ __('Teléfono') }}</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" required pattern="\d+" title="Solo se permiten números">
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">{{ __('Dirección') }}</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion') }}">
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">{{ __('Estado') }}</label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                                <option value="" disabled selected>{{ __('Seleccione un estado') }}</option>
                                <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>{{ __('Inactivo') }}</option>
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">{{ __('Registrar') }}</button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection