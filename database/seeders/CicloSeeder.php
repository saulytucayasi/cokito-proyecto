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
                'nombre_area' => 'CICLO PRIMARIA (Matematica)',
                'descripcion' => 'Matemática básica para estudiantes de primaria',
                'nivel_complejidad' => 'Básico',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO FISICA-QUIMICA (Cero)',
                'descripcion' => 'Preparación básica en Física y Química',
                'nivel_complejidad' => 'Básico',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO MATEMATICA (Cero)',
                'descripcion' => 'Matemática básica preparatoria',
                'nivel_complejidad' => 'Básico',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO SOCIALES (Formativo)',
                'descripcion' => 'Formación en Ciencias Sociales',
                'nivel_complejidad' => 'Intermedio',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO INGENIERIAS (Formativo)',
                'descripcion' => 'Formación preparatoria para Ingenierías',
                'nivel_complejidad' => 'Intermedio',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO BIOMEDICAS (Formativo)',
                'descripcion' => 'Formación en Ciencias Biomédicas',
                'nivel_complejidad' => 'Intermedio',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO RM-RV (Formativo)',
                'descripcion' => 'Formación en Razonamiento Matemático y Verbal',
                'nivel_complejidad' => 'Intermedio',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ],
            [
                'nombre_area' => 'CICLO CEPREUNA (Fijas)',
                'descripcion' => 'Preparación para el examen de admisión CEPREUNA',
                'nivel_complejidad' => 'Avanzado',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-12-31',
                'estado' => 'activo'
            ]
        ];

        foreach ($ciclos as $ciclo) {
            Ciclo::create($ciclo);
        }
    }
}