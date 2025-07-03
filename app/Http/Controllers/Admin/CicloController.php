<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ciclo;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    public function index()
    {
        $ciclos = Ciclo::all();
        return view('admin.ciclos.index', compact('ciclos'));
    }

    public function create()
    {
        return view('admin.ciclos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_area' => 'required|string|max:255',
            'nivel_complejidad' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo,finalizado',
        ]);

        Ciclo::create($request->all());

        return redirect()->route('admin.ciclos.index')
                         ->with('success', 'Ciclo creado exitosamente.');
    }

    public function show(Ciclo $ciclo)
    {
        return view('admin.ciclos.show', compact('ciclo'));
    }

    public function edit(Ciclo $ciclo)
    {
        return view('admin.ciclos.edit', compact('ciclo'));
    }

    public function update(Request $request, Ciclo $ciclo)
    {
        $request->validate([
            'nombre_area' => 'required|string|max:255',
            'nivel_complejidad' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo,finalizado',
        ]);

        $ciclo->update($request->all());

        return redirect()->route('admin.ciclos.index')
                         ->with('success', 'Ciclo actualizado exitosamente.');
    }

    public function destroy(Ciclo $ciclo)
    {
        // Verificar si el ciclo puede ser eliminado
        if ($ciclo->cursos->isNotEmpty() || $ciclo->matriculas->isNotEmpty()) {
            return redirect()->route('admin.ciclos.index')
                             ->with('error', 'No se puede eliminar el ciclo porque tiene cursos o matrículas asociadas.');
        }

        $ciclo->delete();

        return redirect()->route('admin.ciclos.index')
                         ->with('success', 'Ciclo eliminado exitosamente.');
    }
}
