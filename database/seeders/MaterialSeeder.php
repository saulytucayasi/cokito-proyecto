<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materiales = [
            // Materiales para HTML5 y CSS3 Fundamentals (Curso 1)
            [
                'nombre_material' => 'Guía de HTML5 Completa',
                'descripcion' => 'Manual completo de HTML5 con ejemplos prácticos',
                'tipo' => 'documento',
                'path_material' => 'materiales/html5-guia-completa.pdf',
                'orden' => 1,
                'es_publico' => true,
                'curso_id' => 1,
                'subido_por' => 2 // Carlos Rodríguez
            ],
            [
                'nombre_material' => 'Cheat Sheet CSS3',
                'descripcion' => 'Hoja de referencia rápida para CSS3',
                'tipo' => 'documento',
                'path_material' => 'materiales/css3-cheat-sheet.pdf',
                'orden' => 2,
                'es_publico' => true,
                'curso_id' => 1,
                'subido_por' => 2
            ],
            [
                'nombre_material' => 'Plantilla de Proyecto',
                'descripcion' => 'Plantilla base para el proyecto final',
                'tipo' => 'archivo',
                'path_material' => 'materiales/plantilla-proyecto.zip',
                'orden' => 3,
                'es_publico' => true,
                'curso_id' => 1,
                'subido_por' => 2
            ],

            // Materiales para JavaScript Moderno ES6+ (Curso 2)
            [
                'nombre_material' => 'JavaScript ES6+ Manual',
                'descripcion' => 'Guía completa de las nuevas características de ES6+',
                'tipo' => 'documento',
                'path_material' => 'materiales/javascript-es6-manual.pdf',
                'orden' => 1,
                'es_publico' => true,
                'curso_id' => 2,
                'subido_por' => 3 // María González
            ],
            [
                'nombre_material' => 'Ejercicios Prácticos JS',
                'descripcion' => 'Colección de ejercicios para practicar JavaScript',
                'tipo' => 'documento',
                'path_material' => 'materiales/ejercicios-javascript.pdf',
                'orden' => 2,
                'es_publico' => true,
                'curso_id' => 2,
                'subido_por' => 3
            ],
            [
                'nombre_material' => 'Códigos de Ejemplo',
                'descripcion' => 'Archivos con ejemplos de código de cada sesión',
                'tipo' => 'archivo',
                'path_material' => 'materiales/ejemplos-javascript.zip',
                'orden' => 3,
                'es_publico' => true,
                'curso_id' => 2,
                'subido_por' => 3
            ],

            // Materiales para PHP y Laravel Framework (Curso 4)
            [
                'nombre_material' => 'Manual de PHP 8',
                'descripcion' => 'Documentación completa de PHP 8 con ejemplos',
                'tipo' => 'documento',
                'path_material' => 'materiales/php8-manual.pdf',
                'orden' => 1,
                'es_publico' => true,
                'curso_id' => 4,
                'subido_por' => 4 // Luis Martínez
            ],
            [
                'nombre_material' => 'Laravel 10 Guía',
                'descripcion' => 'Guía paso a paso para desarrollar con Laravel 10',
                'tipo' => 'documento',
                'path_material' => 'materiales/laravel10-guia.pdf',
                'orden' => 2,
                'es_publico' => true,
                'curso_id' => 4,
                'subido_por' => 4
            ],
            [
                'nombre_material' => 'Proyecto Base Laravel',
                'descripcion' => 'Estructura inicial para el proyecto del curso',
                'tipo' => 'archivo',
                'path_material' => 'materiales/laravel-proyecto-base.zip',
                'orden' => 3,
                'es_publico' => true,
                'curso_id' => 4,
                'subido_por' => 4
            ],

            // Materiales para Python para Data Science (Curso 7)
            [
                'nombre_material' => 'Python para Data Science',
                'descripcion' => 'Libro completo de Python aplicado a ciencia de datos',
                'tipo' => 'documento',
                'path_material' => 'materiales/python-data-science.pdf',
                'orden' => 1,
                'es_publico' => true,
                'curso_id' => 7,
                'subido_por' => 5 // Ana López
            ],
            [
                'nombre_material' => 'Datasets de Práctica',
                'descripcion' => 'Conjuntos de datos para practicar análisis',
                'tipo' => 'archivo',
                'path_material' => 'materiales/datasets-practica.zip',
                'orden' => 2,
                'es_publico' => true,
                'curso_id' => 7,
                'subido_por' => 5
            ],
            [
                'nombre_material' => 'Notebooks de Jupyter',
                'descripcion' => 'Notebooks con ejemplos de cada sesión',
                'tipo' => 'archivo',
                'path_material' => 'materiales/jupyter-notebooks.zip',
                'orden' => 3,
                'es_publico' => true,
                'curso_id' => 7,
                'subido_por' => 5
            ],

            // Materiales para Fundamentos de UX Design (Curso 9)
            [
                'nombre_material' => 'Fundamentos de UX Design',
                'descripcion' => 'Manual teórico de experiencia de usuario',
                'tipo' => 'documento',
                'path_material' => 'materiales/ux-fundamentos.pdf',
                'orden' => 1,
                'es_publico' => true,
                'curso_id' => 9,
                'subido_por' => 6 // Pedro Sánchez
            ],
            [
                'nombre_material' => 'Plantillas de Wireframes',
                'descripcion' => 'Plantillas para crear wireframes',
                'tipo' => 'archivo',
                'path_material' => 'materiales/wireframe-templates.zip',
                'orden' => 2,
                'es_publico' => true,
                'curso_id' => 9,
                'subido_por' => 6
            ],
            [
                'nombre_material' => 'Casos de Estudio UX',
                'descripcion' => 'Análisis de casos reales de diseño UX',
                'tipo' => 'documento',
                'path_material' => 'materiales/casos-estudio-ux.pdf',
                'orden' => 3,
                'es_publico' => true,
                'curso_id' => 9,
                'subido_por' => 6
            ]
        ];

        foreach ($materiales as $material) {
            Material::create($material);
        }
    }
}