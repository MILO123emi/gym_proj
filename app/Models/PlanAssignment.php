<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanAssignment extends Model
{
    protected $fillable = [
        'client_id',
        'training_plan_id',
        'trainer_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    /** Cliente al que pertenece esta asignación */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /** Plan de entrenamiento asignado */
    public function trainingPlan()
    {
        return $this->belongsTo(TrainingPlan::class, 'training_plan_id');
    }

    /** Entrenador responsable */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->estado === 'activo';
    }
}
