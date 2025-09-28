@extends('layouts.app')

@section('content')
<style>
    .fixed-height-title {
        height: 3em; /* Adjust as needed */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
        -webkit-box-orient: vertical;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Catálogo de Libros') }}
                    <form method="GET" action="{{ route('books.catalogo') }}" class="d-inline-block float-end">
                        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Buscar por Título o ISBN" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                    </form>
                </div>

                <div class="card-body">
                    @if ($books->isEmpty())
                        <p>No hay libros que coincidan con su búsqueda.</p>
                    @else
                        <div class="row">
                            @foreach ($books as $book)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        @if($book->portada)
                                            <img src="{{ asset($book->portada) }}" class="card-img-top" alt="{{ $book->titulo }}" style="height: 300px; object-fit: cover;">
                                        @else
                                            <div style="height: 300px; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                                                <span>Sin imagen</span>
                                            </div>
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fixed-height-title">{{ $book->titulo }}</h5>
                                            <p class="card-text"><strong>Autor:</strong> {{ $book->autor }}</p>
                                            <p class="card-text"><strong>Año:</strong> {{ $book->anio }}</p>
                                            <div class="mt-auto">
                                                @if (Session::has('cliente_id'))
                                                    <a href="{{ route('prestamos.create', ['book' => $book->id]) }}" class="btn btn-primary btn-sm">Reservar</a>
                                                @endif
                                                @auth
                                                    <a href="{{ route('prestamos.admin_create_form', ['book' => $book->id]) }}" class="btn btn-info btn-sm">Crear Préstamo</a>
                                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
