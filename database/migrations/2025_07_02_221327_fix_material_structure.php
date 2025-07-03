<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Primero eliminar la foreign key existente
        Schema::table('material', function (Blueprint $table) {
            $table->dropForeign(['curso_estudiante_id']);
            $table->dropColumn('curso_estudiante_id');
        });

        // Agregar nuevas columnas
        Schema::table('material', function (Blueprint $table) {
            $table->unsignedBigInteger('curso_id')->after('id');
            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
            $table->enum('tipo', ['documento', 'video', 'imagen', 'archivo'])->default('documento')->after('nombre_material');
            $table->text('descripcion')->nullable()->after('tipo');
            $table->boolean('es_publico')->default(true)->after('orden');
            $table->unsignedBigInteger('subido_por')->nullable()->after('es_publico');
            $table->foreign('subido_por')->references('id')->on('trabajador');
        });
    }

    public function down(): void
    {
        Schema::table('material', function (Blueprint $table) {
            $table->dropForeign(['curso_id']);
            $table->dropForeign(['subido_por']);
            $table->dropColumn(['curso_id', 'tipo', 'descripcion', 'es_publico', 'subido_por']);
            
            $table->unsignedBigInteger('curso_estudiante_id');
            $table->foreign('curso_estudiante_id')->references('id')->on('curso_estudiante');
        });
    }
};