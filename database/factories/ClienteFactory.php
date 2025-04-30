<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'ci' => $this->faker->unique()->numerify('########'),
            'telefono' => $this->faker->numerify('7#######'),
            'direccion' => $this->faker->address,
            'estado' => 'Inactivo',
        ];
    }
}
