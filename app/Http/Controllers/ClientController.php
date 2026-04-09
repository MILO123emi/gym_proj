<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Collection;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::query()
            ->orderBy('created_at', 'desc')
            ->get(['id', 'nombre', 'apellido', 'telefono', 'email', 'cedula', 'direccion', 'contacto_emergencia']);

        return Inertia::render('Modificacion/Modificar Clientes', [
            'clients' => $clients->map(function (Client $c) {
                return [
                    'id' => $c->id,
                    'nombre' => $c->nombre,
                    'apellido' => $c->apellido,
                    'full_name' => $c->full_name,
                    'telefono' => $c->telefono,
                    'email' => $c->email,
                    'cedula' => $c->cedula,
                    'direccion' => $c->direccion,
                    'contacto_emergencia' => $c->contacto_emergencia,
                ];
            }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $defaults = [
            ['nombre' => 'Plan Mensual', 'tipo' => 'mensual', 'precio' => 600.00, 'duracion_dias' => 30],
            ['nombre' => 'Plan Semestral', 'tipo' => 'semestral', 'precio' => 3200.00, 'duracion_dias' => 180],
            ['nombre' => 'Plan Anual', 'tipo' => 'anual', 'precio' => 6000.00, 'duracion_dias' => 365],
        ];

        foreach ($defaults as $plan) {
            MembershipPlan::query()->firstOrCreate(
                ['nombre' => $plan['nombre'], 'tipo' => $plan['tipo']],
                [
                    'descripcion' => 'Plan estándar',
                    'precio' => $plan['precio'],
                    'duracion_dias' => $plan['duracion_dias'],
                    'activo' => true,
                ]
            );
        }

        $membershipPlans = MembershipPlan::query()
            ->where('activo', true)
            ->orderBy('precio')
            ->get(['id', 'nombre', 'descripcion', 'precio', 'duracion_dias', 'tipo']);

        return Inertia::render('Clientes/NuevoCliente', [
            'membershipPlans' => $membershipPlans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();

        [$nombre, $apellido] = $this->splitFullName($data['nombre_completo']);

        DB::transaction(function () use ($request, $data, $nombre, $apellido) {
            $client = Client::create([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $data['telefono'] ?? null,
                'email' => $data['email'],
                'cedula' => $data['cedula'],
                'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'contacto_emergencia' => $data['contacto_emergencia'] ?? null,
                'estado' => 'activo',
                'user_id' => $request->user()->id,
            ]);

            $plan = $this->resolveMembershipPlan($data);

            $fechaInicio = now()->toDateString();
            $fechaFin = now()->addDays((int) $plan->duracion_dias)->toDateString();

            $membership = Membership::create([
                'client_id' => $client->id,
                'membership_plan_id' => $plan->id,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'estado' => 'pendiente',
                'user_id' => $request->user()->id,
            ]);

            Payment::create([
                'membership_id' => $membership->id,
                'monto' => $plan->precio,
                'metodo_pago' => $data['metodo_pago'],
                'estado' => 'pagado',
                'fecha_pago' => now()->toDateString(),
                'fecha_vencimiento' => now()->toDateString(),
                'referencia' => null,
                'user_id' => $request->user()->id,
            ]);

            Payment::create([
                'membership_id' => $membership->id,
                'monto' => $plan->precio,
                'metodo_pago' => 'efectivo',
                'estado' => 'pendiente',
                'fecha_pago' => null,
                'fecha_vencimiento' => now()->addDays((int) $plan->duracion_dias)->toDateString(),
                'referencia' => null,
                'user_id' => $request->user()->id,
            ]);

            $membership->recalculateEstado();
        });

        return back()->with('success', 'Cliente registrado correctamente.');
    }

    private function resolveMembershipPlan(array $data): MembershipPlan
    {
        if (!empty($data['membership_plan_id'])) {
            return MembershipPlan::query()->findOrFail($data['membership_plan_id']);
        }

        $tipo = $data['plan_tipo'] ?? 'mensual';

        $defaults = match ($tipo) {
            'semestral' => ['nombre' => 'Plan Semestral', 'duracion_dias' => 180, 'precio' => 3200.00],
            'anual' => ['nombre' => 'Plan Anual', 'duracion_dias' => 365, 'precio' => 6000.00],
            default => ['nombre' => 'Plan Mensual', 'duracion_dias' => 30, 'precio' => 600.00],
        };

        return MembershipPlan::query()->firstOrCreate(
            ['tipo' => $tipo, 'nombre' => $defaults['nombre']],
            [
                'descripcion' => 'Plan creado desde registro de cliente',
                'precio' => $defaults['precio'],
                'duracion_dias' => $defaults['duracion_dias'],
                'activo' => true,
            ]
        );
    }

    private function splitFullName(string $fullName): array
    {
        $fullName = trim(preg_replace('/\s+/', ' ', $fullName) ?? '');

        if ($fullName === '') {
            return ['', ''];
        }

        $parts = explode(' ', $fullName, 2);

        $nombre = $parts[0] ?? '';
        $apellido = $parts[1] ?? '';

        return [$nombre, $apellido];
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    public function consultas()
    {
        $user = auth()->user();

        $query = Client::query()
            ->with([
                'activeMembership.plan:id,nombre',
                'memberships.payments' => function ($q) {
                    $q->orderByDesc('fecha_pago');
                },
                'activePlanAssignment.trainingPlan:id,nombre',
                'activePlanAssignment.trainer.user:id,name',
            ])
            ->orderBy('created_at', 'desc');

        if ($user?->role === 'trainer') {
            $trainerId = $user->trainer?->id;
            $query->whereHas('activePlanAssignment', function ($q) use ($trainerId) {
                $q->where('trainer_id', $trainerId);
            });
        }

        $clients = $query->get();

        return Inertia::render('Consultas/Consultas', [
            'clients' => $clients->map(fn (Client $c) => $this->mapClientForConsultas($c)),
        ]);
    }

    private function mapClientForConsultas(Client $c): array
    {
        $membership = $c->activeMembership;
        $payments = $membership?->payments ?? collect();

        $hasOverdue = $payments instanceof Collection
            ? $payments->contains(fn ($p) => $p->estado === 'vencido')
            : false;

        $estado = 'Inactivo';
        if ($hasOverdue || ($membership && $membership->estado === 'vencida')) {
            $estado = 'Mora';
        } elseif ($c->estado === 'activo' && $membership && $membership->estado === 'activa') {
            $estado = 'Activo';
        }

        $pagos = ($payments instanceof Collection ? $payments->take(5) : collect())
            ->map(function ($p) {
                $metodo = match ($p->metodo_pago) {
                    'efectivo' => 'Efectivo',
                    'tarjeta_credito' => 'Tarjeta',
                    'tarjeta_debito' => 'Tarjeta',
                    default => $p->metodo_pago,
                };

                return [
                    'monto' => 'L '.number_format((float) $p->monto, 2),
                    'fecha' => optional($p->fecha_pago)->toDateString() ?? '',
                    'metodo' => $metodo,
                ];
            })->values();

        return [
            'id' => $c->id,
            'nombre' => $c->full_name,
            'email' => $c->email,
            'tel' => $c->telefono,
            'direccion' => $c->direccion,
            'estado' => $estado,
            'plan' => $membership?->plan?->nombre,
            'vencimiento' => optional($membership?->fecha_fin)->toDateString() ?? null,
            'rutina' => $c->activePlanAssignment?->trainingPlan?->nombre,
            'entrenador' => $c->activePlanAssignment?->trainer?->full_name
                ?: $c->activePlanAssignment?->trainer?->user?->name,
            'pagos' => $pagos,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $data = $request->validated();

        $client->update($data);

        return back()->with('success', 'Cliente actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
