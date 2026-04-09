<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $receptionistId = User::query()
            ->where('role', 'receptionist')
            ->value('id');

        if (!$receptionistId) {
            return;
        }

        $fullNames = [
            'Carlos Mendoza', 'Ana López', 'José Martínez', 'María Hernández', 'Luis Banegas',
            'Karla Aguilar', 'Santos Perdomo', 'Fernanda Mejía', 'Manuel Castellanos', 'Andrea Pineda',
            'Ricardo Velásquez', 'Paola Flores', 'Edwin Alvarado', 'Daniela Ochoa', 'Kevin Zelaya',
            'Marlon Cruz', 'Claudia Turcios', 'Eduardo Suazo', 'Jenny Matute', 'Rafael Ordóñez',
            'Brenda Rivera', 'Javier Lagos', 'Sofía Figueroa', 'Tomás Amador', 'Miriam Erazo',
        ];

        foreach ($fullNames as $index => $fullName) {
            [$nombre, $apellido] = explode(' ', $fullName, 2);
            $pos = $index + 1;

            $estado = 'activo';
            if ($pos > 20) {
                $estado = 'inactivo';
            } elseif ($pos > 15) {
                $estado = 'suspendido';
            }

            $phoneStart = [2, 3, 8, 9][$index % 4];
            $telefono = $phoneStart . str_pad((string) (1000000 + $index), 7, '0', STR_PAD_LEFT);

            Client::updateOrCreate(
                ['email' => "cliente{$pos}@gimnasio.hn"],
                [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'telefono' => $telefono,
                    'email' => "cliente{$pos}@gimnasio.hn",
                    'cedula' => '0801-1990-' . str_pad((string) $pos, 4, '0', STR_PAD_LEFT),
                    'fecha_nacimiento' => now()->subYears(18 + ($index % 20))->subDays($index)->toDateString(),
                    'direccion' => "Colonia Centro, Casa {$pos}, Tegucigalpa",
                    'contacto_emergencia' => "Familiar {$pos} - 9" . str_pad((string) (2000000 + $index), 7, '0', STR_PAD_LEFT),
                    'estado' => $estado,
                    'user_id' => $receptionistId,
                ]
            );
        }
    }
}
