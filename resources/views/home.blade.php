@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Contenido -->
        <div class="col-md-12">
            <div class="row justify-content-center">
                <!-- Welcome Card -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Bienvenido') }}</div>
                        <div class="card-body bg-light">
                            <div id="welcome-message">
                                {{ __('Has iniciado Sesión') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="col-md-6 mt-4">
                    <div class="card bg-success text-white">
                        <div class="card-header">{{ __('Estadísticas') }}</div>
                        <div class="card-body bg-light text-dark">
                            <p><strong>{{ __('Clientes Registrados:') }}</strong> {{ \App\Models\Cliente::where('estado', '!=', 'Oculto')->count() }}</p>
                            <p><strong>{{ __('Almacenes Registrados:') }}</strong> {{ \App\Models\Almacen::where('estado', '!=', 'Oculto')->count() }}</p>
                            <p><strong>{{ __('Pedidos Activos:') }}</strong> {{ \App\Models\Pedido::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- User Info Card -->
                <div class="col-md-6 mt-4">
                    <div class="card bg-primary text-white">
                        <div class="card-header">{{ __('Información del Usuario') }}</div>
                        <div class="card-body bg-light text-dark">
                            <p><strong>{{ __('Nombre:') }}</strong> {{ Auth::user()->nombre }}</p>
                            <p><strong>{{ __('Apellido:') }}</strong> {{ Auth::user()->apellido }}</p>
                            <p><strong>{{ __('Email:') }}</strong> {{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
