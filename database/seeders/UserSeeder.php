<?php
// Ruta: database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        // Puedes agregar más usuarios de prueba
        User::create([
            'name' => 'sujeto-2025',
            'password' => Hash::make('1243'),
        ]);

        User::create([
            'name' => 'sujeto-16',
            'password' => Hash::make('gris'),
        ]);

        User::create([
            'name' => 'sujeto-17',
            'password' => Hash::make('miles'),
        ]);
    }
}