<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trabajador;
use App\Models\Usuario;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('admin.trabajadores.index', compact('trabajadores'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        return view('admin.trabajadores.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:trabajador,correo',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|in:activo,inactivo',
            'usuario_id' => 'nullable|exists:usuario,id',
        ]);

        Trabajador::create($request->all());

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Trabajador creado exitosamente.');
    }

    public function show(Trabajador $trabajador)
    {
        return view('admin.trabajadores.show', compact('trabajador'));
    }

    public function edit(Trabajador $trabajador)
    {
        $usuarios = Usuario::all();
        return view('admin.trabajadores.edit', compact('trabajador', 'usuarios'));
    }

    public function update(Request $request, Trabajador $trabajador)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:trabajador,correo,' . $trabajador->id,
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|in:activo,inactivo',
            'usuario_id' => 'nullable|exists:usuario,id',
        ]);

        $trabajador->update($request->all());

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Trabajador actualizado exitosamente.');
    }

    public function destroy(Trabajador $trabajador)
    {
        // Verificar si el trabajador puede ser eliminado
        if ($trabajador->cursosAsignados->isNotEmpty() || 
            $trabajador->matriculas->isNotEmpty() || 
            $trabajador->materialesSubidos->isNotEmpty()) {
            return redirect()->route('admin.trabajadores.index')
                             ->with('error', 'No se puede eliminar el trabajador porque tiene cursos asignados, matrículas o materiales asociados.');
        }

        $trabajador->delete();

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Trabajador eliminado exitosamente.');
    }
}
