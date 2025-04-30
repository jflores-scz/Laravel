@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Seleccionar Cliente</h3>

    <!-- Busqueda -->
    <form method="GET" action="{{ route('pedidos.create') }}" class="d-inline-block mb-3">
        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Buscar por CI o Nombre" value="{{ request('query') }}">
        <button type="submit" class="btn btn-primary btn-sm mt-2">Buscar</button>
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
                @if ($cliente->estado !== 'Oculto') <!-- Ensure hidden clients are not shown -->
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