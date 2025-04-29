@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de Almacenes') }}
                    <form method="GET" action="{{ route('almacenes.index') }}" class="d-inline-block float-end">
                        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Capacidad o Tipo" value="{{ $query ?? '' }}">
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Buscar</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($almacenes->isEmpty())
                        <p>{{ __('No hay almacenes registrados.') }}</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Sector') }}</th>
                                    <th>{{ __('Pasillo') }}</th>
                                    <th>{{ __('Número') }}</th>
                                    <th>{{ __('Capacidad') }}</th>
                                    <th>{{ __('Tipo') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($almacenes as $almacen)
                                    <tr>
                                        <td>{{ $almacen->id }}</td>
                                        <td>{{ $almacen->sector }}</td>
                                        <td>{{ $almacen->pasillo }}</td>
                                        <td>{{ $almacen->numero }}</td>
                                        <td>{{ $almacen->capacidad ?? __('N/A') }}</td>
                                        <td>{{ $almacen->tipo }}</td>
                                        <td>{{ $almacen->estado }}</td>
                                        <td>
                                            <a href="{{ route('almacenes.edit', $almacen->id) }}" class="btn btn-outline-warning">{{ __('Editar') }}</a>
                                            <form action="{{ route('almacenes.destroy', $almacen->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('{{ __('¿Está seguro de eliminar este almacén?') }}')">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            @if (!$almacenes->isEmpty())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $almacenes->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection