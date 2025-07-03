<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sesion;
use App\Models\Curso;
use App\Models\Ciclo;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function index()
    {
        $sesiones = Sesion::with(['curso.ciclo'])
                          ->orderBy('fecha_programada', 'desc')
                          ->paginate(20);
        
        return view('admin.sesiones.index', compact('sesiones'));
    }

    public function create()
    {
        $cursos = Curso::with('ciclo')->where('estado', 'activo')->get();
        $ciclos = Ciclo::where('estado', 'activo')->get();
        
        return view('admin.sesiones.create', compact('cursos', 'ciclos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:curso,id',
            'contenido' => 'nullable|string'
        ]);

        Sesion::create($request->all());

        return redirect()->route('admin.sesiones.index')
                         ->with('success', 'Sesión creada exitosamente.');
    }

    public function show(Sesion $sesion)
    {
        $sesion->load(['curso.ciclo', 'progresoEstudiantes.estudiante']);
        
        return view('admin.sesiones.show', compact('sesion'));
    }

    public function edit(Sesion $sesion)
    {
        $cursos = Curso::with('ciclo')->where('estado', 'activo')->get();
        $ciclos = Ciclo::where('estado', 'activo')->get();
        
        return view('admin.sesiones.edit', compact('sesion', 'cursos', 'ciclos'));
    }

    public function update(Request $request, Sesion $sesion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'orden' => 'required|integer|min:1',
            'estado' => 'required|in:pendiente,en_progreso,completada',
            'curso_id' => 'required|exists:curso,id',
            'contenido' => 'nullable|string'
        ]);

        $sesion->update($request->all());

        return redirect()->route('admin.sesiones.index')
                         ->with('success', 'Sesión actualizada exitosamente.');
    }

    public function destroy(Sesion $sesion)
    {
        $sesion->delete();

        return redirect()->route('admin.sesiones.index')
                         ->with('success', 'Sesión eliminada exitosamente.');
    }

    public function crearSesionesMasivas(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:curso,id',
            'cantidad_sesiones' => 'required|integer|min:1|max:50',
            'fecha_inicio' => 'required|date',
            'dias_semana' => 'required|array|min:1',
            'dias_semana.*' => 'in:1,2,3,4,5,6,7',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'duracion_minutos' => 'nullable|integer|min:15|max:480'
        ]);

        $curso = Curso::findOrFail($request->curso_id);
        $fechaActual = \Carbon\Carbon::parse($request->fecha_inicio);
        $diasSemana = $request->dias_semana;
        $cantidadSesiones = $request->cantidad_sesiones;
        $sesionesCreadas = 0;
        $orden = 1;

        while ($sesionesCreadas < $cantidadSesiones) {
            if (in_array($fechaActual->dayOfWeek, $diasSemana)) {
                Sesion::create([
                    'nombre' => "Sesión {$orden} - {$curso->nombre}",
                    'descripcion' => "Sesión programada automáticamente",
                    'fecha_programada' => $fechaActual->format('Y-m-d'),
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'orden' => $orden,
                    'estado' => 'pendiente',
                    'curso_id' => $curso->id
                ]);
                
                $sesionesCreadas++;
                $orden++;
            }
            
            $fechaActual->addDay();
        }

        return redirect()->route('admin.sesiones.index')
                         ->with('success', "Se crearon {$sesionesCreadas} sesiones exitosamente para el curso {$curso->nombre}.");
    }

    public function getSesionesPorCurso(Request $request)
    {
        $cursoId = $request->get('curso_id');
        $sesiones = Sesion::where('curso_id', $cursoId)
                          ->orderBy('orden')
                          ->get();

        return response()->json($sesiones);
    }

    public function duplicarSesion(Sesion $sesion)
    {
        $nuevaSesion = $sesion->replicate();
        $nuevaSesion->nombre = $sesion->nombre . ' (Copia)';
        $nuevaSesion->fecha_programada = now()->addDay();
        $nuevaSesion->estado = 'pendiente';
        $nuevaSesion->save();

        return redirect()->back()->with('success', 'Sesión duplicada exitosamente');
    }
}