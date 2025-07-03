<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progreso_sesiones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('sesion_id');
            $table->boolean('completada')->default(false);
            $table->datetime('fecha_completada')->nullable();
            $table->text('notas')->nullable();
            $table->decimal('calificacion', 4, 2)->nullable();
            
            $table->foreign('estudiante_id')->references('id')->on('estudiante')->onDelete('cascade');
            $table->foreign('sesion_id')->references('id')->on('sesiones')->onDelete('cascade');
            
            $table->unique(['estudiante_id', 'sesion_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progreso_sesiones');
    }
};