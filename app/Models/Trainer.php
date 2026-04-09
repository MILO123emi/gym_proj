<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'user_id',
        'especialidad',
        'bio',
        'estado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    /** Usuario vinculado a este entrenador */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Planes de entrenamiento creados por este entrenador */
    public function trainingPlans()
    {
        return $this->hasMany(TrainingPlan::class, 'trainer_id');
    }

    /** Clientes asignados a este entrenador */
    public function planAssignments()
    {
        return $this->hasMany(PlanAssignment::class, 'trainer_id');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return $this->user?->name ?? '';
    }

    public function isActive(): bool
    {
        return $this->estado === 'activo';
    }
}
