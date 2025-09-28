@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de Libros') }}
                    <form method="GET" action="{{ route('books.index') }}" class="d-inline-block float-end">
                        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Buscar por Título o ISBN" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Agregar Libro</a>

                    @if ($books->isEmpty())
                        <p>No hay books registrados.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>ISBN</th>
                                    <th>Año</th>
                                    <th>Portada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $libro)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->titulo }}</td>
                                        <td>{{ $book->autor }}</td>
                                        <td>{{ $book->isbn }}</td>
                                        <td>{{ $book->anio }}</td>
                                        <td>
                                            @if ($book->portada)
                                                <img src="{{ asset($book->portada) }}" alt="Portada del libro" width="50">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este libro?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $books->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection