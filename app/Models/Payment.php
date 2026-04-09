<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected static function booted(): void
    {
        static::saved(function (Payment $payment) {
            $payment->membership?->recalculateEstado();
        });

        static::deleted(function (Payment $payment) {
            $payment->membership?->recalculateEstado();
        });
    }

    protected $fillable = [
        'membership_id',
        'monto',
        'metodo_pago',
        'estado',
        'fecha_pago',
        'fecha_vencimiento',
        'referencia',
        'user_id',
    ];

    protected $casts = [
        'monto'             => 'decimal:2',
        'fecha_pago'        => 'date',
        'fecha_vencimiento' => 'date',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    /** Membresía a la que pertenece este pago */
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    /** Empleado que procesó el pago */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function isPaid(): bool
    {
        return $this->estado === 'pagado';
    }

    public function isOverdue(): bool
    {
        return $this->estado === 'vencido';
    }

    public function isPending(): bool
    {
        return $this->estado === 'pendiente';
    }
}
