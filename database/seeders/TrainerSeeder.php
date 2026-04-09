<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = ['Fuerza', 'Resistencia', 'Recomposicion corporal', 'Movilidad'];

        $trainerUsers = User::query()
            ->where('role', 'trainer')
            ->orderBy('id')
            ->get();

        foreach ($trainerUsers as $index => $user) {
            Trainer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'especialidad' => $especialidades[$index % count($especialidades)],
                    'bio' => 'Entrenador certificado para programas personalizados.',
                    'estado' => 'activo',
                ]
            );
        }
    }
}
