<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            // Videos para HTML5 y CSS3 Fundamentals (Curso 1)
            [
                'titulo' => 'Introducción a HTML5 - Fundamentos',
                'descripcion' => 'Video introductorio explicando los conceptos básicos de HTML5',
                'url_youtube' => 'https://www.youtube.com/watch?v=UB1O30fR-EE',
                'video_id_youtube' => 'UB1O30fR-EE',
                'duracion' => '45 min',
                'orden' => 1,
                'estado' => 'activo',
                'curso_id' => 1
            ],
            [
                'titulo' => 'CSS3 Flexbox - Layout Moderno',
                'descripcion' => 'Aprende a crear layouts flexibles con CSS Flexbox',
                'url_youtube' => 'https://www.youtube.com/watch?v=3YW65K6LcIA',
                'video_id_youtube' => '3YW65K6LcIA',
                'duracion' => '52 min',
                'orden' => 2,
                'estado' => 'activo',
                'curso_id' => 1
            ],
            [
                'titulo' => 'Responsive Design con CSS Grid',
                'descripcion' => 'Diseño responsivo usando CSS Grid System',
                'url_youtube' => 'https://www.youtube.com/watch?v=jV8B24rSN5o',
                'video_id_youtube' => 'jV8B24rSN5o',
                'duracion' => '38 min',
                'orden' => 3,
                'estado' => 'activo',
                'curso_id' => 1
            ],

            // Videos para JavaScript Moderno ES6+ (Curso 2)
            [
                'titulo' => 'JavaScript ES6 - Características Nuevas',
                'descripcion' => 'Introducción a las nuevas características de ES6+',
                'url_youtube' => 'https://www.youtube.com/watch?v=WZQc7RUAg18',
                'video_id_youtube' => 'WZQc7RUAg18',
                'duracion' => '42 min',
                'orden' => 1,
                'estado' => 'activo',
                'curso_id' => 2
            ],
            [
                'titulo' => 'Async/Await en JavaScript',
                'descripcion' => 'Programación asíncrona moderna con async/await',
                'url_youtube' => 'https://www.youtube.com/watch?v=V_Kr9OSfDeU',
                'video_id_youtube' => 'V_Kr9OSfDeU',
                'duracion' => '35 min',
                'orden' => 2,
                'estado' => 'activo',
                'curso_id' => 2
            ],
            [
                'titulo' => 'Destructuring y Spread Operator',
                'descripcion' => 'Desestructuración de objetos y arrays en JavaScript',
                'url_youtube' => 'https://www.youtube.com/watch?v=NIq3qLaHCIs',
                'video_id_youtube' => 'NIq3qLaHCIs',
                'duracion' => '28 min',
                'orden' => 3,
                'estado' => 'activo',
                'curso_id' => 2
            ],

            // Videos para PHP y Laravel Framework (Curso 4)
            [
                'titulo' => 'PHP 8 - Novedades y Características',
                'descripcion' => 'Introducción a PHP 8 y sus nuevas funcionalidades',
                'url_youtube' => 'https://www.youtube.com/watch?v=f_cwnwaEwaY',
                'video_id_youtube' => 'f_cwnwaEwaY',
                'duracion' => '55 min',
                'orden' => 1,
                'estado' => 'activo',
                'curso_id' => 4
            ],
            [
                'titulo' => 'Laravel - Instalación y Configuración',
                'descripcion' => 'Cómo instalar y configurar Laravel desde cero',
                'url_youtube' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE',
                'video_id_youtube' => 'ImtZ5yENzgE',
                'duracion' => '32 min',
                'orden' => 2,
                'estado' => 'activo',
                'curso_id' => 4
            ],
            [
                'titulo' => 'Eloquent ORM - Relaciones',
                'descripcion' => 'Manejo de relaciones en Eloquent ORM',
                'url_youtube' => 'https://www.youtube.com/watch?v=SS3NBDVgOT0',
                'video_id_youtube' => 'SS3NBDVgOT0',
                'duracion' => '47 min',
                'orden' => 3,
                'estado' => 'activo',
                'curso_id' => 4
            ],

            // Videos para Python para Data Science (Curso 7)
            [
                'titulo' => 'Python para Data Science - Introducción',
                'descripcion' => 'Configuración del entorno y primeros pasos',
                'url_youtube' => 'https://www.youtube.com/watch?v=ua-CiDNNj30',
                'video_id_youtube' => 'ua-CiDNNj30',
                'duracion' => '40 min',
                'orden' => 1,
                'estado' => 'activo',
                'curso_id' => 7
            ],
            [
                'titulo' => 'Pandas - Manipulación de DataFrames',
                'descripcion' => 'Operaciones básicas con Pandas DataFrames',
                'url_youtube' => 'https://www.youtube.com/watch?v=vmEHCJofslg',
                'video_id_youtube' => 'vmEHCJofslg',
                'duracion' => '53 min',
                'orden' => 2,
                'estado' => 'activo',
                'curso_id' => 7
            ],
            [
                'titulo' => 'Visualización de Datos con Matplotlib',
                'descripcion' => 'Creación de gráficos profesionales con Matplotlib',
                'url_youtube' => 'https://www.youtube.com/watch?v=3Xc3CA655Y4',
                'video_id_youtube' => '3Xc3CA655Y4',
                'duracion' => '41 min',
                'orden' => 3,
                'estado' => 'activo',
                'curso_id' => 7
            ],

            // Videos para Fundamentos de UX Design (Curso 9)
            [
                'titulo' => 'Introducción al UX Design',
                'descripcion' => 'Qué es UX Design y por qué es importante',
                'url_youtube' => 'https://www.youtube.com/watch?v=Ovj4hFxko7c',
                'video_id_youtube' => 'Ovj4hFxko7c',
                'duracion' => '33 min',
                'orden' => 1,
                'estado' => 'activo',
                'curso_id' => 9
            ],
            [
                'titulo' => 'Design Thinking Process',
                'descripcion' => 'Proceso de Design Thinking paso a paso',
                'url_youtube' => 'https://www.youtube.com/watch?v=_r0VX-aU_T8',
                'video_id_youtube' => '_r0VX-aU_T8',
                'duracion' => '39 min',
                'orden' => 2,
                'estado' => 'activo',
                'curso_id' => 9
            ],
            [
                'titulo' => 'Wireframing - Herramientas y Técnicas',
                'descripcion' => 'Cómo crear wireframes efectivos',
                'url_youtube' => 'https://www.youtube.com/watch?v=qpH7-KFWZRI',
                'video_id_youtube' => 'qpH7-KFWZRI',
                'duracion' => '44 min',
                'orden' => 3,
                'estado' => 'activo',
                'curso_id' => 9
            ]
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}