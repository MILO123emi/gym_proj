<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion_dias',
        'tipo',
        'activo',
    ];

    protected $casts = [
        'precio'       => 'decimal:2',
        'duracion_dias'=> 'integer',
        'activo'       => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    /** Membresías que usan este plan */
    public function memberships()
    {
        return $this->hasMany(Membership::class, 'membership_plan_id');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->activo === true;
    }
}
