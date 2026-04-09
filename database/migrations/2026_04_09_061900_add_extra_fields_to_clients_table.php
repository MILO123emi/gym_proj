<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('direccion')->nullable()->after('fecha_nacimiento');
            $table->string('contacto_emergencia')->nullable()->after('direccion');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['direccion', 'contacto_emergencia']);
        });
    }
};

