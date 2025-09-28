<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('query');
        $books = Book::when($query, function($q) use ($query) {
            return $q->where('titulo', 'LIKE', "%$query%")
                    ->orWhere('isbn', 'LIKE', "%$query%");
        })->paginate(10);
        
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:13',
            'anio' => 'required|integer|min:1000|max:' . date('Y'),
            'descripcion' => 'required|string',
            'portada' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml|max:2048',
        ]);

        if ($request->hasFile('portada')) {
            $imageName = time().'.'.$request->portada->extension();
            $request->portada->move(public_path('books'), $imageName);
            $validated['portada'] = 'books/' . $imageName;
        }

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book creado exitosamente.');
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
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'required|string',
            'anio' => 'required|integer|min:1000|max:' . date('Y'),
            'descripcion' => 'required|string',
            'portada' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml|max:2048',
        ]);

        if ($request->hasFile('portada')) {
            // Delete old image
            if ($book->portada) {
                Storage::delete('public/' . $book->portada);
            }

            $imageName = time().'.'.$request->portada->extension();
            $request->portada->move(public_path('books'), $imageName);
            $validated['portada'] = 'books/' . $imageName;
        }

        $book->update($validated);

        return redirect()->route('books.catalogo')
            ->with('success', 'Book actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.catalogo')
            ->with('success', 'Book eliminado exitosamente.');
    }

    public function catalogo(Request $request)
    {
        $query = $request->get('query');
        $books = Book::when($query, function($q) use ($query) {
            return $q->where('titulo', 'LIKE', "%$query%")
                    ->orWhere('isbn', 'LIKE', "%$query%");
        })->get();
        
        return view('books.catalogo', compact('books'));
    }
}
