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
            'email' => 'required|string|email|max:30|unique:clientes',
            'password' => 'required|string|min:8|regex:/^[a-zA-Z0-9\-\.\_\*]+$/|max:30', // removed 'confirmed'
            'rol' => 'required|string|max:255',
            'estado' => 'nullable|string|max:255',
        ]);

        $validated['password'] = bcrypt($validated['password']);

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
            'ci_number' => ['required', 'numeric', 'digits_between:6,10'], // Example validation for CI number
            'ci_extension' => ['required', 'string', 'in:CH,LP,CB,OR,PT,TJ,SC,BN,PA'], // Example validation for CI extension
            'email' => 'required|string|email|max:30|unique:clientes,email,' . $cliente->id,
            'password' => 'nullable|string|min:8|regex:/^[a-zA-Z0-9\-\.\_\*]+$/|confirmed|max:30', // Password is nullable on update
            'rol' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        // Combine ci_number and ci_extension
        $validated['ci'] = $validated['ci_number'] . $validated['ci_extension'];
        unset($validated['ci_number']);
        unset($validated['ci_extension']);

        // Check for unique CI after combination, excluding current client
        if (Cliente::where('ci', $validated['ci'])->where('id', '!=', $cliente->id)->exists()) {
            return back()->withErrors(['ci_number' => 'El C.I. ya ha sido registrado.'])->withInput();
        }

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // Don't update password if not provided
        }

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