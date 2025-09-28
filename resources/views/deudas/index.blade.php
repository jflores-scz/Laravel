@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Mis Multas') }}</div>

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

                    @if ($deudas->isEmpty())
                        <p>No tienes multas registradas.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Préstamo</th>
                                    <th>Libro</th>
                                    <th>Fecha Inicio Préstamo</th>
                                    <th>Fecha Final Préstamo</th>
                                    <th>Fecha Pagada</th>
                                    <th>Estado Multa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deudas as $deuda)
                                    <tr>
                                        <td>{{ $deuda->prestamo->id }}</td>
                                        <td>{{ $deuda->prestamo->libro->titulo }} ({{ $deuda->prestamo->libro->autor }})</td>
                                        <td>{{ $deuda->prestamo->fecha_inicio }}</td>
                                        <td>{{ $deuda->prestamo->fecha_final }}</td>
                                        <td>{{ $deuda->fecha_pagada ?? 'Pendiente' }}</td>
                                        <td>{{ $deuda->estado }}</td>
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
