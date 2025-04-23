@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar Almacén') }}</div>

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

                    <form method="POST" action="{{ route('almacenes.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="sector" class="form-label">{{ __('Sector') }}</label>
                            <input type="text" class="form-control @error('sector') is-invalid @enderror" id="sector" name="sector" value="{{ old('sector') }}" required>
                            @error('sector')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pasillo" class="form-label">{{ __('Pasillo') }}</label>
                            <input type="text" class="form-control @error('pasillo') is-invalid @enderror" id="pasillo" name="pasillo" value="{{ old('pasillo') }}" required>
                            @error('pasillo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="numero" class="form-label">{{ __('Número') }}</label>
                            <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero') }}" required>
                            @error('numero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="capacidad" class="form-label">{{ __('Capacidad en metros') }}</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('capacidad_width') is-invalid @enderror" id="capacidad_width" name="capacidad_width" value="{{ old('capacidad_width') }}" required placeholder="Largo" min="1">
                                <span class="input-group-text">x</span>
                                <input type="number" class="form-control @error('capacidad_height') is-invalid @enderror" id="capacidad_height" name="capacidad_height" value="{{ old('capacidad_height') }}" required placeholder="Ancho" min="1">
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
                            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="" disabled selected>Seleccione el tipo</option>
                                <option value="Refrigerado">Refrigerado</option>
                                <option value="Estandar">Estandar</option>
                            </select>
                            @error('tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">{{ __('Estado') }}</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="Inactivo" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Registrar') }}</button>
                        <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection