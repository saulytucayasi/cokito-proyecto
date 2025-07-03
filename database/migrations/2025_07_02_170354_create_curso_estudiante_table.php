<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('curso_estudiante', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('curso_id');
            $table->decimal('progreso', 5, 2);
            $table->decimal('calificacion_final', 4, 2)->nullable();
            $table->string('estado');
            $table->unsignedBigInteger('matricula_id');
            $table->foreign('estudiante_id')->references('id')->on('estudiante');
            $table->foreign('curso_id')->references('id')->on('curso');
            $table->foreign('matricula_id')->references('id')->on('matricula');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_estudiante');
    }
};
