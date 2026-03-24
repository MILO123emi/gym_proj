<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportProvider extends Model
{
    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'servicio',
        'notas',
        'activo',
    ];

    protected $casts = [
        'activo'     => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Helpers ──────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->activo === true;
    }
}
