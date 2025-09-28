@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear Préstamo para Libro: ') }}{{ $libro->titulo }}</div>

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

                    <form method="POST" action="{{ route('prestamos.admin_create_confirm') }}">
                        @csrf
                        <input type="hidden" name="libro_id" value="{{ $libro->id }}">

                        <div class="mb-3">
                            <label for="cliente_ci" class="form-label">C.I. del Cliente</label>
                            <input type="text" class="form-control @error('cliente_ci') is-invalid @enderror" id="cliente_ci" name="cliente_ci" value="{{ old('cliente_ci') }}" required>
                            @error('cliente_ci')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Buscar Cliente</button>
                            <a href="{{ route('libros.catalogo') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
