<?php

namespace App\Http\Controllers;

use App\Models\PlanAssignment;
use App\Http\Requests\StorePlanAssignmentRequest;
use App\Models\TrainingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePlanAssignmentRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $plan = TrainingPlan::query()->findOrFail($data['training_plan_id']);

        $trainerId = (int) $data['trainer_id'];

        if ($user->role === 'trainer') {
            if (!$user->trainer || $trainerId !== (int) $user->trainer->id) {
                abort(403);
            }
        }

        DB::transaction(function () use ($data, $trainerId) {
            PlanAssignment::query()
                ->where('client_id', $data['client_id'])
                ->where('estado', 'activo')
                ->update([
                    'estado' => 'finalizado',
                    'fecha_fin' => now()->toDateString(),
                ]);

            PlanAssignment::create([
                'client_id' => $data['client_id'],
                'training_plan_id' => $data['training_plan_id'],
                'trainer_id' => $trainerId,
                'fecha_inicio' => now()->toDateString(),
                'fecha_fin' => null,
                'estado' => 'activo',
                'notas' => $data['notas'] ?? null,
            ]);
        });

        return back()->with('success', 'Plan asignado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanAssignment $planAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanAssignment $planAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanAssignment $planAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanAssignment $planAssignment)
    {
        //
    }
}
