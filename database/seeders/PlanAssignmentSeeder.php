<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\PlanAssignment;
use App\Models\TrainingPlan;
use Illuminate\Database\Seeder;

class PlanAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        PlanAssignment::query()->delete();

        $plans = TrainingPlan::query()->where('activo', true)->orderBy('id')->get();
        if ($plans->isEmpty()) {
            return;
        }

        $clients = Client::query()
            ->whereIn('estado', ['activo', 'suspendido'])
            ->orderBy('id')
            ->get();

        foreach ($clients as $index => $client) {
            $plan = $plans[$index % $plans->count()];

            PlanAssignment::create([
                'client_id' => $client->id,
                'training_plan_id' => $plan->id,
                'trainer_id' => $plan->trainer_id,
                'fecha_inicio' => now()->subDays(15 + $index)->toDateString(),
                'fecha_fin' => null,
                'estado' => 'activo',
                'notas' => 'Asignacion automatica de prueba.',
            ]);
        }
    }
}
