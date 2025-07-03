<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academia;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Trabajador;
use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\CursoEstudiante;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;

class CokitoPlusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear academia por defecto
        $academia = Academia::create([
            'nombre' => 'COKITO+ Academia',
            'Direccion' => 'Av. Principal 123, Lima, Perú',
            'telefono' => '+51987654321',
            'director' => 'Director General COKITO+'
        ]);

        // 2. Crear usuarios en tabla usuario con roles
        $adminUsuario = Usuario::create([
            'usuario' => 'admin@cokito.com',
            'email' => 'admin@cokito.com',
            'password' => 'admin123',
            'rol' => 'admin'
        ]);

        $docenteUsuario = Usuario::create([
            'usuario' => 'docente@cokito.com',
            'email' => 'docente@cokito.com',
            'password' => 'docente123',
            'rol' => 'docente'
        ]);

        $secretariaUsuario = Usuario::create([
            'usuario' => 'secretaria@cokito.com',
            'email' => 'secretaria@cokito.com',
            'password' => 'secretaria123',
            'rol' => 'secretaria'
        ]);

        $estudianteUsuario = Usuario::create([
            'usuario' => 'estudiante@cokito.com',
            'email' => 'estudiante@cokito.com',
            'password' => 'estudiante123',
            'rol' => 'estudiante'
        ]);

        // 3. Crear usuarios en tabla users (para autenticación Laravel)
        User::firstOrCreate(
            ['email' => 'admin@cokito.com'],
            ['name' => 'Admin COKITO+', 'password' => Hash::make('admin123')]
        );

        User::firstOrCreate(
            ['email' => 'docente@cokito.com'],
            ['name' => 'Docente COKITO+', 'password' => Hash::make('docente123')]
        );

        User::firstOrCreate(
            ['email' => 'secretaria@cokito.com'],
            ['name' => 'Secretaria COKITO+', 'password' => Hash::make('secretaria123')]
        );

        User::firstOrCreate(
            ['email' => 'estudiante@cokito.com'],
            ['name' => 'Estudiante COKITO+', 'password' => Hash::make('estudiante123')]
        );

        // 4. Crear trabajadores
        $trabajadorSecretaria = Trabajador::create([
            'nombre' => 'María García',
            'correo' => 'secretaria@cokito.com',
            'telefono' => '987654321',
            'estado' => 'activo',
            'usuario_id' => $secretariaUsuario->id
        ]);

        $trabajadorDocente = Trabajador::create([
            'nombre' => 'Carlos Rodríguez',
            'correo' => 'docente@cokito.com',
            'telefono' => '987654322',
            'estado' => 'activo',
            'usuario_id' => $docenteUsuario->id
        ]);

        // 5. Crear estudiantes
        $estudiante1 = Estudiante::create([
            'nombre' => 'Paco',
            'apellido' => 'Yunque',
            'correo' => 'estudiante@cokito.com',
            'fecha_nacimiento' => '2000-05-15',
            'dni' => '12345678',
            'telefono' => '987654323',
            'estado_matricula' => 'activo',
            'fecha_registro' => now(),
            'academia_id' => $academia->id,
            'usuario_id' => $estudianteUsuario->id
        ]);

        $estudiante2 = Estudiante::create([
            'nombre' => 'Ana',
            'apellido' => 'Torres',
            'correo' => 'ana.torres@email.com',
            'fecha_nacimiento' => '1999-08-22',
            'dni' => '87654321',
            'telefono' => '987654324',
            'estado_matricula' => 'activo',
            'fecha_registro' => now(),
            'academia_id' => $academia->id
        ]);

        $estudiante3 = Estudiante::create([
            'nombre' => 'José',
            'apellido' => 'Mendoza',
            'correo' => 'jose.mendoza@email.com',
            'fecha_nacimiento' => '2001-02-10',
            'dni' => '11223344',
            'telefono' => '987654325',
            'estado_matricula' => 'inactivo',
            'fecha_registro' => now(),
            'academia_id' => $academia->id
        ]);

        // 6. Crear ciclos
        $ciclo1 = Ciclo::create([
            'nombre_area' => 'Desarrollo Web Frontend',
            'nivel_complejidad' => 'Básico',
            'estado' => 'activo'
        ]);

        $ciclo2 = Ciclo::create([
            'nombre_area' => 'Desarrollo Web Backend',
            'nivel_complejidad' => 'Intermedio',
            'estado' => 'activo'
        ]);

        $ciclo3 = Ciclo::create([
            'nombre_area' => 'Bases de Datos',
            'nivel_complejidad' => 'Intermedio',
            'estado' => 'activo'
        ]);

        $ciclo4 = Ciclo::create([
            'nombre_area' => 'Diseño UX/UI',
            'nivel_complejidad' => 'Básico',
            'estado' => 'activo'
        ]);

        // 7. Crear cursos
        $curso1 = Curso::create([
            'descripcion' => 'Aprende HTML, CSS y JavaScript desde cero para crear sitios web modernos y responsivos.',
            'nivel' => 'básico',
            'nombre' => 'Fundamentos de HTML, CSS y JavaScript',
            'costo' => '299.00',
            'duracion' => '8 semanas',
            'modalidad' => 'virtual',
            'fecha_inicio' => '2024-01-15',
            'fecha_fin' => '2024-03-15',
            'ciclo_id' => $ciclo1->id
        ]);

        $curso2 = Curso::create([
            'descripcion' => 'Domina React.js para crear aplicaciones web interactivas y dinámicas con componentes reutilizables.',
            'nivel' => 'intermedio',
            'nombre' => 'React.js Avanzado',
            'costo' => '499.00',
            'duracion' => '12 semanas',
            'modalidad' => 'virtual',
            'fecha_inicio' => '2024-02-01',
            'fecha_fin' => '2024-04-30',
            'ciclo_id' => $ciclo1->id
        ]);

        $curso3 = Curso::create([
            'descripcion' => 'Construye APIs REST robustas con Node.js y Express, incluyendo autenticación y bases de datos.',
            'nivel' => 'intermedio',
            'nombre' => 'Node.js y Express para Backend',
            'costo' => '599.00',
            'duracion' => '10 semanas',
            'modalidad' => 'presencial',
            'fecha_inicio' => '2024-03-01',
            'fecha_fin' => '2024-05-15',
            'ciclo_id' => $ciclo2->id
        ]);

        $curso4 = Curso::create([
            'descripcion' => 'Aprende diseño de bases de datos relacionales con MySQL y optimización de consultas.',
            'nivel' => 'básico',
            'nombre' => 'MySQL para Desarrolladores',
            'costo' => '399.00',
            'duracion' => '6 semanas',
            'modalidad' => 'híbrido',
            'fecha_inicio' => '2024-01-20',
            'fecha_fin' => '2024-03-01',
            'ciclo_id' => $ciclo3->id
        ]);

        $curso5 = Curso::create([
            'descripcion' => 'Principios de diseño UX/UI, prototipado y herramientas como Figma para crear experiencias digitales.',
            'nivel' => 'básico',
            'nombre' => 'Diseño UX/UI con Figma',
            'costo' => '449.00',
            'duracion' => '8 semanas',
            'modalidad' => 'virtual',
            'fecha_inicio' => '2024-02-15',
            'fecha_fin' => '2024-04-15',
            'ciclo_id' => $ciclo4->id
        ]);

        // 8. Crear matrículas
        $matricula1 = Matricula::create([
            'fecha' => '2024-01-10',
            'monto' => 299.00,
            'metodo_pago' => 'tarjeta',
            'estado_pago' => 'pagado',
            'nombre_pago' => 'Paco Yunque',
            'trabajador_id' => $trabajadorSecretaria->id,
            'ciclo_id' => $ciclo1->id,
            'estudiante_id' => $estudiante1->id
        ]);

        $matricula2 = Matricula::create([
            'fecha' => '2024-01-25',
            'monto' => 499.00,
            'metodo_pago' => 'transferencia',
            'estado_pago' => 'pagado',
            'nombre_pago' => 'Ana Torres',
            'trabajador_id' => $trabajadorSecretaria->id,
            'ciclo_id' => $ciclo1->id,
            'estudiante_id' => $estudiante2->id
        ]);

        $matricula3 = Matricula::create([
            'fecha' => '2024-02-20',
            'monto' => 599.00,
            'metodo_pago' => 'efectivo',
            'estado_pago' => 'pendiente',
            'nombre_pago' => 'José Mendoza',
            'trabajador_id' => $trabajadorSecretaria->id,
            'ciclo_id' => $ciclo2->id,
            'estudiante_id' => $estudiante3->id
        ]);

        // 9. Crear relaciones curso-estudiante
        CursoEstudiante::create([
            'usuario_id' => $estudiante1->id,
            'curso_id' => $curso1->id,
            'progreso' => 75.50,
            'calificacion_final' => 16.5,
            'estado' => 'activo',
            'matricula_id' => $matricula1->id
        ]);

        CursoEstudiante::create([
            'usuario_id' => $estudiante2->id,
            'curso_id' => $curso2->id,
            'progreso' => 45.00,
            'estado' => 'activo',
            'matricula_id' => $matricula2->id
        ]);

        CursoEstudiante::create([
            'usuario_id' => $estudiante3->id,
            'curso_id' => $curso3->id,
            'progreso' => 10.00,
            'estado' => 'inactivo',
            'matricula_id' => $matricula3->id
        ]);

        CursoEstudiante::create([
            'usuario_id' => $estudiante1->id,
            'curso_id' => $curso4->id,
            'progreso' => 90.00,
            'calificacion_final' => 18.0,
            'estado' => 'completado',
            'matricula_id' => $matricula1->id
        ]);

        // 10. Crear videos de YouTube de ejemplo
        Video::create([
            'titulo' => 'Introducción a HTML - Conceptos Básicos',
            'descripcion' => 'En este video aprenderás los conceptos fundamentales de HTML y cómo estructurar una página web.',
            'url_youtube' => 'https://www.youtube.com/watch?v=UB1O30fR-EE',
            'duracion' => '15:30',
            'orden' => 1,
            'estado' => 'activo',
            'curso_id' => $curso1->id
        ]);

        Video::create([
            'titulo' => 'CSS para Principiantes - Estilos y Diseño',
            'descripcion' => 'Aprende CSS desde cero para dar estilo y diseño a tus páginas web.',
            'url_youtube' => 'https://www.youtube.com/watch?v=OWKXEJN67FE',
            'duracion' => '22:45',
            'orden' => 2,
            'estado' => 'activo',
            'curso_id' => $curso1->id
        ]);

        Video::create([
            'titulo' => 'JavaScript Básico - Variables y Funciones',
            'descripcion' => 'Introducción a JavaScript: variables, funciones y programación básica.',
            'url_youtube' => 'https://www.youtube.com/watch?v=RqQ1d1qEWlE',
            'duracion' => '18:20',
            'orden' => 3,
            'estado' => 'activo',
            'curso_id' => $curso1->id
        ]);

        Video::create([
            'titulo' => 'React.js - Componentes y Props',
            'descripcion' => 'Aprende a crear componentes reutilizables en React y cómo pasar datos entre ellos.',
            'url_youtube' => 'https://www.youtube.com/watch?v=SqcY0GlETPk',
            'duracion' => '25:10',
            'orden' => 1,
            'estado' => 'activo',
            'curso_id' => $curso2->id
        ]);

        Video::create([
            'titulo' => 'Node.js y Express - Creando tu Primer Servidor',
            'descripcion' => 'Tutorial completo para crear un servidor web con Node.js y Express.',
            'url_youtube' => 'https://www.youtube.com/watch?v=fBNz5xF-Kx4',
            'duracion' => '30:45',
            'orden' => 1,
            'estado' => 'activo',
            'curso_id' => $curso3->id
        ]);

        Video::create([
            'titulo' => 'MySQL - Diseño de Base de Datos',
            'descripcion' => 'Aprende los principios del diseño de bases de datos relacionales con MySQL.',
            'url_youtube' => 'https://www.youtube.com/watch?v=HXV3zeQKqGY',
            'duracion' => '28:15',
            'orden' => 1,
            'estado' => 'activo',
            'curso_id' => $curso4->id
        ]);
    }
}
