<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matricula;
use App\Models\CursoEstudiante;

class MatriculaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear matrículas y asignaciones de cursos
        $matriculasData = [
            // Estudiante 1: Juan Carlos - Frontend
            [
                'estudiante_id' => 1,
                'ciclo_id' => 1,
                'cursos' => [1, 2], // HTML/CSS + JavaScript
                'trabajador_id' => 1,
                'fecha' => '2024-02-01',
                'monto' => 698.00,
                'metodo_pago' => 'Tarjeta de crédito',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Juan Carlos Pérez'
            ],
            // Estudiante 2: María Isabel - Frontend + Backend
            [
                'estudiante_id' => 2,
                'ciclo_id' => 1,
                'cursos' => [1, 2, 3], // HTML/CSS + JavaScript + React
                'trabajador_id' => 1,
                'fecha' => '2024-02-05',
                'monto' => 1197.00,
                'metodo_pago' => 'Transferencia bancaria',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'María Isabel Rodríguez'
            ],
            // Estudiante 3: Carlos Eduardo - Backend
            [
                'estudiante_id' => 3,
                'ciclo_id' => 2,
                'cursos' => [4, 6], // Laravel + Bases de Datos
                'trabajador_id' => 1,
                'fecha' => '2024-02-10',
                'monto' => 1048.00,
                'metodo_pago' => 'Tarjeta de crédito',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Carlos Eduardo García'
            ],
            // Estudiante 4: Ana Sofía - UX/UI
            [
                'estudiante_id' => 4,
                'ciclo_id' => 4,
                'cursos' => [9, 10], // UX + UI Design
                'trabajador_id' => 1,
                'fecha' => '2024-02-15',
                'monto' => 748.00,
                'metodo_pago' => 'Efectivo',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Ana Sofía Martínez'
            ],
            // Estudiante 5: Luis Fernando - Data Science
            [
                'estudiante_id' => 5,
                'ciclo_id' => 3,
                'cursos' => [7], // Python Data Science
                'trabajador_id' => 1,
                'fecha' => '2024-02-20',
                'monto' => 649.00,
                'metodo_pago' => 'Tarjeta de débito',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Luis Fernando González'
            ],
            // Estudiante 6: Sofía Alejandra - Frontend
            [
                'estudiante_id' => 6,
                'ciclo_id' => 1,
                'cursos' => [1, 3], // HTML/CSS + React
                'trabajador_id' => 1,
                'fecha' => '2024-02-25',
                'monto' => 798.00,
                'metodo_pago' => 'Transferencia bancaria',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Sofía Alejandra López'
            ],
            // Estudiante 7: Pedro Antonio - Backend
            [
                'estudiante_id' => 7,
                'ciclo_id' => 2,
                'cursos' => [5], // Node.js
                'trabajador_id' => 1,
                'fecha' => '2024-03-01',
                'monto' => 549.00,
                'metodo_pago' => 'Tarjeta de crédito',
                'estado_pago' => 'pendiente',
                'nombre_pago' => 'Pedro Antonio Sánchez'
            ],
            // Estudiante 8: Laura Cristina - UX/UI
            [
                'estudiante_id' => 8,
                'ciclo_id' => 4,
                'cursos' => [9], // UX Design
                'trabajador_id' => 1,
                'fecha' => '2024-03-05',
                'monto' => 349.00,
                'metodo_pago' => 'Efectivo',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Laura Cristina Fernández'
            ],
            // Estudiante 9: Diego Alejandro - Ciberseguridad
            [
                'estudiante_id' => 9,
                'ciclo_id' => 5,
                'cursos' => [11], // Ethical Hacking
                'trabajador_id' => 1,
                'fecha' => '2024-03-10',
                'monto' => 699.00,
                'metodo_pago' => 'Tarjeta de crédito',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Diego Alejandro Morales'
            ],
            // Estudiante 10: Carmen Elena - Data Science
            [
                'estudiante_id' => 10,
                'ciclo_id' => 3,
                'cursos' => [7, 8], // Python + Machine Learning
                'trabajador_id' => 1,
                'fecha' => '2024-03-15',
                'monto' => 1398.00,
                'metodo_pago' => 'Transferencia bancaria',
                'estado_pago' => 'pagado',
                'nombre_pago' => 'Carmen Elena Torres'
            ]
        ];

        foreach ($matriculasData as $data) {
            // Crear matrícula
            $matricula = Matricula::create([
                'estudiante_id' => $data['estudiante_id'],
                'ciclo_id' => $data['ciclo_id'],
                'trabajador_id' => $data['trabajador_id'],
                'fecha' => $data['fecha'],
                'monto' => $data['monto'],
                'metodo_pago' => $data['metodo_pago'],
                'estado_pago' => $data['estado_pago'],
                'nombre_pago' => $data['nombre_pago']
            ]);

            // Crear inscripciones a cursos
            foreach ($data['cursos'] as $cursoId) {
                CursoEstudiante::create([
                    'estudiante_id' => $data['estudiante_id'],
                    'curso_id' => $cursoId,
                    'matricula_id' => $matricula->id,
                    'progreso' => rand(0, 100),
                    'calificacion_final' => rand(10, 20),
                    'estado' => 'activo'
                ]);
            }
        }
    }
}