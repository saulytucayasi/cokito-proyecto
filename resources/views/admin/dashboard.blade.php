@extends('layouts.app')

@section('title', 'Dashboard Administrador - COKITO+ Academia')
@section('header', 'Dashboard Administrador')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $totalUsuarios }}</div>
        <div class="stat-label">Total Usuarios</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $totalEstudiantes }}</div>
        <div class="stat-label">Estudiantes Registrados</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $totalCursos }}</div>
        <div class="stat-label">Cursos Disponibles</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $totalMatriculas }}</div>
        <div class="stat-label">Total Matrículas</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div class="card">
        <div class="card-header">
            <h3>Últimas Matrículas</h3>
        </div>
        <div class="card-body">
            @if($ultimasMatriculas->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <th style="text-align: left; padding: 0.75rem;">Estudiante</th>
                                <th style="text-align: left; padding: 0.75rem;">Ciclo</th>
                                <th style="text-align: left; padding: 0.75rem;">Monto</th>
                                <th style="text-align: left; padding: 0.75rem;">Estado</th>
                                <th style="text-align: left; padding: 0.75rem;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimasMatriculas as $matricula)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 0.75rem;">{{ $matricula->estudiante->nombre ?? 'N/A' }}</td>
                                <td style="padding: 0.75rem;">{{ $matricula->ciclo->nombre_area ?? 'N/A' }}</td>
                                <td style="padding: 0.75rem;">S/. {{ number_format($matricula->monto, 2) }}</td>
                                <td style="padding: 0.75rem;">
                                    <span style="
                                        padding: 0.25rem 0.75rem; 
                                        border-radius: 9999px; 
                                        font-size: 0.875rem;
                                        background-color: {{ $matricula->estado_pago === 'pagado' ? 'var(--success-color)' : 'var(--warning-color)' }};
                                        color: white;
                                    ">
                                        {{ ucfirst($matricula->estado_pago) }}
                                    </span>
                                </td>
                                <td style="padding: 0.75rem;">{{ $matricula->fecha->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay matrículas registradas</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Acciones Rápidas</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">
                    👥 Gestionar Usuarios
                </a>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-success">
                    🎓 Ver Estudiantes
                </a>
                <a href="{{ route('admin.cursos.index') }}" class="btn btn-warning">
                    📚 Administrar Cursos
                </a>
                <a href="{{ route('admin.matriculas.index') }}" class="btn btn-accent">
                    📋 Revisar Matrículas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection