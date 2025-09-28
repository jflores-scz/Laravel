<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'libro_id',
        'cliente_id',
        'razon',
        'fecha_inicio',
        'fecha_devolucion',
        'fecha_final',
        'estado_solicitud',
        'estado_devolucion',
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
