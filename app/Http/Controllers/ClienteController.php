<?php
namespace App\Http\Controllers;

use App\Models\Cliente; // To reference the Cliente model
use Illuminate\Http\Request; // To use the Request class

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('status', 'Cliente eliminado exitosamente.');
    }

    /**
     * Search for a resource based on query.
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