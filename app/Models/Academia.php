<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    protected $table = 'academia';
    
    protected $fillable = [
        'nombre',
        'Direccion',
        'telefono',
        'director'
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
