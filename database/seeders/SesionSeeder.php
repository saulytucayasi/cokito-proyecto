<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sesion;
use Carbon\Carbon;

class SesionSeeder extends Seeder
{
    public function run(): void
    {
        $sesiones = [
            // Sesiones para HTML5 y CSS3 Fundamentals (Curso 1)
            [
                'curso_id' => 1,
                'sesiones' => [
                    ['nombre' => 'Introducción a HTML5', 'descripcion' => 'Fundamentos y estructura básica de HTML5', 'fecha' => '2024-03-01'],
                    ['nombre' => 'Elementos semánticos', 'descripcion' => 'Header, nav, main, article, section, aside, footer', 'fecha' => '2024-03-04'],
                    ['nombre' => 'Formularios HTML5', 'descripcion' => 'Nuevos tipos de input y validación', 'fecha' => '2024-03-08'],
                    ['nombre' => 'CSS3 Básico', 'descripcion' => 'Selectores, propiedades y valores', 'fecha' => '2024-03-11'],
                    ['nombre' => 'Flexbox', 'descripcion' => 'Layout flexible con CSS Flexbox', 'fecha' => '2024-03-15'],
                    ['nombre' => 'CSS Grid', 'descripcion' => 'Sistema de grid para layouts complejos', 'fecha' => '2024-03-18'],
                    ['nombre' => 'Responsive Design', 'descripcion' => 'Media queries y diseño adaptable', 'fecha' => '2024-03-22'],
                    ['nombre' => 'Proyecto Final', 'descripcion' => 'Desarrollo de página web completa', 'fecha' => '2024-03-25']
                ]
            ],
            // Sesiones para JavaScript Moderno ES6+ (Curso 2)
            [
                'curso_id' => 2,
                'sesiones' => [
                    ['nombre' => 'Fundamentos de JavaScript', 'descripcion' => 'Variables, tipos de datos y operadores', 'fecha' => '2024-03-15'],
                    ['nombre' => 'Funciones y Scope', 'descripcion' => 'Declaración de funciones y ámbito de variables', 'fecha' => '2024-03-18'],
                    ['nombre' => 'ES6+ Características', 'descripcion' => 'Let, const, arrow functions, template literals', 'fecha' => '2024-03-22'],
                    ['nombre' => 'Destructuring y Spread', 'descripcion' => 'Desestructuración de objetos y arrays', 'fecha' => '2024-03-25'],
                    ['nombre' => 'Promises y Async/Await', 'descripcion' => 'Programación asíncrona moderna', 'fecha' => '2024-03-29'],
                    ['nombre' => 'Módulos ES6', 'descripcion' => 'Import/export y organización de código', 'fecha' => '2024-04-01'],
                    ['nombre' => 'DOM Manipulation', 'descripcion' => 'Interacción con el Document Object Model', 'fecha' => '2024-04-05'],
                    ['nombre' => 'Events y Event Handling', 'descripcion' => 'Manejo de eventos en JavaScript', 'fecha' => '2024-04-08'],
                    ['nombre' => 'Fetch API', 'descripcion' => 'Consumo de APIs REST', 'fecha' => '2024-04-12'],
                    ['nombre' => 'Proyecto JavaScript', 'descripcion' => 'Aplicación web interactiva', 'fecha' => '2024-04-15']
                ]
            ],
            // Sesiones para PHP y Laravel Framework (Curso 4)
            [
                'curso_id' => 4,
                'sesiones' => [
                    ['nombre' => 'Introducción a PHP', 'descripcion' => 'Sintaxis básica y configuración del entorno', 'fecha' => '2024-04-01'],
                    ['nombre' => 'Variables y Tipos de Datos', 'descripcion' => 'Manejo de datos en PHP', 'fecha' => '2024-04-05'],
                    ['nombre' => 'Control de Flujo', 'descripcion' => 'Condicionales y bucles', 'fecha' => '2024-04-08'],
                    ['nombre' => 'Funciones en PHP', 'descripcion' => 'Creación y uso de funciones', 'fecha' => '2024-04-12'],
                    ['nombre' => 'Programación Orientada a Objetos', 'descripcion' => 'Clases, objetos y herencia', 'fecha' => '2024-04-15'],
                    ['nombre' => 'Introducción a Laravel', 'descripcion' => 'Instalación y estructura del framework', 'fecha' => '2024-04-19'],
                    ['nombre' => 'Rutas y Controladores', 'descripcion' => 'Sistema de enrutamiento de Laravel', 'fecha' => '2024-04-22'],
                    ['nombre' => 'Eloquent ORM', 'descripcion' => 'Manejo de base de datos con Eloquent', 'fecha' => '2024-04-26'],
                    ['nombre' => 'Blade Templates', 'descripcion' => 'Sistema de plantillas de Laravel', 'fecha' => '2024-04-29'],
                    ['nombre' => 'Middleware y Autenticación', 'descripcion' => 'Seguridad en aplicaciones Laravel', 'fecha' => '2024-05-03'],
                    ['nombre' => 'APIs REST con Laravel', 'descripcion' => 'Creación de servicios web', 'fecha' => '2024-05-06'],
                    ['nombre' => 'Testing en Laravel', 'descripcion' => 'Pruebas unitarias y de integración', 'fecha' => '2024-05-10'],
                    ['nombre' => 'Deploy y Producción', 'descripcion' => 'Despliegue de aplicaciones Laravel', 'fecha' => '2024-05-13'],
                    ['nombre' => 'Proyecto Final Laravel', 'descripcion' => 'Desarrollo de aplicación completa', 'fecha' => '2024-05-17']
                ]
            ],
            // Sesiones para Python para Data Science (Curso 7)
            [
                'curso_id' => 7,
                'sesiones' => [
                    ['nombre' => 'Introducción a Python', 'descripcion' => 'Sintaxis básica y configuración del entorno', 'fecha' => '2024-05-01'],
                    ['nombre' => 'Estructuras de Datos', 'descripcion' => 'Listas, tuplas, diccionarios y sets', 'fecha' => '2024-05-05'],
                    ['nombre' => 'NumPy Fundamentals', 'descripcion' => 'Arrays y operaciones matemáticas', 'fecha' => '2024-05-08'],
                    ['nombre' => 'Pandas Básico', 'descripcion' => 'DataFrames y Series', 'fecha' => '2024-05-12'],
                    ['nombre' => 'Manipulación de Datos', 'descripcion' => 'Limpieza y transformación de datos', 'fecha' => '2024-05-15'],
                    ['nombre' => 'Visualización con Matplotlib', 'descripcion' => 'Gráficos y visualizaciones básicas', 'fecha' => '2024-05-19'],
                    ['nombre' => 'Seaborn y Plotly', 'descripcion' => 'Visualizaciones avanzadas', 'fecha' => '2024-05-22'],
                    ['nombre' => 'Análisis Exploratorio', 'descripcion' => 'EDA con Python', 'fecha' => '2024-05-26'],
                    ['nombre' => 'Estadística Descriptiva', 'descripcion' => 'Medidas de tendencia central y dispersión', 'fecha' => '2024-05-29'],
                    ['nombre' => 'Introducción a Machine Learning', 'descripcion' => 'Conceptos básicos de ML', 'fecha' => '2024-06-02'],
                    ['nombre' => 'Proyecto de Análisis', 'descripcion' => 'Análisis completo de dataset real', 'fecha' => '2024-06-05'],
                    ['nombre' => 'Presentación de Resultados', 'descripcion' => 'Comunicación efectiva de insights', 'fecha' => '2024-06-09']
                ]
            ],
            // Sesiones para Fundamentos de UX Design (Curso 9)
            [
                'curso_id' => 9,
                'sesiones' => [
                    ['nombre' => 'Introducción al UX', 'descripcion' => 'Qué es UX y por qué importa', 'fecha' => '2024-02-01'],
                    ['nombre' => 'Design Thinking', 'descripcion' => 'Proceso de pensamiento de diseño', 'fecha' => '2024-02-05'],
                    ['nombre' => 'User Research', 'descripcion' => 'Investigación de usuarios y métodos', 'fecha' => '2024-02-08'],
                    ['nombre' => 'Personas y User Journey', 'descripcion' => 'Creación de personas y mapas de experiencia', 'fecha' => '2024-02-12'],
                    ['nombre' => 'Information Architecture', 'descripcion' => 'Organización de la información', 'fecha' => '2024-02-15'],
                    ['nombre' => 'Wireframing', 'descripcion' => 'Creación de wireframes y prototipos de baja fidelidad', 'fecha' => '2024-02-19'],
                    ['nombre' => 'Prototyping', 'descripcion' => 'Prototipos interactivos', 'fecha' => '2024-02-22'],
                    ['nombre' => 'Usability Testing', 'descripcion' => 'Pruebas de usabilidad y validación', 'fecha' => '2024-02-26']
                ]
            ]
        ];

        foreach ($sesiones as $cursoData) {
            $orden = 1;
            foreach ($cursoData['sesiones'] as $sesionData) {
                Sesion::create([
                    'nombre' => $sesionData['nombre'],
                    'descripcion' => $sesionData['descripcion'],
                    'fecha_programada' => $sesionData['fecha'],
                    'hora_inicio' => '19:00',
                    'hora_fin' => '21:00',
                    'orden' => $orden,
                    'estado' => Carbon::parse($sesionData['fecha'])->isPast() ? 'completada' : 'pendiente',
                    'curso_id' => $cursoData['curso_id']
                ]);
                $orden++;
            }
        }
    }
}