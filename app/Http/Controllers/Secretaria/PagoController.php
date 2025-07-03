<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::all();
        return view('secretaria.pagos.index', compact('pagos'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        $matriculas = Matricula::all();
        return view('secretaria.pagos.create', compact('estudiantes', 'matriculas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'matricula_id' => 'required|exists:matriculas,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);

        Pago::create($request->all());

        return redirect()->route('secretaria.pagos.index')
                         ->with('success', 'Pago registrado exitosamente.');
    }

    public function show(Pago $pago)
    {
        return view('secretaria.pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $estudiantes = Estudiante::all();
        $matriculas = Matricula::all();
        return view('secretaria.pagos.edit', compact('pago', 'estudiantes', 'matriculas'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'matricula_id' => 'required|exists:matriculas,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);

        $pago->update($request->all());

        return redirect()->route('secretaria.pagos.index')
                         ->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()->route('secretaria.pagos.index')
                         ->with('success', 'Pago eliminado exitosamente.');
    }
}
