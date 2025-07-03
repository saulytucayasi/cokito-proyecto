<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciclo;

class CicloSeeder extends Seeder
{
    public function run(): void
    {
        $ciclos = [
            [
                'nombre_area' => 'Desarrollo Web Frontend',
                'descripcion' => 'Aprende tecnologías modernas para el desarrollo frontend como HTML5, CSS3, JavaScript, React y Vue.js',
                'nivel_complejidad' => 'Intermedio',
                'fecha_inicio' => '2024-03-01',
                'fecha_fin' => '2024-06-30',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'Desarrollo Web Backend',
                'descripcion' => 'Domina el desarrollo backend con PHP, Laravel, Node.js y bases de datos',
                'nivel_complejidad' => 'Avanzado',
                'fecha_inicio' => '2024-04-01',
                'fecha_fin' => '2024-07-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'Data Science y Machine Learning',
                'descripcion' => 'Introducción a la ciencia de datos, Python, análisis estadístico y machine learning',
                'nivel_complejidad' => 'Avanzado',
                'fecha_inicio' => '2024-05-01',
                'fecha_fin' => '2024-08-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'Diseño UX/UI',
                'descripcion' => 'Fundamentos de diseño de experiencia de usuario e interfaces digitales',
                'nivel_complejidad' => 'Básico',
                'fecha_inicio' => '2024-02-01',
                'fecha_fin' => '2024-05-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'Ciberseguridad',
                'descripcion' => 'Principios de seguridad informática, ethical hacking y protección de sistemas',
                'nivel_complejidad' => 'Avanzado',
                'fecha_inicio' => '2024-06-01',
                'fecha_fin' => '2024-09-30',
                'estado' => 'activo'
            ]
        ];

        foreach ($ciclos as $ciclo) {
            Ciclo::create($ciclo);
        }
    }
}