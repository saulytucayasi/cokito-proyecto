<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CursoEstudiante;
use App\Models\Material;
use App\Models\Estudiante;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $usuario = Usuario::where('email', $user->email)->first();
        $estudiante = Estudiante::where('usuario_id', $usuario->id)->first();
        
        if (!$estudiante) {
            return redirect('/login');
        }
        
        $cursosMatriculados = CursoEstudiante::where('estudiante_id', $estudiante->id)
            ->with(['curso', 'matricula'])
            ->count();
            
        $progresoPromedio = CursoEstudiante::where('estudiante_id', $estudiante->id)
            ->avg('progreso') ?? 0;
            
        $materialesDisponibles = Material::whereIn('curso_id', function($query) use ($estudiante) {
            $query->select('curso_id')
                  ->from('curso_estudiante')
                  ->where('estudiante_id', $estudiante->id);
        })->where('es_publico', true)->count();
        
        $misCursos = CursoEstudiante::where('estudiante_id', $estudiante->id)
            ->with(['curso.ciclo', 'matricula'])
            ->latest()
            ->get();
            
        return view('estudiante.dashboard', compact(
            'cursosMatriculados',
            'progresoPromedio',
            'materialesDisponibles',
            'misCursos'
        ));
    }

    
}
