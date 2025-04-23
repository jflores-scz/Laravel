@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrarse') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Juan">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>El nombre debe contener solo letras y espacios.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido" class="col-md-4 col-form-label text-md-end">{{ __('Apellido') }}</label>

                            <div class="col-md-6">
                                <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" value="{{ old('apellido') }}" required placeholder="Ej: Pérez">
                                @error('apellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>El apellido debe contener solo letras y espacios.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ci" class="col-md-4 col-form-label text-md-end">{{ __('C.I.') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" required placeholder="Ej: 12345678" maxlength="8" pattern="\d{8}" title="Debe contener exactamente 8 dígitos">
                                    <select id="ci-extension" class="form-select" name="ci_extension" required>
                                        <option value="" disabled selected>Departamento</option>
                                        <option value="LP">LP</option>
                                        <option value="SC">SC</option>
                                        <option value="CB">CB</option>
                                        <option value="OR">OR</option>
                                        <option value="PT">PT</option>
                                        <option value="CH">CH</option>
                                        <option value="TJ">TJ</option>
                                        <option value="BE">BE</option>
                                        <option value="PA">PA</option>
                                        
                                    </select>
                                </div>
                                @error('ci')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>El C.I. debe contener 8 dígitos seguidos por una extensión.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>

                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required placeholder="Ej: 70000001">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>El teléfono debe contener un mínimo de 8 dígitos.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="direccion" class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>

                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required placeholder="Ej: Calle Falsa 123">
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>La dirección debe contener un máximo de 50 caracteres.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estado" class="col-md-4 col-form-label text-md-end">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <select id="estado" class="form-select @error('estado') is-invalid @enderror" name="estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <option value="Casado" {{ old('estado') == 'Casado' ? 'selected' : '' }}>Casado</option>
                                    <option value="Soltero" {{ old('estado') == 'Soltero' ? 'selected' : '' }}>Soltero</option>
                                    <option value="Otro" {{ old('estado') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Debe seleccionar un estado válido.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Ej: nombre@email.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Debe ingresar un correo electrónico válido y único.</strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>La contraseña debe tener entre 8 y 30 caracteres ( Letras, Números, -  .  _  * ) </strong>
                                    </span>
                                @enderror
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirme Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Repita la contraseña">
                                <div class="valid-feedback">¡Se ve bien!</div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
