<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Esta migración actualiza los materiales existentes que tienen subido_por NULL
        // Para materiales legacy, mantenemos subido_por como NULL y la verificación 
        // se hará solo por permisos de curso
        
        // No necesitamos hacer nada aquí, la lógica en el controlador ya maneja 
        // los casos donde subido_por es NULL
        
        // Opcional: Si quieres asignar todos los materiales NULL a un docente específico
        // puedes descomentar las siguientes líneas y ajustar el trabajador_id
        
        /*
        DB::table('material')
            ->whereNull('subido_por')
            ->update(['subido_por' => 1]); // Cambiar 1 por el ID del trabajador/docente apropiado
        */
    }

    public function down(): void
    {
        // No hay rollback necesario para esta migración
    }
};