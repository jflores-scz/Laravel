<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Lista y busca.
     */
    public function index(Request $request)
    {
        $query = $request->get('query');

        if ($query) {
            $almacenes = Almacen::where('capacidad', 'like', "%$query%")
                                ->orWhere('tipo', 'like', "%$query%")
                                ->paginate(10); 
        } else {
            $almacenes = Almacen::paginate(10);
        }

        return view('almacenes.index', compact('almacenes', 'query'));
    }

    /**
     * Crear.
     */
    public function create()
    {
        return view('almacenes.create');
    }

    /**
     * Guardar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sector' => 'required|string|max:50',
            'pasillo' => 'required|string|max:50',
            'numero' => 'required|string|max:50',
            'capacidad_width' => 'required|integer|min:1',
            'capacidad_height' => 'required|integer|min:1',
            'tipo' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
        ]);

        $validated['capacidad'] = $request->input('capacidad_width') . 'x' . $request->input('capacidad_height');
        unset($validated['capacidad_width'], $validated['capacidad_height']);

        Almacen::create($validated);

        return redirect()->route('almacenes.index')->with('success', 'Almacén creado exitosamente.');
    }

    /**
     * Mostrar.
     */
    public function show(Almacen $almacen)
    {
        return view('almacenes.show', compact('almacen'));
    }

    /**
     * Editar.
     */
    public function edit(Almacen $almacen)
    {
        return view('almacenes.edit', compact('almacen'));
    }

    /**
     * Actualizar.
     */
    public function update(Request $request, Almacen $almacen)
    {
        $validated = $request->validate([
            'sector' => 'required|string|max:50',
            'pasillo' => 'required|string|max:50',
            'numero' => 'required|string|max:50',
            'capacidad_width' => 'required|integer|min:1',
            'capacidad_height' => 'required|integer|min:1',
            'tipo' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
        ]);

        $validated['capacidad'] = $request->input('capacidad_width') . 'x' . $request->input('capacidad_height');
        unset($validated['capacidad_width'], $validated['capacidad_height']);

        $almacen->update($validated);

        return redirect()->route('almacenes.index')->with('success', 'Almacén actualizado exitosamente.');
    }

    /**
     * Eliminar.
     */
    public function destroy(Almacen $almacen)
    {
        $almacen->delete();

        return redirect()->route('almacenes.index')->with('success', 'Almacén eliminado exitosamente.');
    }
}
