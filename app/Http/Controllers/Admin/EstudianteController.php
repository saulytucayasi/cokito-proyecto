<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('admin.estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('admin.estudiantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:estudiante',
            'correo' => 'required|email|max:255|unique:estudiante',
            'fecha_nacimiento' => 'nullable|date',
            'telefono' => 'nullable|string|max:20',
        ]);

        Estudiante::create($request->all());

        return redirect()->route('admin.estudiantes.index')
                         ->with('success', 'Estudiante creado exitosamente.');
    }

    public function show(Estudiante $estudiante)
    {
        return view('admin.estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        return view('admin.estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:estudiante,dni,' . $estudiante->id,
            'correo' => 'required|email|max:255|unique:estudiante,correo,' . $estudiante->id,
            'fecha_nacimiento' => 'nullable|date',
            'telefono' => 'nullable|string|max:20',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('admin.estudiantes.index')
                         ->with('success', 'Estudiante actualizado exitosamente.');
    }

    public function destroy(Estudiante $estudiante)
    {
        // Eliminar primero todas las relaciones que referencian al estudiante
        $estudiante->cursoEstudiantes()->delete();
        $estudiante->matriculas()->delete();
        $estudiante->progresoSesiones()->delete();
        
        // Eliminar el estudiante
        $estudiante->delete();

        return redirect()->route('admin.estudiantes.index')
                         ->with('success', 'Estudiante eliminado exitosamente.');
    }
}
