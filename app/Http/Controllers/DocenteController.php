<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\CursoEstudiante;
use App\Models\Material;
use App\Models\Trabajador;
use App\Models\Usuario;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
    public function dashboard()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }
        
        // Obtener cursos del docente actual
        $misCursos = Curso::where('docente_id', $docente->id)->count();
        
        // Estudiantes en mis cursos
        $misEstudiantes = CursoEstudiante::whereIn('curso_id', function($query) use ($docente) {
            $query->select('id')
                  ->from('curso')
                  ->where('docente_id', $docente->id);
        })->count();
        
        // Materiales subidos en mis cursos
        $materialesSubidos = Material::whereIn('curso_id', function($query) use ($docente) {
            $query->select('id')
                  ->from('curso')
                  ->where('docente_id', $docente->id);
        })->count();
        
        // Videos subidos en mis cursos
        $videosSubidos = Video::whereIn('curso_id', function($query) use ($docente) {
            $query->select('id')
                  ->from('curso')
                  ->where('docente_id', $docente->id);
        })->count();
        
        // Cursos recientes del docente
        $cursosRecientes = Curso::with(['ciclo', 'sesiones', 'materiales', 'videos'])
            ->where('docente_id', $docente->id)
            ->latest()
            ->limit(5)
            ->get();
            
        return view('docente.dashboard', compact(
            'misCursos',
            'misEstudiantes',
            'materialesSubidos',
            'videosSubidos',
            'cursosRecientes',
            'docente'
        ));
    }

    protected function getDocenteActual()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        // Buscar usuario en tabla usuario por email
        $usuario = Usuario::where('email', $user->email)->first();
        
        if (!$usuario) {
            return null;
        }

        // Buscar trabajador por usuario_id que corresponde al ID de la tabla usuario
        return Trabajador::where('usuario_id', $usuario->id)->first();
    }
}
