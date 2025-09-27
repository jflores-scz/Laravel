@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de Libros') }}
                    <form method="GET" action="{{ route('libros.index') }}" class="d-inline-block float-end">
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

                    <a href="{{ route('libros.create') }}" class="btn btn-primary mb-3">Agregar Libro</a>

                    @if ($libros->isEmpty())
                        <p>No hay libros registrados.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>ISBN</th>
                                    <th>Año</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($libros as $libro)
                                    <tr>
                                        <td>{{ $libro->id }}</td>
                                        <td>{{ $libro->titulo }}</td>
                                        <td>{{ $libro->autor }}</td>
                                        <td>{{ $libro->isbn }}</td>
                                        <td>{{ $libro->anio }}</td>
                                        <td>
                                            @if ($libro->imagen_path)
                                                <img src="{{ asset($libro->imagen_path) }}" alt="Imagen del libro" width="50">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('libros.edit', $libro->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" style="display: inline-block;">
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
                        {{ $libros->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection