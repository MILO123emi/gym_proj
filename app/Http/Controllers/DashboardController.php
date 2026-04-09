<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $clientesActivos = Client::query()->where('estado', 'activo')->count();
        $clientesInactivos = Client::query()->where('estado', '!=', 'activo')->count();
        $totalClientes = Client::query()->count();

        $pagosVencidos = Payment::query()
            ->with('membership.client:id,nombre,apellido')
            ->where('estado', 'vencido')
            ->orderBy('fecha_vencimiento')
            ->limit(6)
            ->get()
            ->map(function (Payment $payment) {
                $cliente = $payment->membership?->client;

                $diasAtraso = $payment->fecha_vencimiento
                    ? max(0, Carbon::parse($payment->fecha_vencimiento)->diffInDays(now(), false))
                    : 0;

                return [
                    'nombre' => $cliente ? trim($cliente->nombre.' '.$cliente->apellido) : 'Cliente',
                    'atraso' => $diasAtraso > 0 ? "{$diasAtraso} días de atraso" : 'Vencido',
                    'monto' => 'L '.number_format((float) $payment->monto, 2),
                ];
            })
            ->values();

        return Inertia::render('Panel/PanelGeneral', [
            'clientesActivos' => $clientesActivos,
            'clientesInactivos' => $clientesInactivos,
            'totalClientes' => $totalClientes,
            'pagosVencidos' => $pagosVencidos,
        ]);
    }
}

