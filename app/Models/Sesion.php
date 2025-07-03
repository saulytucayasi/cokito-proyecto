<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';
    
    protected $fillable = [
        'titulo',
        'nombre',
        'descripcion',
        'fecha_programada',
        'hora_inicio',
        'hora_fin',
        'duracion_minutos',
        'orden',
        'estado',
        'contenido',
        'curso_id'
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function progresoEstudiantes()
    {
        return $this->hasMany(ProgresoSesion::class);
    }

    public function estudiantesCompletaron()
    {
        return $this->progresoEstudiantes()->where('completada', true);
    }

    public function esCompletadaPorEstudiante($estudianteId)
    {
        return $this->progresoEstudiantes()
                    ->where('estudiante_id', $estudianteId)
                    ->where('completada', true)
                    ->exists();
    }

    public function marcarCompletadaPorEstudiante($estudianteId, $calificacion = null)
    {
        return $this->progresoEstudiantes()->updateOrCreate(
            ['estudiante_id' => $estudianteId],
            [
                'completada' => true,
                'fecha_completada' => now(),
                'calificacion' => $calificacion
            ]
        );
    }
}