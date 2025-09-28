<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;
    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'autor',
        'isbn',
        'anio',
        'descripcion',
        'portada'
    ];
}