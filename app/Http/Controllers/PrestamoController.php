<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Deuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function adminIndex()
    {
        $prestamos = Prestamo::with(['book', 'cliente'])
                            ->where('estado_solicitud', 'Pendiente')
                            ->get();

        // Check for overdue loans and create Deudas
        foreach ($prestamos as $prestamo) {
            if ($prestamo->estado_solicitud == 'Aprobado' && Carbon::now()->greaterThan($prestamo->fecha_final)) {
                $prestamo->estado_solicitud = 'Atrasado';
                $prestamo->save();

                // Create Deuda if it doesn't exist
                Deuda::firstOrCreate(
                    ['prestamo_id' => $prestamo->id],
                    ['cliente_id' => $prestamo->cliente_id, 'estado' => 'Pendiente']
                );
            }
        }

        return view('pedidos.index', compact('prestamos'));
    }

    public function adminShow(Prestamo $prestamo)
    {
        return view('pedidos.show', compact('prestamo'));
    }

    public function approve(Prestamo $prestamo)
    {
        if ($prestamo->estado_solicitud != 'Pendiente') {
            return back()->with('error', 'Solo se pueden aprobar préstamos con estado Pendiente.');
        }

        $prestamo->estado_solicitud = 'Aprobado';
        $prestamo->fecha_devolucion = now()->addDays(15); // Example: 15 days loan period
        $prestamo->save();

        // Cancel overlapping pending loans
        $overlappingPrestamos = Prestamo::where('book_id', $prestamo->book_id)
            ->where('id', '!=', $prestamo->id)
            ->where('estado_solicitud', 'Pendiente')
            ->where(function ($query) use ($prestamo) {
                $query->where(function ($q) use ($prestamo) {
                    $q->where('fecha_inicio', '<=', $prestamo->fecha_final)
                        ->where('fecha_final', '>=', $prestamo->fecha_inicio);
                });
            })
            ->get();

        foreach ($overlappingPrestamos as $overlappingPrestamo) {
            $overlappingPrestamo->estado_solicitud = 'Cancelado';
            $overlappingPrestamo->save();
        }

        return redirect()->route('pedidos.index')->with('success', 'Préstamo aprobado exitosamente. Préstamos superpuestos han sido cancelados.');
    }

    public function adminCancel(Prestamo $prestamo)
    {
        if ($prestamo->estado_solicitud != 'Pendiente') {
            return back()->with('error', 'Solo se pueden cancelar préstamos con estado Pendiente.');
        }

        $prestamo->estado_solicitud = 'Cancelado';
        $prestamo->save();

        return redirect()->route('pedidos.index')->with('success', 'Préstamo cancelado exitosamente.');
    }

    public function index()
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login')->with('error', 'Debes iniciar sesión para ver tus préstamos.');
        }

        $clienteId = Session::get('cliente_id');
        $prestamos = Prestamo::where('cliente_id', $clienteId)->with('book')->get();

        // Check for overdue loans and create Deudas
        foreach ($prestamos as $prestamo) {
            if ($prestamo->estado_solicitud == 'Aprobado' && Carbon::now()->greaterThan($prestamo->fecha_final)) {
                $prestamo->estado_solicitud = 'Atrasado';
                $prestamo->save();

                // Create Deuda if it doesn't exist
                Deuda::firstOrCreate(
                    ['prestamo_id' => $prestamo->id],
                    ['cliente_id' => $prestamo->cliente_id, 'estado' => 'Pendiente']
                );
            }
        }

        return view('prestamos.index', compact('prestamos'));
    }

    public function create(Book $book)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login')->with('error', 'Debes iniciar sesión para reservar un libro.');
        }

        $cliente = Cliente::find(Session::get('cliente_id'));

        // Calculate fecha_inicio for client view
        $latestPrestamo = Prestamo::where('book_id', $book->id)
                                ->whereIn('estado_solicitud', ['Pendiente', 'Aprobado'])
                                ->orderByDesc('fecha_final')
                                ->first();

        $fechaInicio = now();
        if ($latestPrestamo) {
            $fechaInicio = Carbon::parse($latestPrestamo->fecha_final)->addDay();
        }

        return view('prestamos.create', compact('book', 'cliente', 'fechaInicio'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'cliente_id' => 'required|exists:clientes,id',
            'razon' => 'required|string|max:255',
            'fecha_final' => 'required|date|after:today',
        ]);

        // Calculate fecha_inicio
        $latestPrestamo = Prestamo::where('book_id', $validated['book_id'])
                                ->whereIn('estado_solicitud', ['Pendiente', 'Aprobado'])
                                ->orderByDesc('fecha_final')
                                ->first();

        $fechaInicio = now();
        if ($latestPrestamo) {
            $fechaInicio = Carbon::parse($latestPrestamo->fecha_final)->addDay();
        }

        // Validate fecha_final against calculated fechaInicio
        if (Carbon::parse($validated['fecha_final'])->lessThanOrEqualTo($fechaInicio)) {
            return back()->withErrors(['fecha_final' => 'La fecha final debe ser posterior a la fecha de inicio calculada (' . $fechaInicio->format('Y-m-d') . ').'])->withInput();
        }

        $prestamo = new Prestamo();
        $prestamo->book_id = $validated['book_id'];
        $prestamo->cliente_id = $validated['cliente_id'];
        $prestamo->razon = $validated['razon'];
        $prestamo->fecha_inicio = $fechaInicio;
        $prestamo->fecha_final = $validated['fecha_final'];
        $prestamo->estado_solicitud = 'Pendiente';
        $prestamo->save();

        return redirect()->route('cliente.dashboard')->with('success', 'Tu solicitud de préstamo ha sido enviada.');
    }

    public function cancel(Prestamo $prestamo)
    {
        if (!Session::has('cliente_id') || $prestamo->cliente_id != Session::get('cliente_id')) {
            return redirect()->route('prestamos.index')->with('error', 'No tienes permiso para cancelar este préstamo.');
        }

        if ($prestamo->estado_solicitud != 'Pendiente') {
            return redirect()->route('prestamos.index')->with('error', 'Solo puedes cancelar préstamos con estado Pendiente.');
        }

        $prestamo->estado_solicitud = 'Cancelado';
        $prestamo->save();

        return redirect()->route('prestamos.index')->with('success', 'Préstamo cancelado exitosamente.');
    }

    public function returnsIndex()
    {
        $prestamos = Prestamo::with(['book', 'cliente'])
                            ->whereIn('estado_solicitud', ['Aprobado', 'Atrasado'])
                            ->get();
        return view('prestamos.returns.index', compact('prestamos'));
    }

    public function markAsReturned(Prestamo $prestamo)
    {
        if (!in_array($prestamo->estado_solicitud, ['Aprobado', 'Atrasado'])) {
            return back()->with('error', 'Solo se pueden marcar como devueltos préstamos Aprobados o Atrasados.');
        }

        $prestamo->estado_solicitud = 'Devuelto';
        $prestamo->fecha_devolucion = now();
        $prestamo->save();

        return redirect()->route('prestamos.returns.index')->with('success', 'Préstamo marcado como devuelto exitosamente.');
    }

    // Admin methods for creating Prestamo
    public function adminCreateForm(Book $book)
    {
        return view('prestamos.admin_create_form', compact('book'));
    }

    public function adminCreateConfirm(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'cliente_ci' => 'required|string|min:8|max:10', // Assuming CI is 8-10 digits
        ]);

        $book = Book::findOrFail($request->book_id);
        $cliente = Cliente::where('ci', 'like', $request->cliente_ci . '%')->first(); // Find by CI number

        if (!$cliente) {
            return back()->withErrors(['cliente_ci' => 'Cliente no encontrado con el CI proporcionado.'])->withInput();
        }

        // Calculate fecha_inicio for admin confirmation view
        $latestPrestamo = Prestamo::where('book_id', $book->id)
                                ->whereIn('estado_solicitud', ['Pendiente', 'Aprobado'])
                                ->orderByDesc('fecha_final')
                                ->first();

        $fechaInicio = now();
        if ($latestPrestamo) {
            $fechaInicio = Carbon::parse($latestPrestamo->fecha_final)->addDay();
        }

        return view('prestamos.admin_create_confirm_view', compact('book', 'cliente', 'fechaInicio'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'cliente_id' => 'required|exists:clientes,id',
            'razon' => 'required|string|max:255',
            'fecha_final' => 'required|date|after:today',
        ]);

        // Calculate fecha_inicio
        $latestPrestamo = Prestamo::where('book_id', $validated['book_id'])
                                ->whereIn('estado_solicitud', ['Pendiente', 'Aprobado'])
                                ->orderByDesc('fecha_final')
                                ->first();

        $fechaInicio = now();
        if ($latestPrestamo) {
            $fechaInicio = Carbon::parse($latestPrestamo->fecha_final)->addDay();
        }

        // Validate fecha_final against calculated fechaInicio
        if (Carbon::parse($validated['fecha_final'])->lessThanOrEqualTo($fechaInicio)) {
            return back()->withErrors(['fecha_final' => 'La fecha final debe ser posterior a la fecha de inicio calculada (' . $fechaInicio->format('Y-m-d') . ').'])->withInput();
        }

        $prestamo = new Prestamo();
        $prestamo->book_id = $validated['book_id'];
        $prestamo->cliente_id = $validated['cliente_id'];
        $prestamo->razon = $validated['razon'];
        $prestamo->fecha_inicio = $fechaInicio;
        $prestamo->fecha_final = $validated['fecha_final'];
        $prestamo->estado_solicitud = 'Pendiente';
        $prestamo->save();

        return redirect()->route('pedidos.index')->with('success', 'Préstamo creado exitosamente para el cliente.');
    }
}
