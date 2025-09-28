@extends('layouts.app')

@section('content')
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
                        <p>No hay books que coincidan con su búsqueda.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>ISBN</th>
                                    <th>Año</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr>
                                        <td>{{ $book->titulo }}</td>
                                        <td>{{ $book->autor }}</td>
                                        <td>{{ $book->isbn }}</td>
                                        <td>{{ $book->anio }}</td>
                                        <td>{{ $book->descripcion }}</td>
                                        <td>
                                            @if (Session::has('cliente_id'))
                                                <a href="{{ route('prestamos.create', ['book' => $book->id]) }}" class="btn btn-primary btn-sm">Reservar</a>
                                            @endif
                                        </td>
                                        @auth
                                            <td>
                                                <a href="{{ route('prestamos.admin_create_form', ['book' => $book->id]) }}" class="btn btn-info btn-sm">Crear Préstamo</a>
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
