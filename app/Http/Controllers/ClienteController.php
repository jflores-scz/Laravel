<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Lista y busca.
     */
    public function index(Request $request)
    {
        $query = $request->get('query');

        if ($query) {
            $clientes = Cliente::where('ci', 'like', "%$query%")
                               ->orWhere('nombre', 'like', "%$query%")
                               ->paginate(10);
        } else {
            $clientes = Cliente::paginate(10);
        }

        return view('clientes.index', compact('clientes', 'query'));
    }

    /**
     * Crear.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|unique:clientes',
            'telefono' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('status', 'Cliente registrado exitosamente.');
    }

    /**
     * Mostrar.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Editar.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|unique:clientes,ci,' . $cliente->id,
            'telefono' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('status', 'Cliente actualizado exitosamente.');
    }

    /**
     * Eliminar.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('status', 'Cliente eliminado exitosamente.');
    }

    /**
     * Buscar.
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $clientes = Cliente::where('ci', 'like', "%$query%")
                        ->orWhere('nombre', 'like', "%$query%")
                        ->get();

        return response()->json($clientes);
    }

}