<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajador';
    
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'estado',
        'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function cursosAsignados()
    {
        return $this->hasMany(Curso::class, 'docente_id');
    }

    public function materialesSubidos()
    {
        return $this->hasMany(Material::class, 'subido_por');
    }

    public function esDocente()
    {
        return $this->cursosAsignados()->exists();
    }
}
