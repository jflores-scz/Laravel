@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de Alquileres') }}
                    <form method="GET" action="{{ route('pedidos.index') }}" class="d-inline-block w-100">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="query" class="form-control" placeholder="Buscar por Cliente, Almacén o Estado" value="{{ request('query') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($pedidos->isEmpty())
                        <p>{{ __('No hay alquileres registrados.') }}</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Almacén ID') }}</th>
                                    <th>{{ __('Cliente') }}</th>
                                    <th>{{ __('Registrado Por') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ $pedido->id }}</td>
                                        <td>{{ $pedido->almacen->id }}</td>
                                        <td>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</td>
                                        <td>{{ $pedido->user->nombre }}</td>
                                        <td>{{ $pedido->estado }}</td>
                                        <td>
                                            <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-outline-warning btn-sm">{{ __('Editar') }}</a>
                                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('{{ __('¿Está seguro de eliminar este pedido?') }}')">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $pedidos->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection