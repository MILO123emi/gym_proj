<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $users = [
            ['name' => 'Administrador Principal', 'email' => 'admin@gimnasio.com', 'password' => 'admin123', 'role' => 'admin'],
            ['name' => 'Paola Recepción', 'email' => 'recepcion@gimnasio.com', 'password' => 'recep123', 'role' => 'receptionist'],
            ['name' => 'Ernesto Recepción', 'email' => 'recepcion2@gimnasio.com', 'password' => 'recep123', 'role' => 'receptionist'],
            ['name' => 'José Entrenador', 'email' => 'entrenador1@gimnasio.com', 'password' => 'train123', 'role' => 'trainer'],
            ['name' => 'Andrea Entrenadora', 'email' => 'entrenador2@gimnasio.com', 'password' => 'train123', 'role' => 'trainer'],
            ['name' => 'Melvin Coach', 'email' => 'entrenador3@gimnasio.com', 'password' => 'train123', 'role' => 'trainer'],
        ];

        foreach ($users as $item) {
            User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => $item['password'],
                    'email_verified_at' => $now,
                    'role' => $item['role'],
                    'active' => true,
                ]
            );
        }
    }
}
