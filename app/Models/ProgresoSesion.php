<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoSesion extends Model
{
    protected $table = 'progreso_sesiones';
    
    protected $fillable = [
        'estudiante_id',
        'sesion_id',
        'completada',
        'fecha_completada',
        'notas',
        'calificacion'
    ];

    protected $casts = [
        'completada' => 'boolean',
        'fecha_completada' => 'datetime',
        'calificacion' => 'decimal:2',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }
}