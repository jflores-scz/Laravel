@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('Dashboard Cliente') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Bienvenido, ') }} {{ session('cliente_nombre') }}

                    <form action="{{ route('cliente.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link">{{ __('Cerrar Sesion') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
