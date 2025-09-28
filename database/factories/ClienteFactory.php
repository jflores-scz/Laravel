<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
use Illuminate\Support\Facades\Hash;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'ci' => $this->faker->unique()->numerify('########') . $this->faker->randomElement(['LP', 'SC', 'CB']),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // password
            'rol' => $this->faker->randomElement(['Estudiante', 'Docente', 'Personal']),
            'estado' => 'Activo',
        ];
    }
}
