<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Ciclo;
use App\Models\Ciclo;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::all();
        return view('secretaria.matriculas.index', compact('matriculas'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        $ciclos = Ciclo::all();
        $trabajadores = \App\Models\Trabajador::all();
        return view('secretaria.matriculas.create', compact('estudiantes', 'ciclos', 'trabajadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiante,id',
            'ciclo_id' => 'required|exists:ciclo,id',
            'trabajador_id' => 'required|exists:trabajador,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'nullable|string|max:255',
            'estado_pago' => 'required|in:pendiente,pagado,vencido',
            'nombre_pago' => 'nullable|string|max:255',
        ]);

        Matricula::create($request->all());

        return redirect()->route('secretaria.matriculas.index')
                         ->with('success', 'Matrícula creada exitosamente.');
    }

    public function show(Matricula $matricula)
    {
        return view('secretaria.matriculas.show', compact('matricula'));
    }

    public function edit(Matricula $matricula)
    {
        $estudiantes = Estudiante::all();
        $ciclos = Ciclo::all();
        $trabajadores = \App\Models\Trabajador::all();
        return view('secretaria.matriculas.edit', compact('matricula', 'estudiantes', 'ciclos', 'trabajadores'));

    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiante,id',
            'ciclo_id' => 'required|exists:ciclo,id',
            'trabajador_id' => 'required|exists:trabajador,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'nullable|string|max:255',
            'estado_pago' => 'required|in:pendiente,pagado,vencido',
            'nombre_pago' => 'nullable|string|max:255',
        ]);

        $matricula->update($request->all());

        return redirect()->route('secretaria.matriculas.index')
                         ->with('success', 'Matrícula actualizada exitosamente.');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();

        return redirect()->route('secretaria.matriculas.index')
                         ->with('success', 'Matrícula eliminada exitosamente.');
    }
}
