<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'nombre', 
        'apellido', 
        'ci', 
        'email', 
        'password', 
        'rol', 
        'estado'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
