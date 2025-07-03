<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $table = 'ciclo';
    
    protected $fillable = [
        'nombre_area',
        'descripcion',
        'nivel_complejidad',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
