<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $employeeId = User::query()->where('role', 'receptionist')->value('id');
        if (!$employeeId) {
            return;
        }

        Payment::query()->delete();

        $memberships = Membership::query()->with('plan')->orderBy('id')->get();

        foreach ($memberships as $membership) {
            $planDays = (int) ($membership->plan?->duracion_dias ?? 30);
            $monto = (float) ($membership->plan?->precio ?? 0);

            if ($membership->estado === 'activa') {
                for ($i = 5; $i >= 1; $i--) {
                    $fechaVencimiento = now()->subMonths($i)->toDateString();
                    $fechaPago = now()->subMonths($i)->subDays(1)->toDateString();

                    Payment::create([
                        'membership_id' => $membership->id,
                        'monto' => $monto,
                        'metodo_pago' => $i % 2 === 0 ? 'efectivo' : 'tarjeta_debito',
                        'estado' => 'pagado',
                        'fecha_pago' => $fechaPago,
                        'fecha_vencimiento' => $fechaVencimiento,
                        'referencia' => 'PAGO-' . $membership->id . '-' . $i,
                        'user_id' => $employeeId,
                    ]);
                }

                Payment::create([
                    'membership_id' => $membership->id,
                    'monto' => $monto,
                    'metodo_pago' => 'efectivo',
                    'estado' => 'pagado',
                    'fecha_pago' => now()->subDays(3)->toDateString(),
                    'fecha_vencimiento' => now()->subDays(2)->toDateString(),
                    'referencia' => 'PAGO-ACTUAL-' . $membership->id,
                    'user_id' => $employeeId,
                ]);

                Payment::create([
                    'membership_id' => $membership->id,
                    'monto' => $monto,
                    'metodo_pago' => 'efectivo',
                    'estado' => 'pendiente',
                    'fecha_pago' => null,
                    'fecha_vencimiento' => now()->addDays($planDays)->toDateString(),
                    'referencia' => null,
                    'user_id' => $employeeId,
                ]);

                continue;
            }

            if ($membership->estado === 'vencida') {
                Payment::create([
                    'membership_id' => $membership->id,
                    'monto' => $monto,
                    'metodo_pago' => 'efectivo',
                    'estado' => 'vencido',
                    'fecha_pago' => null,
                    'fecha_vencimiento' => now()->subDays(20)->toDateString(),
                    'referencia' => null,
                    'user_id' => $employeeId,
                ]);
                continue;
            }

            // cancelada / inactiva
            Payment::create([
                'membership_id' => $membership->id,
                'monto' => $monto,
                'metodo_pago' => 'tarjeta_debito',
                'estado' => 'pagado',
                'fecha_pago' => now()->subMonths(7)->toDateString(),
                'fecha_vencimiento' => now()->subMonths(7)->toDateString(),
                'referencia' => 'CIERRE-' . $membership->id,
                'user_id' => $employeeId,
            ]);
        }
    }
}
