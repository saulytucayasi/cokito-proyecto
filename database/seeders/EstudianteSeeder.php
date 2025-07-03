<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios para estudiantes (solo 2)
        $usuariosEstudiantes = [
            [
                'usuario' => 'juan.perez@gmail.com',
                'email' => 'juan.perez@gmail.com',
                'password' => 'estudiante123',
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'maria.rodriguez@gmail.com',
                'email' => 'maria.rodriguez@gmail.com',
                'password' => 'estudiante123',
                'rol' => 'estudiante'
            ]
        ];

        $usuarioId = 4; // Empezar después de admin + 2 docentes
        foreach ($usuariosEstudiantes as $userData) {
            Usuario::create(array_merge($userData, ['id' => $usuarioId]));
            $usuarioId++;
        }

        // Crear estudiantes (solo 2)
        $estudiantes = [
            [
                'nombre' => 'Juan Carlos',
                'apellido' => 'Pérez Gómez',
                'fecha_nacimiento' => '1995-03-15',
                'dni' => '12345678',
                'correo' => 'juan.perez@gmail.com',
                'telefono' => '987123456',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2025-02-01',
                'academia_id' => 1,
                'usuario_id' => 4
            ],
            [
                'nombre' => 'María Isabel',
                'apellido' => 'Rodríguez Silva',
                'fecha_nacimiento' => '1992-07-22',
                'dni' => '23456789',
                'correo' => 'maria.rodriguez@gmail.com',
                'telefono' => '987123457',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2025-02-05',
                'academia_id' => 1,
                'usuario_id' => 5
            ]
        ];

        foreach ($estudiantes as $estudiante) {
            Estudiante::create($estudiante);
        }
    }
}