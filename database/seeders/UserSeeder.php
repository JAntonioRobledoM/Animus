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
            'name' => 'operador',
            'password' => Hash::make('operador'),
        ]);

        User::create([
            'name' => 'sujeto16',
            'password' => Hash::make('animus'),
        ]);

        User::create([
            'name' => 'desmond',
            'password' => Hash::make('miles'),
        ]);

        // Si quieres generar usuarios aleatorios, puedes usar:
        // \App\Models\User::factory(10)->create();
    }
}