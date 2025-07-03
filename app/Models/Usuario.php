<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    protected $table = 'usuario';
    
    protected $fillable = [
        'usuario',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }

    public function trabajador()
    {
        return $this->hasOne(Trabajador::class);
    }
}