@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Confirmar Creación de Préstamo') }}</div>

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

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Detalles del Cliente</h5>
                            <p><strong>Nombre:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                            <p><strong>CI:</strong> {{ $cliente->ci }}</p>
                            <p><strong>Email:</strong> {{ $cliente->email }}</p>
                            <p><strong>Rol:</strong> {{ $cliente->rol }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Detalles del Libro</h5>
                            <p><strong>Título:</strong> {{ $book->titulo }}</p>
                            <p><strong>Autor:</strong> {{ $book->autor }}</p>
                            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p><strong>Año:</strong> {{ $book->anio }}</p>
                            <p><strong>Fecha de Inicio Sugerida:</strong> {{ $fechaInicio->format('Y-m-d') }}</p>
                            <p><strong>Descripción:</strong> {{ $book->descripcion }}</p>
                            @if ($book->portada)
                                <img src="{{ asset($book->portada) }}" alt="Portada del libro" width="100">
                            @endif
                        </div>
                    </div>

                    <hr>

                    <form method="POST" action="{{ route('prestamos.admin_store') }}">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

                        <div class="mb-3">
                            <label for="razon" class="form-label">Motivo de la Solicitud</label>
                            <input type="text" class="form-control @error('razon') is-invalid @enderror" id="razon" name="razon" value="{{ old('razon') }}" required>
                            @error('razon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_final" class="form-label">Fecha de Devolución</label>
                            <input type="date" class="form-control @error('fecha_final') is-invalid @enderror" id="fecha_final" name="fecha_final" value="{{ old('fecha_final') }}" required>
                            @error('fecha_final')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Confirmar Préstamo</button>
                            <a href="{{ route('prestamos.admin_create_form', ['book' => $book->id]) }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
