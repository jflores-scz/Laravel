@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Seleccionar Cliente</h3>

    <!-- Buscar -->
    <form method="GET" action="{{ route('pedidos.create') }}" class="mb-3">
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="query" class="form-control" placeholder="Buscar por CI o Nombre" value="{{ request('query') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Buscar') }}</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>CI</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                @if ($cliente->estado !== 'Oculto')
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->apellido }}</td>
                    <td>{{ $cliente->ci }}</td>
                    <td>
                        <form action="{{ route('pedidos.luego') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                            <button type="submit" class="btn btn-primary">Seleccionar</button>
                        </form>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection