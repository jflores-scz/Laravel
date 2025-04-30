<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Almacen>
 */
class AlmacenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sector' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'pasillo' => $this->faker->numberBetween(1, 10),
            'numero' => $this->faker->numberBetween(1, 999),
            'capacidad' => $this->faker->numberBetween(1, 10) . 'x' . $this->faker->numberBetween(1, 10),
            'tipo' => $this->faker->randomElement(['Refrigerado', 'Estandar']),
            'estado' => 'Inactivo',
        ];
    }
}
