@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de Solicitudes de Préstamo') }}
                    <form method="GET" action="{{ route('pedidos.index') }}" class="d-inline-block float-end">
                        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Buscar por Título, Autor o Cliente" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Buscar</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($prestamos->isEmpty())
                        <p>{{ __('No hay solicitudes de préstamo pendientes.') }}</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Libro') }}</th>
                                    <th>{{ __('Cliente') }}</th>
                                    <th>{{ __('Fecha Inicio') }}</th>
                                    <th>{{ __('Fecha Final') }}</th>
                                    <th>{{ __('Estado Solicitud') }}</th>
                                    <th>{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prestamos as $prestamo)
                                    <tr>
                                        <td>{{ $prestamo->id }}</td>
                                        <td>{{ $prestamo->libro->titulo }} ({{ $prestamo->libro->autor }})</td>
                                        <td>{{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}</td>
                                        <td>{{ $prestamo->fecha_inicio }}</td>
                                        <td>{{ $prestamo->fecha_final }}</td>
                                        <td>{{ $prestamo->estado_solicitud }}</td>
                                        <td>
                                            <a href="{{ route('pedidos.show', $prestamo->id) }}" class="btn btn-info btn-sm">{{ __('Ver Detalles') }}</a>
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