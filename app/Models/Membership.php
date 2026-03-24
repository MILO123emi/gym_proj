<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'client_id',
        'membership_plan_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    /** Cliente dueño de esta membresía */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /** Plan al que pertenece esta membresía */
    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    /** Empleado que registró la membresía */
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Todos los pagos de esta membresía */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'membership_id');
    }

    /** Pagos vencidos de esta membresía */
    public function overduePayments()
    {
        return $this->hasMany(Payment::class, 'membership_id')
            ->where('estado', 'vencido');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->estado === 'activa';
    }

    public function isExpired(): bool
    {
        return $this->estado === 'vencida';
    }
}
