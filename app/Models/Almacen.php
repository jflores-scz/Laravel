<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'almacenes';

    protected $primaryKey = 'id'; // Replace 'id' with your actual primary key column

    protected $fillable = [
        'sector',
        'pasillo',
        'numero',
        'capacidad',
        'tipo',
        'estado',
    ];
}
