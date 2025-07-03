<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Trabajador;
use App\Models\Usuario;
use App\Models\CursoEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    public function index(Curso $curso = null)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        if ($curso) {
            // Verificar que el docente esté asignado al curso
            if (!$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
                return redirect()->back()->with('error', 'No tiene acceso a este curso');
            }
            
            $estudiantes = $curso->cursoEstudiantes()
                ->with(['estudiante', 'matricula'])
                ->get()
                ->map(function ($cursoEstudiante) {
                    return $cursoEstudiante->estudiante;
                })->filter();
                
            $cursoNombre = $curso->nombre;
        } else {
            // Obtener todos los estudiantes de los cursos asignados al docente
            $estudiantes = Estudiante::whereIn('id', function($query) use ($docente) {
                $query->select('estudiante_id')
                      ->from('curso_estudiante')
                      ->whereIn('curso_id', function($subQuery) use ($docente) {
                          $subQuery->select('id')
                                   ->from('curso')
                                   ->where('docente_id', $docente->id);
                      });
            })->get();
            
            $cursoNombre = null;
        }
        
        // Obtener información adicional de los cursos para cada estudiante
        $estudiantesConCursos = $estudiantes->map(function ($estudiante) use ($docente) {
            $cursosDelEstudiante = CursoEstudiante::where('estudiante_id', $estudiante->id)
                ->whereIn('curso_id', function($query) use ($docente) {
                    $query->select('id')
                          ->from('curso')
                          ->where('docente_id', $docente->id);
                })
                ->with('curso')
                ->get();
                
            $estudiante->mis_cursos = $cursosDelEstudiante;
            return $estudiante;
        });
        
        return view('docente.estudiantes.index', compact('estudiantesConCursos', 'cursoNombre', 'curso'));
    }

    public function show(Estudiante $estudiante)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el estudiante esté en algún curso del docente
        $cursosCompartidos = CursoEstudiante::where('estudiante_id', $estudiante->id)
            ->whereIn('curso_id', function($query) use ($docente) {
                $query->select('id')
                      ->from('curso')
                      ->where('docente_id', $docente->id);
            })
            ->with('curso')
            ->get();
            
        if ($cursosCompartidos->isEmpty()) {
            return redirect()->back()->with('error', 'No tiene acceso a este estudiante');
        }
        
        return view('docente.estudiantes.show', compact('estudiante', 'cursosCompartidos'));
    }

    protected function getDocenteActual()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        // Buscar usuario en tabla usuario por email
        $usuario = Usuario::where('email', $user->email)->first();
        
        if (!$usuario) {
            return null;
        }

        // Buscar trabajador por usuario_id que corresponde al ID de la tabla usuario
        return Trabajador::where('usuario_id', $usuario->id)->first();
    }
}
