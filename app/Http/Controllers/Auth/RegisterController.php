<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Illuminate\Support\Facades\Validator::make($data, [
            'nombre' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', 'max:255'],
            'apellido' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', 'max:255'],
            'ci' => ['required', 'string', 'regex:/^\d{8}$/', 'unique:users'],
            'ci_extension' => ['required', 'string', 'in:LP,SC,CB,OR,PT,CH,TJ,BE,PA'],
            'telefono' => ['required', 'string', 'regex:/^\d+$/', 'min:8', 'max:15'],
            'direccion' => ['required', 'string', 'max:50'],
            'estado' => ['required', 'string', 'in:Casado,Soltero,Otro'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $ci = $data['ci'] . $data['ci_extension'];

        return User::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'ci' => $ci,
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'estado' => $data['estado'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
