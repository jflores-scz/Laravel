@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Catálogo de Libros') }}
                    <form method="GET" action="{{ route('libros.catalogo') }}" class="d-inline-block float-end">
                        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Buscar por Título o ISBN" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                    </form>
                </div>

                <div class="card-body">
                    @if ($libros->isEmpty())
                        <p>No hay libros que coincidan con su búsqueda.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>ISBN</th>
                                    <th>Año</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($libros as $libro)
                                    <tr>
                                        <td>{{ $libro->titulo }}</td>
                                        <td>{{ $libro->autor }}</td>
                                        <td>{{ $libro->isbn }}</td>
                                        <td>{{ $libro->anio }}</td>
                                        <td>{{ $libro->descripcion }}</td>
                                        <td>
                                            @if ($libro->imagen_path)
                                                <img src="{{ asset($libro->imagen_path) }}" alt="Imagen del libro" width="50">
                                            @else
                                                N/A
                                            @endif
                                        </td>
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
