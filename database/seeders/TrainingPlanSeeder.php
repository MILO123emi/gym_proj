<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\TrainingPlan;
use Illuminate\Database\Seeder;

class TrainingPlanSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = Trainer::query()->orderBy('id')->get();
        if ($trainers->isEmpty()) {
            return;
        }

        $plans = [
            ['nombre' => 'Pérdida de Peso', 'descripcion' => 'Rutina de deficit calorico y cardio funcional.', 'tipo' => 'asistido', 'dias_semana' => 5],
            ['nombre' => 'Ganancia Muscular', 'descripcion' => 'Rutina de hipertrofia con sobrecarga progresiva.', 'tipo' => 'asistido', 'dias_semana' => 5],
            ['nombre' => 'Resistencia', 'descripcion' => 'Trabajo mixto de resistencia cardiovascular y muscular.', 'tipo' => 'libre', 'dias_semana' => 4],
            ['nombre' => 'Principiantes', 'descripcion' => 'Plan base de adaptacion para nuevos miembros.', 'tipo' => 'libre', 'dias_semana' => 3],
        ];

        foreach ($plans as $index => $plan) {
            $trainer = $trainers[$index % $trainers->count()];

            TrainingPlan::updateOrCreate(
                ['nombre' => $plan['nombre']],
                $plan + ['trainer_id' => $trainer->id, 'activo' => true]
            );
        }
    }
}
