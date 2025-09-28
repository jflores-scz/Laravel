<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DeudaController extends Controller
{
    public function index()
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login')->with('error', 'Debes iniciar sesión para ver tus multas.');
        }

        $clienteId = Session::get('cliente_id');
        $deudas = Deuda::where('cliente_id', $clienteId)->with(['prestamo.book'])->get();

        return view('deudas.index', compact('deudas'));
    }
}
