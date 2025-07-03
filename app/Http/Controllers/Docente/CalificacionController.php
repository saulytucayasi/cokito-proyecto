<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\CursoEstudiante;
use App\Models\Sesion;
use App\Models\ProgresoSesion;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    public function index()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()
            ->with(['cursoEstudiantes.estudiante', 'ciclo'])
            ->get();

        return view('docente.calificaciones.index', compact('cursosAsignados'));
    }

    public function verEstudiantesCurso(Curso $curso)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este curso');
        }

        $estudiantes = $curso->cursoEstudiantes()
            ->with(['estudiante', 'matricula'])
            ->where('estado', 'activo')
            ->get();

        $sesiones = $curso->sesiones()->orderBy('orden')->get();

        // Obtener progreso de sesiones para cada estudiante
        $progresoSesiones = [];
        foreach ($estudiantes as $cursoEstudiante) {
            $progresoSesiones[$cursoEstudiante->estudiante_id] = ProgresoSesion::where('estudiante_id', $cursoEstudiante->estudiante_id)
                ->whereIn('sesion_id', $sesiones->pluck('id'))
                ->get()
                ->keyBy('sesion_id');
        }

        return view('docente.calificaciones.estudiantes', compact('curso', 'estudiantes', 'sesiones', 'progresoSesiones'));
    }

    public function calificarSesion(Request $request, Sesion $sesion)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $sesion->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para calificar esta sesión');
        }

        $request->validate([
            'estudiante_id' => 'required|exists:estudiante,id',
            'calificacion' => 'required|numeric|min:0|max:20',
            'completada' => 'boolean',
            'notas' => 'nullable|string|max:500'
        ]);

        $progresoSesion = ProgresoSesion::updateOrCreate(
            [
                'estudiante_id' => $request->estudiante_id,
                'sesion_id' => $sesion->id
            ],
            [
                'calificacion' => $request->calificacion,
                'completada' => $request->has('completada'),
                'fecha_completada' => $request->has('completada') ? now() : null,
                'notas' => $request->notas
            ]
        );

        // Actualizar progreso del curso basado en sesiones completadas
        $cursoEstudiante = CursoEstudiante::where('estudiante_id', $request->estudiante_id)
                                         ->where('curso_id', $sesion->curso_id)
                                         ->first();
        
        if ($cursoEstudiante) {
            $cursoEstudiante->actualizarProgreso();
        }

        return redirect()->back()->with('success', 'Calificación guardada exitosamente');
    }

    public function calificarCurso(Request $request, CursoEstudiante $cursoEstudiante)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $cursoEstudiante->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para calificar este curso');
        }

        $request->validate([
            'calificacion_final' => 'required|numeric|min:0|max:20',
            'estado' => 'required|in:activo,completado,reprobado'
        ]);

        $cursoEstudiante->update([
            'calificacion_final' => $request->calificacion_final,
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Calificación final actualizada exitosamente');
    }

    public function calcularNotaPromedio(CursoEstudiante $cursoEstudiante)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $cursoEstudiante->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para calcular la nota de este curso');
        }

        $sesiones = $cursoEstudiante->curso->sesiones;
        
        if ($sesiones->isEmpty()) {
            return redirect()->back()->with('error', 'El curso no tiene sesiones para calcular promedio');
        }

        $progresoSesiones = ProgresoSesion::where('estudiante_id', $cursoEstudiante->estudiante_id)
                                         ->whereIn('sesion_id', $sesiones->pluck('id'))
                                         ->whereNotNull('calificacion')
                                         ->get();

        if ($progresoSesiones->isEmpty()) {
            return redirect()->back()->with('error', 'No hay calificaciones de sesiones para calcular promedio');
        }

        $promedio = $progresoSesiones->avg('calificacion');

        $cursoEstudiante->update([
            'calificacion_final' => round($promedio, 2)
        ]);

        return redirect()->back()->with('success', "Promedio calculado: {$promedio}");
    }

    public function exportarCalificaciones(Curso $curso)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este curso');
        }

        $estudiantes = $curso->cursoEstudiantes()
            ->with(['estudiante'])
            ->where('estado', 'activo')
            ->get();

        $sesiones = $curso->sesiones()->orderBy('orden')->get();

        // Obtener todas las calificaciones
        $calificaciones = [];
        foreach ($estudiantes as $cursoEstudiante) {
            $progresoSesiones = ProgresoSesion::where('estudiante_id', $cursoEstudiante->estudiante_id)
                ->whereIn('sesion_id', $sesiones->pluck('id'))
                ->get()
                ->keyBy('sesion_id');

            $calificaciones[] = [
                'estudiante' => $cursoEstudiante->estudiante,
                'progreso_sesiones' => $progresoSesiones,
                'calificacion_final' => $cursoEstudiante->calificacion_final,
                'progreso' => $cursoEstudiante->progreso
            ];
        }

        return view('docente.calificaciones.exportar', compact('curso', 'sesiones', 'calificaciones'));
    }

    public function marcarAsistencia(Request $request, Sesion $sesion)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $sesion->curso_id)->exists()) {
            return response()->json(['error' => 'No tiene permisos'], 403);
        }

        $request->validate([
            'asistencias' => 'required|array',
            'asistencias.*' => 'exists:estudiante,id'
        ]);

        DB::transaction(function () use ($request, $sesion) {
            // Obtener todos los estudiantes del curso
            $estudiantesDelCurso = CursoEstudiante::where('curso_id', $sesion->curso_id)
                                                 ->where('estado', 'activo')
                                                 ->pluck('estudiante_id');

            foreach ($estudiantesDelCurso as $estudianteId) {
                $asistio = in_array($estudianteId, $request->asistencias);
                
                ProgresoSesion::updateOrCreate(
                    [
                        'estudiante_id' => $estudianteId,
                        'sesion_id' => $sesion->id
                    ],
                    [
                        'completada' => $asistio,
                        'fecha_completada' => $asistio ? now() : null
                    ]
                );

                // Actualizar progreso del curso
                if ($asistio) {
                    $cursoEstudiante = CursoEstudiante::where('estudiante_id', $estudianteId)
                                                     ->where('curso_id', $sesion->curso_id)
                                                     ->first();
                    if ($cursoEstudiante) {
                        $cursoEstudiante->actualizarProgreso();
                    }
                }
            }
        });

        return response()->json(['message' => 'Asistencia registrada exitosamente']);
    }

    protected function getDocenteActual()
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return null;
        }

        return Trabajador::where('usuario_id', $usuario->id)->first();
    }
}