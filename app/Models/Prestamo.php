<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'cliente_id',
        'razon',
        'fecha_inicio',
        'fecha_devolucion',
        'fecha_final',
        'estado_solicitud',
        'estado_devolucion',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
