@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Cliente Seleccionado</h3>
    <p>ID del Cliente: {{ session('cliente_id') }}</p>

    <h3>Seleccione el Almacen</h3>

    <!-- Buscar -->
    <form method="POST" action="{{ route('pedidos.luego') }}" class="mb-3">
        @csrf
        <input type="hidden" name="cliente_id" value="{{ session('cliente_id') }}">
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="query" class="form-control" placeholder="Buscar por Número, Capacidad o Tipo" value="{{ request('query') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Buscar') }}</button>
            </div>
        </div>
    </form>

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
                @if ($almacen->estado !== 'Oculto')
                <tr>
                    <td>{{ $almacen->id }}</td>
                    <td>{{ $almacen->sector }}</td>
                    <td>{{ $almacen->pasillo }}</td>
                    <td>{{ $almacen->numero }}</td>
                    <td>{{ $almacen->capacidad ?? __('N/A') }}</td>
                    <td>{{ $almacen->tipo }}</td>
                    <td>{{ $almacen->estado }}</td>
                    <td>
                        <form action="{{ route('pedidos.final') }}" method="POST">
                            @csrf
                            <input type="hidden" name="almacen_id" value="{{ $almacen->id }}">
                            <button type="submit" class="btn btn-primary" {{ $almacen->estado === 'Activo' ? 'disabled' : '' }}>
                                Seleccionar
                            </button>
                        </form>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection