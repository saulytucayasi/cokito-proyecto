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
            ],
            [
                'usuario' => 'luis.martinez@cokito.com',
                'email' => 'luis.martinez@cokito.com',
                'password' => 'docente123',
                'rol' => 'docente'
            ],
            [
                'usuario' => 'ana.lopez@cokito.com',
                'email' => 'ana.lopez@cokito.com',
                'password' => 'docente123',
                'rol' => 'docente'
            ],
            [
                'usuario' => 'pedro.sanchez@cokito.com',
                'email' => 'pedro.sanchez@cokito.com',
                'password' => 'docente123',
                'rol' => 'docente'
            ]
        ];

        foreach ($usuarios as $userData) {
            Usuario::create($userData);
        }

        // Crear trabajadores
        $trabajadores = [
            [
                'nombre' => 'Administrador Sistema',
                'correo' => 'admin@cokito.com',
                'telefono' => '999999999',
                'estado' => 'activo',
                'usuario_id' => 1
            ],
            [
                'nombre' => 'Carlos Rodríguez',
                'correo' => 'carlos.rodriguez@cokito.com',
                'telefono' => '987654321',
                'estado' => 'activo',
                'usuario_id' => 2
            ],
            [
                'nombre' => 'María González',
                'correo' => 'maria.gonzalez@cokito.com',
                'telefono' => '987654322',
                'estado' => 'activo',
                'usuario_id' => 3
            ],
            [
                'nombre' => 'Luis Martínez',
                'correo' => 'luis.martinez@cokito.com',
                'telefono' => '987654323',
                'estado' => 'activo',
                'usuario_id' => 4
            ],
            [
                'nombre' => 'Ana López',
                'correo' => 'ana.lopez@cokito.com',
                'telefono' => '987654324',
                'estado' => 'activo',
                'usuario_id' => 5
            ],
            [
                'nombre' => 'Pedro Sánchez',
                'correo' => 'pedro.sanchez@cokito.com',
                'telefono' => '987654325',
                'estado' => 'activo',
                'usuario_id' => 6
            ]
        ];

        foreach ($trabajadores as $trabajador) {
            Trabajador::create($trabajador);
        }
    }
}