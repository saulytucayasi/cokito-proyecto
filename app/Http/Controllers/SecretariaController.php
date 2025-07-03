<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Ciclo;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Auth;

class SecretariaController extends Controller
{
    public function dashboard()
    {
        $matriculasPendientes = Matricula::where('estado_pago', 'pendiente')->count();
        $matriculasHoy = Matricula::whereDate('fecha', today())->count();
        $totalRecaudado = Matricula::where('estado_pago', 'pagado')
            ->sum('monto');
        
        $ultimasMatriculas = Matricula::with(['estudiante', 'ciclo'])
            ->latest()
            ->limit(5)
            ->get();
            
        return view('secretaria.dashboard', compact(
            'matriculasPendientes',
            'matriculasHoy',
            'totalRecaudado',
            'ultimasMatriculas'
        ));
    }

    
}
