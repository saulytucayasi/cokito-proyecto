<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Ciclo;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('admin.cursos.index', compact('cursos'));
    }

    public function create()
    {
        $ciclos = Ciclo::all();
        return view('admin.cursos.create', compact('ciclos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ciclo_id' => 'required|exists:ciclo,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('admin.cursos.index')
                         ->with('success', 'Curso creado exitosamente.');
    }

    public function show(Curso $curso)
    {
        return view('admin.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $ciclos = Ciclo::all();
        return view('admin.cursos.edit', compact('curso', 'ciclos'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ciclo_id' => 'required|exists:ciclo,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('admin.cursos.index')
                         ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Curso $curso)
    {
        // Verificar si el curso puede ser eliminado
        if ($curso->cursoEstudiantes->isNotEmpty() || 
            $curso->videos->isNotEmpty() || 
            $curso->materiales->isNotEmpty() || 
            $curso->sesiones->isNotEmpty()) {
            return redirect()->route('admin.cursos.index')
                             ->with('error', 'No se puede eliminar el curso porque tiene relaciones activas.');
        }

        $curso->delete();

        return redirect()->route('admin.cursos.index')
                         ->with('success', 'Curso eliminado exitosamente.');
    }
}
