@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ __('Editar Pedido') }}</h3>
    <p><strong>{{ __('ID del Pedido:') }}</strong> {{ $pedido->id }}</p>

    <div class="row justify-content-center">
        <!-- Cliente Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('Cliente') }}</div>
                <div class="card-body">
                    <p><strong>{{ __('Nombre:') }}</strong> {{ $pedido->cliente->nombre }}</p>
                    <p><strong>{{ __('Apellido:') }}</strong> {{ $pedido->cliente->apellido }}</p>
                    <p><strong>{{ __('C.I.:') }}</strong> {{ $pedido->cliente->ci }}</p>
                    <p><strong>{{ __('Teléfono:') }}</strong> {{ $pedido->cliente->telefono }}</p>
                    <p><strong>{{ __('Dirección:') }}</strong> {{ $pedido->cliente->direccion }}</p>
                </div>
            </div>
        </div>

        <!-- Almacén Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Almacén') }}</div>
                <div class="card-body">
                    <p><strong>{{ __('ID:') }}</strong> {{ $pedido->almacen->id }}</p>
                    <p><strong>{{ __('Sector:') }}</strong> {{ $pedido->almacen->sector }}</p>
                    <p><strong>{{ __('Pasillo:') }}</strong> {{ $pedido->almacen->pasillo }}</p>
                    <p><strong>{{ __('Número:') }}</strong> {{ $pedido->almacen->numero }}</p>
                    <p><strong>{{ __('Capacidad:') }}</strong> {{ $pedido->almacen->capacidad }}</p>
                    <p><strong>{{ __('Tipo:') }}</strong> {{ $pedido->almacen->tipo }}</p>
                </div>
            </div>
        </div>

        <!-- User Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">{{ __('Usuario') }}</div>
                <div class="card-body">
                    <p><strong>{{ __('ID:') }}</strong> {{ $pedido->user->id }}</p>
                    <p><strong>{{ __('Nombre:') }}</strong> {{ $pedido->user->name }}</p>
                    <p><strong>{{ __('Email:') }}</strong> {{ $pedido->user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection