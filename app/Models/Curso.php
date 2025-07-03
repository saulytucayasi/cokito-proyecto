<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'curso';
    
    protected $fillable = [
        'descripcion',
        'nivel',
        'nombre',
        'costo',
        'duracion',
        'modalidad',
        'fecha_inicio',
        'fecha_fin',
        'ciclo_id',
        'docente_id',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'curso_estudiante', 'curso_id', 'estudiante_id')
                    ->withPivot('progreso', 'calificacion_final', 'estado', 'matricula_id')
                    ->withTimestamps();
    }

    public function cursoEstudiantes()
    {
        return $this->hasMany(CursoEstudiante::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('orden');
    }

    public function materiales()
    {
        return $this->hasMany(Material::class)->orderBy('orden');
    }

    public function docente()
    {
        return $this->belongsTo(Trabajador::class, 'docente_id');
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class)->orderBy('orden');
    }

    public function getProgresoPromedio()
    {
        return $this->cursoEstudiantes()->avg('progreso') ?? 0;
    }
}
