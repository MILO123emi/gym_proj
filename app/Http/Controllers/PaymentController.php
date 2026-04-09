<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Payment;
use App\Http\Requests\PayPaymentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::query()
            ->with([
                'client:id,nombre,apellido,telefono',
                'plan:id,precio',
                'payments' => function ($q) {
                    $q->orderByDesc('fecha_vencimiento');
                },
            ])
            ->orderByDesc('created_at')
            ->get();

        $clients = $memberships->map(function (Membership $membership) {
            $client = $membership->client;
            $payment = $membership->payments
                ->first(fn (Payment $p) => in_array($p->estado, ['pendiente', 'vencido'], true));
            $latestPayment = $membership->payments->first();

            $daysLate = 0;
            if ($payment?->fecha_vencimiento) {
                $daysLate = max(0, Carbon::parse($payment->fecha_vencimiento)->diffInDays(now(), false));
            }

            $estado = 'Al día';
            if ($payment?->estado === 'vencido') {
                $estado = 'Mora';
            } elseif ($payment?->estado === 'pendiente') {
                $estado = 'Pendiente';
            }

            $monto = $payment?->monto
                ?? $latestPayment?->monto
                ?? $membership->plan?->precio
                ?? 0;

            return [
                'membership_id' => $membership->id,
                'payment_id' => $payment?->id,
                'client_id' => $client?->id,
                'nombre' => $client ? ($client->nombre.' '.$client->apellido) : 'N/A',
                'tel' => $client?->telefono,
                'estado' => $estado,
                'dias' => $daysLate,
                'monto' => (float) $monto,
                'metodo_pago' => $payment?->metodo_pago,
            ];
        })->filter(fn ($row) => !empty($row['client_id']))->values();

        return Inertia::render('Cobro/Cobranza', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'membership_id' => ['required', 'integer', 'exists:memberships,id'],
            'metodo_pago' => ['required', 'in:efectivo,tarjeta_credito,tarjeta_debito'],
            'referencia' => ['nullable', 'string', 'max:255'],
        ]);

        $membership = Membership::query()->findOrFail($data['membership_id']);
        $pendingPayment = $membership->payments()
            ->whereIn('estado', ['pendiente', 'vencido'])
            ->orderBy('fecha_vencimiento')
            ->first();

        if (!$pendingPayment) {
            return back()->with('error', 'Este cliente está al día. No hay pagos pendientes por registrar.');
        }

        $pendingPayment->update([
            'metodo_pago' => $data['metodo_pago'],
            'referencia' => $data['referencia'] ?? null,
            'estado' => 'pagado',
            'fecha_pago' => now()->toDateString(),
            'user_id' => $request->user()->id,
        ]);

        $this->createNextPendingPayment(
            $membership,
            $request->user()->id,
            $pendingPayment->fecha_vencimiento ? Carbon::parse($pendingPayment->fecha_vencimiento) : now()
        );

        return back()->with('success', 'Pago registrado correctamente.');
    }

    public function pay(PayPaymentRequest $request, Payment $payment)
    {
        if (!in_array($payment->estado, ['pendiente', 'vencido'], true)) {
            return back()->with('error', 'Este pago no está pendiente.');
        }

        DB::transaction(function () use ($request, $payment) {
            $payment->update([
                'metodo_pago' => $request->validated()['metodo_pago'],
                'referencia' => $request->validated()['referencia'] ?? null,
                'estado' => 'pagado',
                'fecha_pago' => now()->toDateString(),
                'user_id' => $request->user()->id,
            ]);

            $this->createNextPendingPayment(
                $payment->membership,
                $request->user()->id,
                $payment->fecha_vencimiento ? Carbon::parse($payment->fecha_vencimiento) : now()
            );
        });

        return back()->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    private function createNextPendingPayment(Membership $membership, int $userId, Carbon $baseDate): void
    {
        $hasOpenPayment = $membership->payments()
            ->whereIn('estado', ['pendiente', 'vencido'])
            ->exists();

        if ($hasOpenPayment) {
            return;
        }

        $diasPlan = (int) ($membership->plan?->duracion_dias ?? 30);

        Payment::create([
            'membership_id' => $membership->id,
            'monto' => $membership->plan?->precio ?? 0,
            'metodo_pago' => 'efectivo',
            'estado' => 'pendiente',
            'fecha_pago' => null,
            'fecha_vencimiento' => $baseDate->copy()->addDays($diasPlan)->toDateString(),
            'referencia' => null,
            'user_id' => $userId,
        ]);
    }
}
