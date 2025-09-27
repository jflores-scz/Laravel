<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('query');
        $libros = Libro::when($query, function($q) use ($query) {
            return $q->where('titulo', 'LIKE', "%$query%")
                    ->orWhere('isbn', 'LIKE', "%$query%");
        })->paginate(10);
        
        return view('libros.index', compact('libros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('libros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'required|string|unique:libros,isbn|max:13',
            'anio' => 'required|integer|min:1000|max:' . date('Y'),
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $imageName = time().'.'.$request->imagen->extension();
            $request->imagen->move(public_path('libros'), $imageName);
            $validated['imagen_path'] = 'libros/' . $imageName;
        }

        Libro::create($validated);

        return redirect()->route('libros.index')
            ->with('success', 'Libro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro)
    {
        return view('libros.edit', compact('libro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'required|string',
            'anio' => 'required|integer|min:1000|max:' . date('Y'),
            'descripcion' => 'required|string'
        ]);

        $libro->update($validated);

        return redirect()->route('libros.index')
            ->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();

        return redirect()->route('libros.index')
            ->with('success', 'Libro eliminado exitosamente.');
    }

    public function catalogo(Request $request)
    {
        $query = $request->get('query');
        $libros = Libro::when($query, function($q) use ($query) {
            return $q->where('titulo', 'LIKE', "%$query%")
                    ->orWhere('isbn', 'LIKE', "%$query%");
        })->get();
        
        return view('libros.catalogo', compact('libros'));
    }
}
