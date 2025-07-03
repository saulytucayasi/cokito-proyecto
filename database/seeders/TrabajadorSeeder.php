<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trabajador;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class TrabajadorSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios para trabajadores
        $usuarios = [
            [
                'usuario' => 'admin@cokito.com',
                'email' => 'admin@cokito.com',
                'password' => 'admin123',
                'rol' => 'admin'
            ],
            [
                'usuario' => 'carlos.rodriguez@cokito.com',
                'email' => 'carlos.rodriguez@cokito.com',
                'password' => 'docente123',
                'rol' => 'docente'
            ],
            [
                'usuario' => 'maria.gonzalez@cokito.com',
                'email' => 'maria.gonzalez@cokito.com',
                'password' => 'docente123',
                'rol' => 'docente'
            ]
        ];

        foreach ($usuarios as $userData) {
            Usuario::create($userData);
        }

        // Crear trabajadores (solo admin + 2 docentes)
        $trabajadores = [
            [
                'nombre' => 'Administrador Sistema',
                'apellido' => 'Admin',
                'correo' => 'admin@cokito.com',
                'telefono' => '999999999',
                'estado' => 'activo',
                'usuario_id' => 1
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'correo' => 'carlos.rodriguez@cokito.com',
                'telefono' => '987654321',
                'estado' => 'activo',
                'usuario_id' => 2
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'correo' => 'maria.gonzalez@cokito.com',
                'telefono' => '987654322',
                'estado' => 'activo',
                'usuario_id' => 3
            ]
        ];

        foreach ($trabajadores as $trabajador) {
            Trabajador::create($trabajador);
        }
    }
}