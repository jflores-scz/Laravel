<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Almacen;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Almacen::factory(20)->create();
    }
}
