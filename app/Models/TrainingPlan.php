<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'dias_semana',
        'trainer_id',
        'activo',
    ];

    protected $casts = [
        'dias_semana' => 'integer',
        'activo'      => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    /** Entrenador que creó este plan */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    /** Clientes a los que fue asignado este plan */
    public function assignments()
    {
        return $this->hasMany(PlanAssignment::class, 'training_plan_id');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function isAssisted(): bool
    {
        return $this->tipo === 'asistido';
    }
}
