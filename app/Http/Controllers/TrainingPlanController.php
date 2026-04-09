<?php

namespace App\Http\Controllers;

use App\Models\TrainingPlan;
use App\Models\Client;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $trainer = $user?->trainer;
        if (!$trainer && $user?->role === 'trainer') {
            $trainer = Trainer::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['especialidad' => 'General', 'bio' => null, 'estado' => 'activo']
            );
        }

        $trainerId = $trainer?->id;

        $fallbackTrainerId = $trainerId ?: Trainer::query()
            ->where('estado', 'activo')
            ->whereHas('user', function ($q) {
                $q->where('role', 'trainer');
            })
            ->value('id');

        if (TrainingPlan::query()->count() === 0 && $fallbackTrainerId) {
            TrainingPlan::query()->create([
                'nombre' => 'Plan Libre Inicial',
                'descripcion' => 'Rutina base sin asistencia directa',
                'tipo' => 'libre',
                'dias_semana' => 3,
                'trainer_id' => $fallbackTrainerId,
                'activo' => true,
            ]);

            TrainingPlan::query()->create([
                'nombre' => 'Plan Asistido Inicial',
                'descripcion' => 'Rutina base con seguimiento de entrenador',
                'tipo' => 'asistido',
                'dias_semana' => 4,
                'trainer_id' => $fallbackTrainerId,
                'activo' => true,
            ]);
        }

        $plansQuery = TrainingPlan::query()
            ->where('activo', true)
            ->orderBy('nombre');

        if ($user?->role === 'trainer') {
            $plansQuery->where('trainer_id', $trainerId);
        }

        $plans = $plansQuery->get(['id', 'nombre', 'descripcion', 'tipo', 'dias_semana', 'trainer_id']);

        $clientsQuery = Client::query()
            ->with(['activeMembership', 'activePlanAssignment.trainingPlan'])
            ->orderBy('nombre');

        if ($user?->role === 'trainer') {
            $clientsQuery->whereHas('activePlanAssignment', function ($q) use ($trainerId) {
                $q->where('trainer_id', $trainerId);
            });
        }

        $clients = $clientsQuery->get();

        $trainersQuery = Trainer::query()
            ->with('user:id,name')
            ->where('estado', 'activo')
            ->whereHas('user', function ($q) {
                $q->where('role', 'trainer')->where('active', true);
            })
            ->orderBy('id');

        if ($user?->role === 'trainer') {
            $trainersQuery->where('id', $trainerId);
        }

        $trainers = $trainersQuery->get();

        return Inertia::render('Rutinas/Rutinas', [
            'clients' => $clients->map(fn (Client $c) => $this->mapClientForRutinas($c))->values(),
            'plans' => $plans->map(fn (TrainingPlan $p) => $this->mapPlanForRutinas($p))->values(),
            'trainers' => $trainers->map(fn (Trainer $t) => [
                'id' => $t->id,
                'name' => $t->full_name ?: $t->user?->name,
            ])->values(),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingPlan $trainingPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingPlan $trainingPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingPlan $trainingPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingPlan $trainingPlan)
    {
        //
    }

    private function mapClientForRutinas(Client $c): array
    {
        $estado = $c->activeMembership && $c->activeMembership->estado === 'activa'
            ? 'Membresía activa'
            : 'Membresía vencida';

        return [
            'id' => $c->id,
            'nombre' => $c->full_name,
            'estado' => $estado,
            'current_plan_id' => $c->activePlanAssignment?->training_plan_id,
            'current_plan_nombre' => $c->activePlanAssignment?->trainingPlan?->nombre,
        ];
    }

    private function mapPlanForRutinas(TrainingPlan $p): array
    {
        return [
            'id' => $p->id,
            'nombre' => $p->nombre,
            'descripcion' => $p->descripcion,
            'tipo' => $p->tipo,
            'dias_semana' => $p->dias_semana,
        ];
    }
}
