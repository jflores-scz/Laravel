<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libro_id',
        'cliente_id',
        'user_id',
        'estado',
    ];

    /**
     * Get the libro associated with the pedido.
     */
    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    /**
     * Get the cliente associated with the pedido.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Get the user who registered the pedido.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function index()
    {
        $pedidos = Pedido::with(['almacen', 'cliente', 'user'])->get();
        return view('pedidos.index', compact('pedidos'));
    }
}
