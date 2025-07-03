<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Ciclo;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('secretaria.cursos.index', compact('cursos'));
    }

    public function create()
    {
        $ciclos = Ciclo::all();
        return view('secretaria.cursos.create', compact('ciclos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ciclo_id' => 'required|exists:ciclos,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('secretaria.cursos.index')
                         ->with('success', 'Curso creado exitosamente.');
    }

    public function show(Curso $curso)
    {
        return view('secretaria.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $ciclos = Ciclo::all();
        return view('secretaria.cursos.edit', compact('curso', 'ciclos'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ciclo_id' => 'required|exists:ciclos,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('secretaria.cursos.index')
                         ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('secretaria.cursos.index')
                         ->with('success', 'Curso eliminado exitosamente.');
    }
}
