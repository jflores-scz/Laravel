@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Gestión de Devoluciones de Préstamos') }}</div>

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
                        <p>No hay préstamos Aprobados o Atrasados para gestionar.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Libro</th>
                                    <th>Cliente</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Final (Esperada)</th>
                                    <th>Estado Solicitud</th>
                                    <th>Acciones</th>
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
                                            <form action="{{ route('prestamos.return', $prestamo->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Está seguro de marcar este préstamo como devuelto?')">
                                                    Marcar como Devuelto
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
        </div>
    </div>
</div>
@endsection
