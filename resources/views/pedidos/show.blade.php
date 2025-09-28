@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detalles de Solicitud de Préstamo') }}</div>

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

                    <h5 class="card-title">Libro: {{ $prestamo->book->titulo }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Autor: {{ $prestamo->book->autor }}</h6>
                    <p class="card-text"><strong>Cliente:</strong> {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}</p>
                    <p class="card-text"><strong>Razón:</strong> {{ $prestamo->razon }}</p>
                    <p class="card-text"><strong>Fecha de Solicitud:</strong> {{ $prestamo->fecha_inicio }}</p>
                    <p class="card-text"><strong>Fecha de Devolución Esperada:</strong> {{ $prestamo->fecha_final }}</p>
                    <p class="card-text"><strong>Estado de Solicitud:</strong> {{ $prestamo->estado_solicitud }}</p>
                    <p class="card-text"><strong>Estado de Devolución:</strong> {{ $prestamo->estado_devolucion ?? 'N/A' }}</p>

                    <hr>

                    @if ($prestamo->estado_solicitud == 'Pendiente')
                        <form action="{{ route('pedidos.approve', $prestamo->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success">Aprobar Préstamo</button>
                        </form>

                        <form action="{{ route('pedidos.admin_cancel', $prestamo->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de cancelar esta solicitud de préstamo?')">Cancelar Solicitud</button>
                        </form>
                    @else
                        <p class="text-info">Esta solicitud ya ha sido {{ $prestamo->estado_solicitud }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
