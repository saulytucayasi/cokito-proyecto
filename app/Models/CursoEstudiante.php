<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoEstudiante extends Model
{
    protected $table = 'curso_estudiante';
    
    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'progreso',
        'calificacion_final',
        'estado',
        'matricula_id'
    ];

    protected $casts = [
        'progreso' => 'decimal:2',
        'calificacion_final' => 'decimal:2'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function calcularProgresoPorSesiones()
    {
        $totalSesiones = $this->curso->sesiones()->count();
        if ($totalSesiones === 0) return 0;

        $sesionesCompletadas = ProgresoSesion::where('estudiante_id', $this->estudiante_id)
            ->whereIn('sesion_id', $this->curso->sesiones()->pluck('id'))
            ->where('completada', true)
            ->count();

        return ($sesionesCompletadas / $totalSesiones) * 100;
    }

    public function actualizarProgreso()
    {
        $nuevoProgreso = $this->calcularProgresoPorSesiones();
        $this->update(['progreso' => $nuevoProgreso]);
        return $nuevoProgreso;
    }
}
