<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'nombre' => 'Plan Mensual',
                'descripcion' => 'Acceso completo durante 30 dias.',
                'precio' => 500.00,
                'duracion_dias' => 30,
                'tipo' => 'mensual',
            ],
            [
                'nombre' => 'Plan Semestral',
                'descripcion' => 'Acceso completo durante 6 meses.',
                'precio' => 2500.00,
                'duracion_dias' => 180,
                'tipo' => 'semestral',
            ],
            [
                'nombre' => 'Plan Anual',
                'descripcion' => 'Acceso completo durante 12 meses.',
                'precio' => 4500.00,
                'duracion_dias' => 365,
                'tipo' => 'anual',
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::updateOrCreate(
                ['tipo' => $plan['tipo']],
                $plan + ['activo' => true]
            );
        }
    }
}
