<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Estudiante;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Obtener materiales de los cursos en los que está matriculado el estudiante
        $materiales = Material::whereIn('curso_id', function($query) use ($estudiante) {
            $query->select('curso_id')
                  ->from('curso_estudiante')
                  ->where('estudiante_id', $estudiante->id);
        })->where('es_publico', true)
          ->with('curso')
          ->get();
          
        return view('estudiante.materiales.index', compact('materiales'));
    }

    public function show(Material $material)
    {
        $estudiante = $this->getEstudianteActual();
        
        if (!$estudiante) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Verificar que el estudiante tenga acceso a este material
        $tieneAcceso = $estudiante->cursoEstudiantes()
            ->where('curso_id', $material->curso_id)
            ->exists();
            
        if (!$tieneAcceso) {
            return redirect()->back()->with('error', 'No tienes acceso a este material');
        }

        return view('estudiante.materiales.show', compact('material'));
    }

    protected function getEstudianteActual()
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

        // Buscar estudiante por usuario_id que corresponde al ID de la tabla usuario
        return Estudiante::where('usuario_id', $usuario->id)->first();
    }
}
