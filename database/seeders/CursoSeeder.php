<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            // CICLO PRIMARIA (Matematica) - Ciclo 1
            [
                'nombre' => 'ARITMÉTICA',
                'descripcion' => 'Fundamentos de aritmética: operaciones básicas, fracciones, decimales y porcentajes.',
                'nivel' => 'Básico',
                'costo' => '150.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-05-24',
                'ciclo_id' => 1,
                'docente_id' => 2,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'ÁLGEBRA',
                'descripcion' => 'Introducción al álgebra: ecuaciones, sistemas de ecuaciones y factorización.',
                'nivel' => 'Básico',
                'costo' => '150.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-05-24',
                'ciclo_id' => 1,
                'docente_id' => 2,
                'estado' => 'activo'
            ],

            // CICLO FISICA-QUIMICA (Cero) - Ciclo 2
            [
                'nombre' => 'FÍSICA I',
                'descripcion' => 'Conceptos fundamentales de física: mecánica, cinemática y dinámica.',
                'nivel' => 'Básico',
                'costo' => '200.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-06-07',
                'ciclo_id' => 2,
                'docente_id' => 3,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'FÍSICA II',
                'descripcion' => 'Termodinámica, ondas, electricidad y magnetismo.',
                'nivel' => 'Intermedio',
                'costo' => '200.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-06-08',
                'fecha_fin' => '2025-09-13',
                'ciclo_id' => 2,
                'docente_id' => 3,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'QUÍMICA I',
                'descripcion' => 'Fundamentos de química: estructura atómica, enlaces y reacciones químicas.',
                'nivel' => 'Básico',
                'costo' => '200.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-06-07',
                'ciclo_id' => 2,
                'docente_id' => 4,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'QUÍMICA II',
                'descripcion' => 'Química orgánica e inorgánica avanzada.',
                'nivel' => 'Intermedio',
                'costo' => '200.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-06-08',
                'fecha_fin' => '2025-09-13',
                'ciclo_id' => 2,
                'docente_id' => 4,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'QUÍMICA III',
                'descripcion' => 'Química analítica y fisicoquímica.',
                'nivel' => 'Avanzado',
                'costo' => '200.00',
                'duracion' => '14 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-09-14',
                'fecha_fin' => '2025-12-20',
                'ciclo_id' => 2,
                'docente_id' => 4,
                'estado' => 'activo'
            ],

            // CICLO MATEMATICA (Cero) - Ciclo 3
            [
                'nombre' => 'GEOMETRÍA I',
                'descripcion' => 'Geometría plana: figuras geométricas, perímetros y áreas.',
                'nivel' => 'Básico',
                'costo' => '180.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-05-24',
                'ciclo_id' => 3,
                'docente_id' => 2,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'GEOMETRÍA II',
                'descripcion' => 'Geometría del espacio: cuerpos geométricos y volúmenes.',
                'nivel' => 'Intermedio',
                'costo' => '180.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-06-01',
                'fecha_fin' => '2025-08-23',
                'ciclo_id' => 3,
                'docente_id' => 2,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'TRIGONOMETRÍA',
                'descripcion' => 'Funciones trigonométricas, identidades y ecuaciones.',
                'nivel' => 'Intermedio',
                'costo' => '180.00',
                'duracion' => '12 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-08-24',
                'fecha_fin' => '2025-11-15',
                'ciclo_id' => 3,
                'docente_id' => 2,
                'estado' => 'activo'
            ],

            // CICLO BIOMEDICAS (Formativo) - Ciclo 6
            [
                'nombre' => 'BIOLOGÍA',
                'descripcion' => 'Fundamentos de biología: célula, tejidos, sistemas y evolución.',
                'nivel' => 'Intermedio',
                'costo' => '220.00',
                'duracion' => '16 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-06-21',
                'ciclo_id' => 6,
                'docente_id' => 5,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'ANATOMÍA',
                'descripcion' => 'Anatomía humana: sistemas corporales y fisiología básica.',
                'nivel' => 'Intermedio',
                'costo' => '220.00',
                'duracion' => '16 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-06-22',
                'fecha_fin' => '2025-10-11',
                'ciclo_id' => 6,
                'docente_id' => 5,
                'estado' => 'activo'
            ],

            // CICLO RM-RV (Formativo) - Ciclo 7
            [
                'nombre' => 'RAZ. MATEMÁTICO',
                'descripcion' => 'Desarrollo del razonamiento matemático y resolución de problemas.',
                'nivel' => 'Intermedio',
                'costo' => '160.00',
                'duracion' => '20 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-07-19',
                'ciclo_id' => 7,
                'docente_id' => 2,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'RAZ. VERBAL',
                'descripcion' => 'Desarrollo del razonamiento verbal, comprensión lectora y análisis de textos.',
                'nivel' => 'Intermedio',
                'costo' => '160.00',
                'duracion' => '20 semanas',
                'modalidad' => 'Presencial',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-07-19',
                'ciclo_id' => 7,
                'docente_id' => 6,
                'estado' => 'activo'
            ]
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}