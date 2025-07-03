<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Ciclo;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()
            ->with(['cursoEstudiantes.estudiante', 'ciclo', 'materiales', 'videos', 'sesiones'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener todas las áreas (ciclos) que tienen cursos asignados al docente
        $areas = $cursosAsignados->pluck('ciclo')->filter()->unique('id')->values();
        
        return view('docente.cursos.index', compact('cursosAsignados', 'areas'));
    }

    public function create()
    {
        $ciclos = Ciclo::all();
        return view('docente.cursos.create', compact('ciclos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ciclo_id' => 'required|exists:ciclo,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('docente.cursos.index')
                         ->with('success', 'Curso creado exitosamente.');
    }

    public function show(Curso $curso)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el docente esté asignado al curso
        if (!$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este curso');
        }

        // Cargar todas las relaciones necesarias
        $curso->load([
            'ciclo',
            'sesiones' => function($query) {
                $query->orderBy('orden');
            },
            'materiales' => function($query) {
                $query->orderBy('orden');
            },
            'videos' => function($query) {
                $query->orderBy('orden');
            },
            'cursoEstudiantes.estudiante',
            'cursoEstudiantes.matricula'
        ]);

        return view('docente.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $ciclos = Ciclo::all();
        return view('docente.cursos.edit', compact('curso', 'ciclos'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ciclo_id' => 'required|exists:ciclo,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('docente.cursos.index')
                         ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('docente.cursos.index')
                         ->with('success', 'Curso eliminado exitosamente.');
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
}
