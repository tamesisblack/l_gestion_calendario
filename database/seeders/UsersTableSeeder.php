<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombres' => 'Admin',
            'apellidos' => 'Principal',
            'email' => 'admin@gmail.com',
            'telefono' => '123456789',
            'password' => Hash::make('password'),
            'foto'     => null,
            'rol_id' => 1,// administrador
        ]);

        User::factory()->count(3)->create([
            'rol_id' => 2,// Consultor
        ]);

        User::factory()->count(10)->create([
            'rol_id' => 3,// Empleado
        ]);
    }
}
