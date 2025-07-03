<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    
    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'dni',
        'apellido',
        'correo',
        'estado_matricula',
        'telefono',
        'id_contra',
        'fecha_registro',
        'academia_id',
        'usuario_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_registro' => 'date'
    ];

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante', 'estudiante_id', 'curso_id')
                    ->withPivot('progreso', 'calificacion_final', 'estado', 'matricula_id')
                    ->withTimestamps();
    }

    public function cursoEstudiantes()
    {
        return $this->hasMany(CursoEstudiante::class);
    }

    public function progresoSesiones()
    {
        return $this->hasMany(ProgresoSesion::class);
    }

    public function cursosActivos()
    {
        return $this->cursos()->wherePivot('estado', 'activo');
    }
}
