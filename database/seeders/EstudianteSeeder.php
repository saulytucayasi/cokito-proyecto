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
        // Crear usuarios para estudiantes
        $usuariosEstudiantes = [
            [
                'usuario' => 'juan.perez@gmail.com',
                'email' => 'juan.perez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'maria.rodriguez@gmail.com',
                'email' => 'maria.rodriguez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'carlos.garcia@gmail.com',
                'email' => 'carlos.garcia@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'ana.martinez@gmail.com',
                'email' => 'ana.martinez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'luis.gonzalez@gmail.com',
                'email' => 'luis.gonzalez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'sofia.lopez@gmail.com',
                'email' => 'sofia.lopez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'pedro.sanchez@gmail.com',
                'email' => 'pedro.sanchez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'laura.fernandez@gmail.com',
                'email' => 'laura.fernandez@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'diego.morales@gmail.com',
                'email' => 'diego.morales@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ],
            [
                'usuario' => 'carmen.torres@gmail.com',
                'email' => 'carmen.torres@gmail.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante'
            ]
        ];

        $usuarioId = 7; // Empezar después de los trabajadores
        foreach ($usuariosEstudiantes as $userData) {
            Usuario::create(array_merge($userData, ['id' => $usuarioId]));
            $usuarioId++;
        }

        // Crear estudiantes
        $estudiantes = [
            [
                'nombre' => 'Juan Carlos',
                'apellido' => 'Pérez Gómez',
                'fecha_nacimiento' => '1995-03-15',
                'dni' => '12345678',
                'correo' => 'juan.perez@gmail.com',
                'telefono' => '987123456',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-02-01',
                'academia_id' => 1,
                'usuario_id' => 7
            ],
            [
                'nombre' => 'María Isabel',
                'apellido' => 'Rodríguez Silva',
                'fecha_nacimiento' => '1992-07-22',
                'dni' => '23456789',
                'correo' => 'maria.rodriguez@gmail.com',
                'telefono' => '987123457',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-02-05',
                'academia_id' => 1,
                'usuario_id' => 8
            ],
            [
                'nombre' => 'Carlos Eduardo',
                'apellido' => 'García Mendoza',
                'fecha_nacimiento' => '1998-11-10',
                'dni' => '34567890',
                'correo' => 'carlos.garcia@gmail.com',
                'telefono' => '987123458',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-02-10',
                'academia_id' => 1,
                'usuario_id' => 9
            ],
            [
                'nombre' => 'Ana Sofía',
                'apellido' => 'Martínez López',
                'fecha_nacimiento' => '1996-05-18',
                'dni' => '45678901',
                'correo' => 'ana.martinez@gmail.com',
                'telefono' => '987123459',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-02-15',
                'academia_id' => 1,
                'usuario_id' => 10
            ],
            [
                'nombre' => 'Luis Fernando',
                'apellido' => 'González Castro',
                'fecha_nacimiento' => '1994-09-03',
                'dni' => '56789012',
                'correo' => 'luis.gonzalez@gmail.com',
                'telefono' => '987123460',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-02-20',
                'academia_id' => 1,
                'usuario_id' => 11
            ],
            [
                'nombre' => 'Sofía Alejandra',
                'apellido' => 'López Herrera',
                'fecha_nacimiento' => '1997-12-25',
                'dni' => '67890123',
                'correo' => 'sofia.lopez@gmail.com',
                'telefono' => '987123461',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-02-25',
                'academia_id' => 1,
                'usuario_id' => 12
            ],
            [
                'nombre' => 'Pedro Antonio',
                'apellido' => 'Sánchez Ruiz',
                'fecha_nacimiento' => '1993-04-14',
                'dni' => '78901234',
                'correo' => 'pedro.sanchez@gmail.com',
                'telefono' => '987123462',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-03-01',
                'academia_id' => 1,
                'usuario_id' => 13
            ],
            [
                'nombre' => 'Laura Cristina',
                'apellido' => 'Fernández Vargas',
                'fecha_nacimiento' => '1999-08-07',
                'dni' => '89012345',
                'correo' => 'laura.fernandez@gmail.com',
                'telefono' => '987123463',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-03-05',
                'academia_id' => 1,
                'usuario_id' => 14
            ],
            [
                'nombre' => 'Diego Alejandro',
                'apellido' => 'Morales Jiménez',
                'fecha_nacimiento' => '1991-01-30',
                'dni' => '90123456',
                'correo' => 'diego.morales@gmail.com',
                'telefono' => '987123464',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-03-10',
                'academia_id' => 1,
                'usuario_id' => 15
            ],
            [
                'nombre' => 'Carmen Elena',
                'apellido' => 'Torres Ramírez',
                'fecha_nacimiento' => '1996-10-12',
                'dni' => '01234567',
                'correo' => 'carmen.torres@gmail.com',
                'telefono' => '987123465',
                'estado_matricula' => 'activo',
                'fecha_registro' => '2024-03-15',
                'academia_id' => 1,
                'usuario_id' => 16
            ]
        ];

        foreach ($estudiantes as $estudiante) {
            Estudiante::create($estudiante);
        }
    }
}