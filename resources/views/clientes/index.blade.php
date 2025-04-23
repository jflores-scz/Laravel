@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de Clientes') }}
                    <form method="GET" action="{{ route('clientes.index') }}" class="d-inline-block float-end">
                        <input type="text" name="query" class="form-control d-inline-block w-auto" placeholder="Buscar por CI o Nombre" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Buscar</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($clientes->isEmpty())
                        <p>{{ __('No hay clientes registrados.') }}</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Nombre') }}</th>
                                    <th>{{ __('Apellido') }}</th>
                                    <th>{{ __('CI') }}</th>
                                    <th>{{ __('Teléfono') }}</th>
                                    <th>{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->apellido }}</td>
                                        <td>{{ $cliente->ci }}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">{{ __('Editar') }}</a>
                                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('¿Está seguro de eliminar este cliente?') }}')">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $clientes->links() }}
                        </div>
                        @if (!$clientes->isEmpty())
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $clientes->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection