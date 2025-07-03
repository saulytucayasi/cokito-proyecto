<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            // Cursos de Desarrollo Web Frontend (Ciclo 1)
            [
                'nombre' => 'HTML5 y CSS3 Fundamentals',
                'descripcion' => 'Aprende los fundamentos de HTML5 y CSS3 para crear páginas web modernas y responsivas.',
                'nivel' => 'Básico',
                'costo' => '299.00',
                'duracion' => '8 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-03-01',
                'fecha_fin' => '2024-04-26',
                'ciclo_id' => 1,
                'docente_id' => 2, // Carlos Rodríguez
                'estado' => 'activo'
            ],
            [
                'nombre' => 'JavaScript Moderno ES6+',
                'descripcion' => 'Domina JavaScript moderno con ES6+, async/await, destructuring y más.',
                'nivel' => 'Intermedio',
                'costo' => '399.00',
                'duracion' => '10 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-03-15',
                'fecha_fin' => '2024-05-24',
                'ciclo_id' => 1,
                'docente_id' => 3, // María González
                'estado' => 'activo'
            ],
            [
                'nombre' => 'React.js para Principiantes',
                'descripcion' => 'Construye aplicaciones web interactivas con React.js y sus hooks.',
                'nivel' => 'Intermedio',
                'costo' => '499.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-04-01',
                'fecha_fin' => '2024-06-21',
                'ciclo_id' => 1,
                'docente_id' => 2, // Carlos Rodríguez
                'estado' => 'activo'
            ],

            // Cursos de Desarrollo Web Backend (Ciclo 2)
            [
                'nombre' => 'PHP y Laravel Framework',
                'descripcion' => 'Desarrollo backend profesional con PHP y el framework Laravel.',
                'nivel' => 'Avanzado',
                'costo' => '599.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-04-01',
                'fecha_fin' => '2024-07-05',
                'ciclo_id' => 2,
                'docente_id' => 4, // Luis Martínez
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Node.js y Express',
                'descripcion' => 'Crea APIs REST robustas con Node.js y Express.js.',
                'nivel' => 'Avanzado',
                'costo' => '549.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-04-15',
                'fecha_fin' => '2024-07-05',
                'ciclo_id' => 2,
                'docente_id' => 3, // María González
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Bases de Datos MySQL y MongoDB',
                'descripcion' => 'Diseño y administración de bases de datos relacionales y NoSQL.',
                'nivel' => 'Intermedio',
                'costo' => '449.00',
                'duracion' => '10 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-05-01',
                'fecha_fin' => '2024-07-10',
                'ciclo_id' => 2,
                'docente_id' => 4, // Luis Martínez
                'estado' => 'activo'
            ],

            // Cursos de Data Science (Ciclo 3)
            [
                'nombre' => 'Python para Data Science',
                'descripcion' => 'Fundamentos de Python aplicado a ciencia de datos con Pandas y NumPy.',
                'nivel' => 'Intermedio',
                'costo' => '649.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-05-01',
                'fecha_fin' => '2024-07-26',
                'ciclo_id' => 3,
                'docente_id' => 5, // Ana López
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Machine Learning con Scikit-Learn',
                'descripcion' => 'Algoritmos de machine learning aplicados con Python y Scikit-Learn.',
                'nivel' => 'Avanzado',
                'costo' => '749.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-06-01',
                'fecha_fin' => '2024-08-30',
                'ciclo_id' => 3,
                'docente_id' => 5, // Ana López
                'estado' => 'activo'
            ],

            // Cursos de Diseño UX/UI (Ciclo 4)
            [
                'nombre' => 'Fundamentos de UX Design',
                'descripcion' => 'Principios de experiencia de usuario, research y prototipado.',
                'nivel' => 'Básico',
                'costo' => '349.00',
                'duracion' => '8 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-02-01',
                'fecha_fin' => '2024-03-29',
                'ciclo_id' => 4,
                'docente_id' => 6, // Pedro Sánchez
                'estado' => 'activo'
            ],
            [
                'nombre' => 'UI Design con Figma',
                'descripcion' => 'Diseño de interfaces modernas y sistemas de diseño con Figma.',
                'nivel' => 'Intermedio',
                'costo' => '399.00',
                'duracion' => '10 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-03-01',
                'fecha_fin' => '2024-05-10',
                'ciclo_id' => 4,
                'docente_id' => 6, // Pedro Sánchez
                'estado' => 'activo'
            ],

            // Cursos de Ciberseguridad (Ciclo 5)
            [
                'nombre' => 'Ethical Hacking Básico',
                'descripcion' => 'Introducción al hacking ético y pruebas de penetración.',
                'nivel' => 'Intermedio',
                'costo' => '699.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Virtual',
                'fecha_inicio' => '2024-06-01',
                'fecha_fin' => '2024-08-23',
                'ciclo_id' => 5,
                'docente_id' => 4, // Luis Martínez
                'estado' => 'activo'
            ]
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}