@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirmar Reserva de Libro') }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ $book->titulo }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $book->autor }}</h6>
                    <p class="card-text"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                    <p class="card-text"><strong>Año:</strong> {{ $book->anio }}</p>
                    <p class="card-text"><strong>Fecha de Inicio Sugerida:</strong> {{ $fechaInicio->format('Y-m-d') }}</p>
                    <p class="card-text">{{ $book->descripcion }}</p>

                    <hr>

                    <form method="POST" action="{{ route('prestamos.store') }}">
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
                            <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                            <a href="{{ route('books.catalogo') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
