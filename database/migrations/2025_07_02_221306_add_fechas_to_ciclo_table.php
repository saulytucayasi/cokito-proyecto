<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ciclo', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable()->after('nivel_complejidad');
            $table->date('fecha_fin')->nullable()->after('fecha_inicio');
            $table->text('descripcion')->nullable()->after('nombre_area');
        });
    }

    public function down(): void
    {
        Schema::table('ciclo', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'fecha_fin', 'descripcion']);
        });
    }
};