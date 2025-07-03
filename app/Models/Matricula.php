<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matricula';
    
    protected $fillable = [
        'fecha',
        'monto',
        'metodo_pago',
        'estado_pago',
        'nombre_pago',
        'trabajador_id',
        'ciclo_id',
        'estudiante_id'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function cursoEstudiantes()
    {
        return $this->hasMany(CursoEstudiante::class);
    }
}
