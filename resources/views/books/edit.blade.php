@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white">{{ __('Editar Libro') }}</div>

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

                    <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="titulo" class="form-label text-secondary">{{ __('Título') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $book->titulo) }}" required>
                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="autor" class="form-label text-secondary">{{ __('Autor') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('autor') is-invalid @enderror" id="autor" name="autor" value="{{ old('autor', $book->autor) }}" required>
                            @error('autor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label text-secondary">{{ __('ISBN') }}</label>
                            <input type="text" class="form-control bg-light border-secondary @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                            @error('isbn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="anio" class="form-label text-secondary">{{ __('Año') }}</label>
                            <input type="number" class="form-control bg-light border-secondary @error('anio') is-invalid @enderror" id="anio" name="anio" value="{{ old('anio', $book->anio) }}" required>
                            @error('anio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label text-secondary">{{ __('Descripción') }}</label>
                            <textarea class="form-control bg-light border-secondary @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $book->descripcion) }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="portada" class="form-label">Portada</label>
                            <input type="file" class="form-control @error('portada') is-invalid @enderror" id="portada" name="portada">
                            @error('portada')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-secondary">{{ __('Actualizar') }}</button>
                        <a href="{{ route('books.catalogo') }}" class="btn btn-light border-secondary">{{ __('Cancelar') }}</a>
                    </form>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block; float: right;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este libro?')">
                            {{ __('Eliminar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection