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
        Schema::create('estudiante', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('dni')->nullable();
            $table->string('apellido')->nullable();
            $table->string('correo')->nullable();
            $table->string('estado_matricula')->default('inactivo');
            $table->string('telefono')->nullable();
            $table->string('id_contra')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->unsignedBigInteger('academia_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('academia_id')->references('id')->on('academia');
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante');
    }
};
