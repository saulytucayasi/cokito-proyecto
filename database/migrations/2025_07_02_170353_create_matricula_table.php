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
        Schema::create('matricula', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago');
            $table->string('estado_pago');
            $table->string('nombre_pago');
            $table->unsignedBigInteger('trabajador_id');
            $table->unsignedBigInteger('ciclo_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->foreign('ciclo_id')->references('id')->on('ciclo');
            $table->foreign('estudiante_id')->references('id')->on('estudiante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula');
    }
};
