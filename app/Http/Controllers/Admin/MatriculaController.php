<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\CursoEstudiante;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::with(['estudiante', 'ciclo', 'trabajador'])
                              ->latest()
                              ->get();
        
        $estadisticas = [
            'total' => $matriculas->count(),
            'pendientes' => $matriculas->where('estado_pago', 'pendiente')->count(),
            'pagadas' => $matriculas->where('estado_pago', 'pagado')->count(),
            'vencidas' => $matriculas->where('estado_pago', 'vencido')->count(),
        ];
        
        return view('admin.matriculas.index', compact('matriculas', 'estadisticas'));
    }

    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $ciclos = Ciclo::where('estado', 'activo')
                      ->orderBy('fecha_inicio', 'desc')
                      ->get();
        $trabajadores = Trabajador::where('estado', 'activo')
                                 ->orderBy('nombre', 'asc')
                                 ->get();
        
        return view('admin.matriculas.create', compact('estudiantes', 'ciclos', 'trabajadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiante,id',
            'ciclo_id' => 'required|exists:ciclo,id',
            'trabajador_id' => 'required|exists:trabajador,id',
            'cursos' => 'required|array|min:1',
            'cursos.*' => 'exists:curso,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'nullable|string|max:255',
            'estado_pago' => 'required|in:pendiente,pagado,vencido',
            'nombre_pago' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // Crear matrícula
            $matricula = Matricula::create([
                'estudiante_id' => $request->estudiante_id,
                'ciclo_id' => $request->ciclo_id,
                'trabajador_id' => $request->trabajador_id,
                'fecha' => $request->fecha,
                'monto' => $request->monto,
                'metodo_pago' => $request->metodo_pago,
                'estado_pago' => $request->estado_pago,
                'nombre_pago' => $request->nombre_pago,
            ]);

            // Inscribir estudiante en los cursos seleccionados
            foreach ($request->cursos as $cursoId) {
                CursoEstudiante::create([
                    'estudiante_id' => $request->estudiante_id,
                    'curso_id' => $cursoId,
                    'matricula_id' => $matricula->id,
                    'progreso' => 0,
                    'estado' => 'activo'
                ]);
            }
        });

        return redirect()->route('admin.matriculas.index')
                         ->with('success', 'Matrícula creada exitosamente y estudiante inscrito en los cursos.');
    }

    public function show(Matricula $matricula)
    {
        return view('admin.matriculas.show', compact('matricula'));
    }

    public function edit(Matricula $matricula)
    {
        $estudiantes = Estudiante::all();
        $ciclos = Ciclo::all();
        $trabajadores = Trabajador::all();
        return view('admin.matriculas.edit', compact('matricula', 'estudiantes', 'ciclos', 'trabajadores'));
    }

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

        return redirect()->route('admin.matriculas.index')
                         ->with('success', 'Matrícula actualizada exitosamente.');
    }

    public function destroy(Matricula $matricula)
    {
        DB::transaction(function () use ($matricula) {
            // Eliminar inscripciones a cursos relacionadas
            CursoEstudiante::where('matricula_id', $matricula->id)->delete();
            
            // Eliminar matrícula
            $matricula->delete();
        });

        return redirect()->route('admin.matriculas.index')
                         ->with('success', 'Matrícula eliminada exitosamente.');
    }

    public function getCursosPorCiclo(Request $request)
    {
        $cicloId = $request->get('ciclo_id');
        $cursos = Curso::where('ciclo_id', $cicloId)
                      ->where('estado', 'activo')
                      ->with('docente')
                      ->orderBy('nombre')
                      ->get();

        return response()->json($cursos);
    }

    public function matricularMasivo()
    {
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $ciclos = Ciclo::where('estado', 'activo')
                      ->orderBy('fecha_inicio', 'desc')
                      ->get();
        
        return view('admin.matriculas.masivo', compact('estudiantes', 'ciclos'));
    }

    public function procesarMatriculaMasiva(Request $request)
    {
        $request->validate([
            'estudiantes' => 'required|array|min:1',
            'estudiantes.*' => 'exists:estudiante,id',
            'ciclo_id' => 'required|exists:ciclo,id',
            'cursos' => 'required|array|min:1',
            'cursos.*' => 'exists:curso,id',
            'trabajador_id' => 'required|exists:trabajador,id',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'nullable|string|max:255',
            'estado_pago' => 'required|in:pendiente,pagado,vencido',
        ]);

        $matriculasCreadas = 0;

        DB::transaction(function () use ($request, &$matriculasCreadas) {
            foreach ($request->estudiantes as $estudianteId) {
                $matricula = Matricula::create([
                    'estudiante_id' => $estudianteId,
                    'ciclo_id' => $request->ciclo_id,
                    'trabajador_id' => $request->trabajador_id,
                    'fecha' => now(),
                    'monto' => $request->monto,
                    'metodo_pago' => $request->metodo_pago,
                    'estado_pago' => $request->estado_pago,
                    'nombre_pago' => 'Matrícula masiva',
                ]);

                foreach ($request->cursos as $cursoId) {
                    CursoEstudiante::create([
                        'estudiante_id' => $estudianteId,
                        'curso_id' => $cursoId,
                        'matricula_id' => $matricula->id,
                        'progreso' => 0,
                        'estado' => 'activo'
                    ]);
                }

                $matriculasCreadas++;
            }
        });

        return redirect()->route('admin.matriculas.index')
                         ->with('success', "Se crearon {$matriculasCreadas} matrículas exitosamente.");
    }
}
