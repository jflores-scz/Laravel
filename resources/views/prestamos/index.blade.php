@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Mis Préstamos de Libros') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($prestamos->isEmpty())
                        <p>No tienes préstamos de libros registrados.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Devolución</th>
                                    <th>Fecha Final</th>
                                    <th>Estado Solicitud</th>
                                    <th>Estado Devolución</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prestamos as $prestamo)
                                    <tr>
                                        <td>{{ $prestamo->book->titulo }}</td>
                                        <td>{{ $prestamo->book->autor }}</td>
                                        <td>{{ $prestamo->fecha_inicio }}</td>
                                        <td>{{ $prestamo->fecha_devolucion ?? 'N/A' }}</td>
                                        <td>{{ $prestamo->fecha_final }}</td>
                                        <td>{{ $prestamo->estado_solicitud }}</td>
                                        <td>{{ $prestamo->estado_devolucion ?? 'N/A' }}</td>
                                        <td>
                                            @if ($prestamo->estado_solicitud == 'Pendiente')
                                                <form action="{{ route('prestamos.cancel', $prestamo->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de cancelar este préstamo?')">
                                                        Cancelar
                                                    </button>
                                                </form>
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
