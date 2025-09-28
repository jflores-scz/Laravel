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
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Buscar</button>
                    </form>
                    <a href="{{ route('libros.create') }}" class="btn btn-success btn-sm float-end me-2">{{ __('Registrar Libro') }}</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($libros->isEmpty())
                        <p>{{ __('No hay libros registrados.') }}</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Título') }}</th>
                                    <th>{{ __('Autor') }}</th>
                                    <th>{{ __('ISBN') }}</th>
                                    <th>{{ __('Año') }}</th>
                                    <th>{{ __('Descripción') }}</th>
                                    <th>{{ __('Acciones') }}</th>
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
                                        <td>{{ $libro->descripcion }}</td>
                                        <td>
                                            <a href="{{ route('libros.edit', $libro->id) }}" class="btn btn-warning btn-sm">{{ __('Editar') }}</a>
                                            <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('¿Está seguro de eliminar este libro?') }}')">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $libros->links() }}
                        </div>
                        @if (!$libros->isEmpty())
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $libros->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection