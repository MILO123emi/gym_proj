<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $employeeId = User::query()->where('role', 'receptionist')->value('id');
        $plans = MembershipPlan::query()->orderBy('id')->get();

        if (!$employeeId || $plans->isEmpty()) {
            return;
        }

        $clients = Client::query()->orderBy('id')->get();

        foreach ($clients as $index => $client) {
            $position = $index + 1;
            $plan = $plans[$index % $plans->count()];

            $estado = 'activa';
            if ($position > 20) {
                $estado = 'cancelada';
            } elseif ($position > 15) {
                $estado = 'vencida';
            }

            $fechaInicio = now()->subDays($position * 8);
            $fechaFin = $fechaInicio->copy()->addDays((int) $plan->duracion_dias);

            Membership::updateOrCreate(
                ['client_id' => $client->id],
                [
                    'membership_plan_id' => $plan->id,
                    'fecha_inicio' => $fechaInicio->toDateString(),
                    'fecha_fin' => $fechaFin->toDateString(),
                    'estado' => $estado,
                    'user_id' => $employeeId,
                ]
            );
        }
    }
}
