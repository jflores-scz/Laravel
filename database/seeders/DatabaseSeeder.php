<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update the admin user
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'Admin',
                'ci' => '12345678LP',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            ClienteSeeder::class,
            BookSeeder::class,
        ]);
    }
}
