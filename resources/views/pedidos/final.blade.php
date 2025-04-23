@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Datos Seleccionados</h3>
    <p>ID del Cliente: {{ $cliente_id }}</p>
    <p>ID del Almacén: {{ $almacen_id }}</p>

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
        <input type="hidden" name="almacen_id" value="{{ $almacen_id }}">
        <input type="hidden" name="estado" value="pago retrasado">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}"> <!-- Add the authenticated user's ID -->
        <button type="submit" class="btn btn-success">Registrar Pedido</button>
    </form>
</div>
@endsection