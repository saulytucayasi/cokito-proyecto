<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Academia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsuarios = Usuario::count();
        $totalEstudiantes = Estudiante::count();
        $totalCursos = Curso::count();
        $totalMatriculas = Matricula::count();
        
        $ultimasMatriculas = Matricula::with(['estudiante', 'ciclo'])
            ->latest()
            ->limit(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalEstudiantes', 
            'totalCursos',
            'totalMatriculas',
            'ultimasMatriculas'
        ));
    }

    // The following methods were removed as their functionality is now handled by dedicated resource controllers:
    // public function usuarios() { ... }
    // public function cursos() { ... }
    // public function estudiantes() { ... }
    // public function matriculas() { ... }
    }
