<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->query('periodo', 'Este Mes');

        [$start, $end] = $this->periodRange($periodo);

        $totalIngresos = Payment::query()
            ->where('estado', 'pagado')
            ->whereBetween('fecha_pago', [$start->toDateString(), $end->toDateString()])
            ->sum('monto');

        $ingresosPorTipo = Payment::query()
            ->select(DB::raw('COALESCE(membership_plans.tipo, "sin_plan") as tipo'), DB::raw('SUM(payments.monto) as total'))
            ->leftJoin('memberships', 'memberships.id', '=', 'payments.membership_id')
            ->leftJoin('membership_plans', 'membership_plans.id', '=', 'memberships.membership_plan_id')
            ->where('payments.estado', 'pagado')
            ->whereBetween('payments.fecha_pago', [$start->toDateString(), $end->toDateString()])
            ->groupBy(DB::raw('COALESCE(membership_plans.tipo, "sin_plan")'))
            ->get();

        $totalIngresosFloat = (float) $totalIngresos;

        $ingresosPorContrato = $ingresosPorTipo->map(function ($row) use ($totalIngresosFloat) {
            $label = match ($row->tipo) {
                'mensual' => 'Mensual',
                'semestral' => 'Semestral',
                'anual' => 'Anual',
                'sin_plan' => 'General',
                default => 'General',
            };

            $colorHex = match ($row->tipo) {
                'mensual' => '#3B82F6',
                'semestral' => '#A855F7',
                'anual' => '#00BFA5',
                'sin_plan' => '#00BFA5',
                default => '#00BFA5',
            };

            $monto = (float) $row->total;
            $porcentaje = $totalIngresosFloat > 0 ? round(($monto / $totalIngresosFloat) * 100, 1) : 0;

            return [
                'tipo' => $label,
                'monto' => 'L '.number_format($monto, 0, '.', ','),
                'porcentaje' => $porcentaje,
                'color_hex' => $colorHex,
            ];
        })->values();

        $clientesEnMora = Payment::query()
            ->join('memberships', 'memberships.id', '=', 'payments.membership_id')
            ->where('payments.estado', 'vencido')
            ->distinct('memberships.client_id')
            ->count('memberships.client_id');

        $montoPendiente = Payment::query()
            ->where(function ($q) {
                $q->where('estado', 'vencido')
                    ->orWhere(function ($sub) {
                        $sub->where('estado', 'pendiente')
                            ->whereDate('fecha_vencimiento', '<=', now()->toDateString());
                    });
            })
            ->sum('monto');

        $clientesNuevos = Client::query()
            ->whereBetween('created_at', [$start, $end->copy()->endOfDay()])
            ->count();

        return Inertia::render('Reportes/Reportes Financieros', [
            'periodoActivo' => $periodo,
            'periodos' => ['Esta Semana', 'Este Mes', 'Trimestre', 'Año'],
            'totalIngresos' => (float) $totalIngresos,
            'totalIngresosFormatted' => 'L '.number_format((float) $totalIngresos, 0, '.', ','),
            'ingresosPorContrato' => $ingresosPorContrato,
            'clientesEnMora' => (int) $clientesEnMora,
            'montoPendienteFormatted' => 'L '.number_format((float) $montoPendiente, 0, '.', ','),
            'clientesNuevos' => (int) $clientesNuevos,
            'range' => [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
            ],
        ]);
    }

    private function periodRange(string $periodo): array
    {
        $now = now();

        return match ($periodo) {
            'Esta Semana' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'Trimestre' => [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()],
            'Año' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
    }
}

