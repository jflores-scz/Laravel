<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Almacen;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Update the estado of all clientes and almacenes
        $this->updateClientesYAlmacenesEstado();

        $query = $request->get('query');

        if ($query) {
            $pedidos = Pedido::with(['almacen', 'cliente', 'user'])
                ->whereHas('cliente', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%");
                })
                ->orWhereHas('almacen', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%");
                })
                ->orWhere('estado', 'like', "%$query%")
                ->paginate(10);
        } else {
            $pedidos = Pedido::with(['almacen', 'cliente', 'user'])->paginate(10);
        }

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'estado' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Pedido::create([
            'cliente_id' => $request->cliente_id,
            'almacen_id' => $request->almacen_id,
            'estado' => $request->estado,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido registrado exitosamente.');
    }
    
    /**
     * Show the form for creating a new pedido.
     */
    public function create(Request $request)
    {
        $query = $request->get('query');

        if ($query) {
            $clientes = Cliente::where('nombre', 'like', "%$query%")
                ->orWhere('apellido', 'like', "%$query%")
                ->orWhere('ci', 'like', "%$query%")
                ->get(); // Fetch all results
        } else {
            $clientes = Cliente::all(); // Fetch all results
        }

        return view('pedidos.create', compact('clientes', 'query'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', compact('pedido'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string|max:255',
        ]);

        $pedido->update([
            'almacen_id' => $request->almacen_id,
            'cliente_id' => $request->cliente_id,
            'estado' => $request->estado,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente.');
    }

    /**
     * Procesa el cliente y muestra luego.blade
     */
    public function luego(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $cliente_id = $request->input('cliente_id');
        $almacenes = Almacen::all(); // Fetch all almacenes

        return view('pedidos.luego', compact('cliente_id', 'almacenes'));
    }

    /**
     * Procesa el almacen y muestra final.blade 
     */
    public function final(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
        ]);

        $cliente_id = session('cliente_id');
        $almacen_id = $request->input('almacen_id');

        // Clear the cliente_id from the session
        session()->forget('cliente_id');

        return view('pedidos.final', compact('almacen_id', 'cliente_id'));
    }

    /**
     * Update the estado of all clientes and almacenes.
     */
    public function updateClientesYAlmacenesEstado()
    {
        // Update estado for all clientes
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            // Check if a pedido exists for the cliente
            $hasPedido = Pedido::where('cliente_id', $cliente->id)->exists();

            // Update the estado based on whether a pedido exists
            $cliente->estado = $hasPedido ? 'Activo' : 'Inactivo';
            $cliente->save();
        }

        // Update estado for all almacenes
        $almacenes = Almacen::all();

        foreach ($almacenes as $almacen) {
            // Check if a pedido exists for the almacen
            $hasPedido = Pedido::where('almacen_id', $almacen->id)->exists();

            // Update the estado based on whether a pedido exists
            $almacen->estado = $hasPedido ? 'Activo' : 'Inactivo';
            $almacen->save();
        }
    }
}
