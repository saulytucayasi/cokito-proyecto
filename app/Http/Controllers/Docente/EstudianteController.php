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
        
        // Obtener estudiantes únicos y agrupar información de cursos
        $estudiantesUnicos = collect();
        $estudiantes->each(function ($estudiante) use ($docente, &$estudiantesUnicos) {
            // Verificar si ya tenemos este estudiante
            $estudianteExistente = $estudiantesUnicos->firstWhere('id', $estudiante->id);
            
            if (!$estudianteExistente) {
                // Obtener todos los cursos del estudiante con este docente
                $cursosDelEstudiante = CursoEstudiante::where('estudiante_id', $estudiante->id)
                    ->whereIn('curso_id', function($query) use ($docente) {
                        $query->select('id')
                              ->from('curso')
                              ->where('docente_id', $docente->id);
                    })
                    ->with(['curso.ciclo'])
                    ->get();
                    
                $estudiante->mis_cursos = $cursosDelEstudiante;
                
                // Calcular estadísticas generales
                $estudiante->total_cursos = $cursosDelEstudiante->count();
                $estudiante->progreso_promedio = $cursosDelEstudiante->avg('progreso') ?? 0;
                $estudiante->calificacion_promedio = $cursosDelEstudiante->whereNotNull('calificacion_final')->avg('calificacion_final');
                
                $estudiantesUnicos->push($estudiante);
            }
        });
        
        // Obtener todas las áreas (ciclos) de los cursos del docente
        $areas = $estudiantesUnicos->flatMap(function($estudiante) {
            return $estudiante->mis_cursos->pluck('curso.ciclo');
        })->filter()->unique('id')->values();
        
        return view('docente.estudiantes.index', compact('estudiantesUnicos', 'areas', 'cursoNombre', 'curso'));
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
            ->with(['curso.ciclo', 'matricula'])
            ->get();
            
        if ($cursosCompartidos->isEmpty()) {
            return redirect()->back()->with('error', 'No tiene acceso a este estudiante');
        }
        
        // Calcular estadísticas del estudiante
        $estadisticas = [
            'total_cursos' => $cursosCompartidos->count(),
            'cursos_activos' => $cursosCompartidos->where('estado', 'activo')->count(),
            'progreso_promedio' => $cursosCompartidos->avg('progreso') ?? 0,
            'calificacion_promedio' => $cursosCompartidos->whereNotNull('calificacion_final')->avg('calificacion_final'),
            'cursos_aprobados' => $cursosCompartidos->where('calificacion_final', '>=', 11)->count(),
            'cursos_con_calificacion' => $cursosCompartidos->whereNotNull('calificacion_final')->count()
        ];
        
        return view('docente.estudiantes.show', compact('estudiante', 'cursosCompartidos', 'estadisticas'));
    }

    public function calificar(Request $request)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return response()->json(['success' => false, 'message' => 'Acceso denegado'], 403);
        }

        $request->validate([
            'curso_estudiante_id' => 'required|exists:curso_estudiante,id',
            'calificacion_final' => 'required|numeric|min:0|max:20',
            'progreso' => 'required|numeric|min:0|max:100',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        try {
            $cursoEstudiante = CursoEstudiante::findOrFail($request->curso_estudiante_id);
            
            // Verificar que el docente tenga acceso a este curso
            if ($cursoEstudiante->curso->docente_id !== $docente->id) {
                return response()->json(['success' => false, 'message' => 'No tiene permisos para calificar este estudiante'], 403);
            }

            $cursoEstudiante->update([
                'calificacion_final' => $request->calificacion_final,
                'progreso' => $request->progreso,
                'observaciones' => $request->observaciones
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Calificación guardada exitosamente',
                'data' => [
                    'calificacion_final' => $cursoEstudiante->calificacion_final,
                    'progreso' => $cursoEstudiante->progreso,
                    'observaciones' => $cursoEstudiante->observaciones
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar la calificación: ' . $e->getMessage()], 500);
        }
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
