<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('curso', function (Blueprint $table) {
            $table->unsignedBigInteger('docente_id')->nullable()->after('ciclo_id');
            $table->foreign('docente_id')->references('id')->on('trabajador');
            $table->enum('estado', ['activo', 'inactivo', 'completado'])->default('activo')->after('fecha_fin');
        });
    }

    public function down(): void
    {
        Schema::table('curso', function (Blueprint $table) {
            $table->dropForeign(['docente_id']);
            $table->dropColumn(['docente_id', 'estado']);
        });
    }
};