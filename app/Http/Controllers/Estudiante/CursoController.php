<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Material;
use App\Models\Estudiante;
use App\Models\ProgresoSesion;
use App\Models\CursoEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index()
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosInscritos = $estudiante->cursoEstudiantes()
            ->with(['curso.ciclo', 'curso.docente', 'matricula'])
            ->get();

        return view('estudiante.cursos.index', compact('cursosInscritos'));
    }

    public function show(Curso $curso)
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el estudiante esté inscrito en el curso
        $cursoEstudiante = $estudiante->cursoEstudiantes()
            ->where('curso_id', $curso->id)
            ->first();

        if (!$cursoEstudiante) {
            return redirect()->back()->with('error', 'No tienes acceso a este curso');
        }

        // Cargar datos del curso
        $curso->load(['ciclo', 'docente', 'materiales', 'videos', 'sesiones']);
        
        // Obtener progreso de sesiones del estudiante
        $progresoSesiones = ProgresoSesion::where('estudiante_id', $estudiante->id)
            ->whereIn('sesion_id', $curso->sesiones->pluck('id'))
            ->get()
            ->keyBy('sesion_id');

        return view('estudiante.cursos.show', compact('curso', 'cursoEstudiante', 'progresoSesiones'));
    }

    public function verMateriales(Curso $curso)
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursoEstudiante = $estudiante->cursoEstudiantes()
            ->where('curso_id', $curso->id)
            ->first();

        if (!$cursoEstudiante) {
            return redirect()->back()->with('error', 'No tienes acceso a este curso');
        }

        $materiales = $curso->materiales()
            ->where('es_publico', true)
            ->orderBy('orden')
            ->get();

        return view('estudiante.cursos.materiales', compact('curso', 'materiales'));
    }

    public function verVideos(Curso $curso)
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursoEstudiante = $estudiante->cursoEstudiantes()
            ->where('curso_id', $curso->id)
            ->first();

        if (!$cursoEstudiante) {
            return redirect()->back()->with('error', 'No tienes acceso a este curso');
        }

        $videos = $curso->videos()
            ->where('estado', 'activo')
            ->orderBy('orden')
            ->get();

        return view('estudiante.cursos.videos', compact('curso', 'videos'));
    }

    public function verSesiones(Curso $curso)
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursoEstudiante = $estudiante->cursoEstudiantes()
            ->where('curso_id', $curso->id)
            ->first();

        if (!$cursoEstudiante) {
            return redirect()->back()->with('error', 'No tienes acceso a este curso');
        }

        $sesiones = $curso->sesiones()->orderBy('orden')->get();
        
        $progresoSesiones = ProgresoSesion::where('estudiante_id', $estudiante->id)
            ->whereIn('sesion_id', $sesiones->pluck('id'))
            ->get()
            ->keyBy('sesion_id');

        return view('estudiante.cursos.sesiones', compact('curso', 'sesiones', 'progresoSesiones'));
    }

    public function verCalificaciones(Curso $curso)
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursoEstudiante = $estudiante->cursoEstudiantes()
            ->where('curso_id', $curso->id)
            ->first();

        if (!$cursoEstudiante) {
            return redirect()->back()->with('error', 'No tienes acceso a este curso');
        }

        $sesiones = $curso->sesiones()->orderBy('orden')->get();
        
        $calificacionesSesiones = ProgresoSesion::where('estudiante_id', $estudiante->id)
            ->whereIn('sesion_id', $sesiones->pluck('id'))
            ->whereNotNull('calificacion')
            ->with('sesion')
            ->get();

        return view('estudiante.cursos.calificaciones', compact('curso', 'cursoEstudiante', 'calificacionesSesiones'));
    }

    protected function getEstudianteActual()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        // Buscar usuario en tabla usuario por email
        $usuario = \App\Models\Usuario::where('email', $user->email)->first();
        
        if (!$usuario) {
            return null;
        }

        // Buscar estudiante por usuario_id que corresponde al ID de la tabla usuario
        return Estudiante::where('usuario_id', $usuario->id)->first();
    }
}
