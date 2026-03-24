<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_providers', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('servicio')->comment('Ej: mantenimiento AC, reparación máquinas');
            $table->text('notas')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_providers');
    }
};
