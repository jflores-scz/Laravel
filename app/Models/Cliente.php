<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
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
