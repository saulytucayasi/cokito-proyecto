<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';
    
    protected $fillable = [
        'nombre_material',
        'path_material',
        'tipo',
        'descripcion',
        'orden',
        'es_publico',
        'curso_id',
        'subido_por'
    ];

    protected $casts = [
        'es_publico' => 'boolean',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function subidoPor()
    {
        return $this->belongsTo(Trabajador::class, 'subido_por');
    }
}
