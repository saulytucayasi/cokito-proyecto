<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Sesion;
use App\Models\Curso;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesionController extends Controller
{
    public function index()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()->with(['sesiones' => function($query) {
            $query->orderBy('orden');
        }, 'ciclo'])->get();

        return view('docente.sesiones.index', compact('cursosAsignados'));
    }

    public function create(Request $request)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()->with('ciclo')->get();
        $cursoId = $request->get('curso_id');
        
        return view('docente.sesiones.create', compact('cursosAsignados', 'cursoId'));
    }

    public function store(Request $request)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'nullable|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'duracion_minutos' => 'nullable|integer|min:1',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:curso,id',
            'estado' => 'required|in:programada,en_curso,completada,cancelada',
            'contenido' => 'nullable|string',
        ]);

        // Verificar que el docente esté asignado al curso
        if (!$docente->cursosAsignados()->where('id', $validatedData['curso_id'])->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para crear sesiones en este curso');
        }

        $sesion = Sesion::create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'fecha_programada' => $validatedData['fecha_programada'],
            'hora_inicio' => $validatedData['hora_inicio'],
            'hora_fin' => $validatedData['hora_fin'],
            'duracion_minutos' => $validatedData['duracion_minutos'],
            'orden' => $validatedData['orden'],
            'curso_id' => $validatedData['curso_id'],
            'estado' => $validatedData['estado'],
            'contenido' => $validatedData['contenido'],
        ]);

        return redirect()->route('docente.cursos.show', $validatedData['curso_id'])
                         ->with('success', 'Sesión creada exitosamente.');
    }

    public function show(Sesion $sesion)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el docente esté asignado al curso de la sesión
        if (!$docente->cursosAsignados()->where('id', $sesion->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a esta sesión');
        }

        $sesion->load(['curso.ciclo', 'progresoEstudiantes.estudiante']);
        
        return view('docente.sesiones.show', compact('sesion'));
    }

    public function edit(Sesion $sesion)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el docente esté asignado al curso de la sesión
        if (!$docente->cursosAsignados()->where('id', $sesion->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para editar esta sesión');
        }

        $cursosAsignados = $docente->cursosAsignados()->with('ciclo')->get();
        
        return view('docente.sesiones.edit', compact('sesion', 'cursosAsignados'));
    }

    public function update(Request $request, Sesion $sesion)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el docente esté asignado al curso de la sesión
        if (!$docente->cursosAsignados()->where('id', $sesion->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para editar esta sesión');
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'nullable|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'duracion_minutos' => 'nullable|integer|min:1',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:curso,id',
            'estado' => 'required|in:programada,en_curso,completada,cancelada',
            'contenido' => 'nullable|string',
        ]);

        // Verificar que el docente esté asignado al nuevo curso (si cambió)
        if (!$docente->cursosAsignados()->where('id', $validatedData['curso_id'])->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para mover esta sesión al curso seleccionado');
        }

        $sesion->update($validatedData);

        return redirect()->route('docente.cursos.show', $sesion->curso_id)
                         ->with('success', 'Sesión actualizada exitosamente.');
    }

    public function destroy(Sesion $sesion)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el docente esté asignado al curso de la sesión
        if (!$docente->cursosAsignados()->where('id', $sesion->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para eliminar esta sesión');
        }

        $cursoId = $sesion->curso_id;
        $sesion->delete();

        return redirect()->route('docente.cursos.show', $cursoId)
                         ->with('success', 'Sesión eliminada exitosamente.');
    }

    protected function getDocenteActual()
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

        // Buscar trabajador por usuario_id que corresponde al ID de la tabla usuario
        return Trabajador::where('usuario_id', $usuario->id)->first();
    }

    public function verSesionesPorCurso(Curso $curso)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este curso');
        }

        $sesiones = $curso->sesiones()->orderBy('orden')->get();
        
        return view('docente.sesiones.por-curso', compact('curso', 'sesiones'));
    }
}