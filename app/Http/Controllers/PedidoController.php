<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Almacen;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Lista, actualiza y busca.
     */
    public function index(Request $request)
    {
        $this->updateClientesYAlmacenesEstado();

        $query = $request->get('query');

        $pedidos = Pedido::with(['almacen', 'cliente', 'user'])
            ->whereHas('cliente', function ($q) {
                $q->where('estado', '!=', 'Oculto');
            })
            ->when($query, function ($q) use ($query) {
                $q->whereHas('cliente', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%")
                      ->orWhere('apellido', 'like', "%$query%")
                      ->orWhere('ci', 'like', "%$query%");
                })
                ->orWhereHas('almacen', function ($q) use ($query) {
                    $q->where('sector', 'like', "%$query%")
                      ->orWhere('pasillo', 'like', "%$query%");
                })
                ->orWhere('estado', 'like', "%$query%");
            })
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Guardar pedido.
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
     * Crear pedido.
     */
    public function create(Request $request)
    {
        $query = $request->get('query');

        if ($query) {
            $clientes = Cliente::where('estado', '!=', 'Oculto')
                ->where(function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%")
                      ->orWhere('apellido', 'like', "%$query%")
                      ->orWhere('ci', 'like', "%$query%");
                })
                ->get();
        } else {
            $clientes = Cliente::where('estado', '!=', 'Oculto')->get();
        }

        return view('pedidos.create', compact('clientes', 'query'));
    }

    /**
     * Editar.
     */
    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', compact('pedido'));
    }

    /**
     * Mostrar.
     */
    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Actualizar.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => 'required|string|in:Pago Retrasado,Pago al Día',
        ]);

        $pedido->update($validated);

        return redirect()->route('pedidos.edit', $pedido->id)->with('success', 'Estado actualizado correctamente.');
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

        // Store cliente_id in the session
        session(['cliente_id' => $request->input('cliente_id')]);

        $query = $request->input('query');

        $almacenes = Almacen::where('estado', '!=', 'Oculto') // Exclude hidden almacenes
            ->when($query, function ($q) use ($query) {
                $q->where('numero', 'like', "%$query%")
                  ->orWhere('capacidad', 'like', "%$query%")
                  ->orWhere('tipo', 'like', "%$query%");
            })
            ->get();

        return view('pedidos.luego', compact('almacenes', 'query'));
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

        session()->forget('cliente_id');

        return view('pedidos.final', compact('almacen_id', 'cliente_id'));
    }

    /**
     * Update de estado para clientes and almacenes.
     */
    public function updateClientesYAlmacenesEstado()
    {
        $clientes = Cliente::where('estado', '!=', 'Oculto')->get();

        foreach ($clientes as $cliente) {
            $hasPedido = Pedido::where('cliente_id', $cliente->id)->exists();

            $cliente->estado = $hasPedido ? 'Activo' : 'Inactivo';
            $cliente->save();
        }

        $almacenes = Almacen::where('estado', '!=', 'Oculto')->get();

        foreach ($almacenes as $almacen) {
            $hasPedido = Pedido::where('almacen_id', $almacen->id)->exists();

            $almacen->estado = $hasPedido ? 'Activo' : 'Inactivo';
            $almacen->save();
        }
    }
}
