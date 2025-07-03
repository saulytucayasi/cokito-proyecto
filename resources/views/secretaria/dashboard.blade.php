@extends('layouts.app')

@section('title', 'Dashboard Secretaría - COKITO+ Academia')
@section('header', 'Dashboard Secretaría')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $matriculasPendientes }}</div>
        <div class="stat-label">Matrículas Pendientes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $matriculasHoy }}</div>
        <div class="stat-label">Matrículas Hoy</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">S/. {{ number_format($totalRecaudado, 2) }}</div>
        <div class="stat-label">Total Recaudado</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $ultimasMatriculas->count() }}</div>
        <div class="stat-label">Actividad Reciente</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div class="card">
        <div class="card-header">
            <h3>Últimas Matrículas Procesadas</h3>
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
                                        background-color: {{ $matricula->estado_pago === 'pagado' ? 'var(--success-color)' : ($matricula->estado_pago === 'pendiente' ? 'var(--warning-color)' : 'var(--danger-color)') }};
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
            <h3>Tareas Pendientes</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @if($matriculasPendientes > 0)
                    <div style="
                        padding: 1rem; 
                        background-color: #fef3c7; 
                        border-left: 4px solid var(--warning-color);
                        border-radius: var(--border-radius);
                    ">
                        <h4 style="color: #92400e; margin-bottom: 0.5rem;">⚠️ Atención</h4>
                        <p style="color: #92400e; font-size: 0.875rem;">
                            Tienes {{ $matriculasPendientes }} matrículas pendientes de procesar
                        </p>
                    </div>
                @endif
                
                <a href="{{ route('secretaria.matriculas.index') }}" class="btn btn-primary">
                    📋 Procesar Matrículas
                </a>
                <a href="{{ route('secretaria.estudiantes.index') }}" class="btn btn-success">
                    🎓 Gestionar Estudiantes
                </a>
                <a href="{{ route('secretaria.matriculas.create') }}" class="btn btn-warning">
                    ➕ Nueva Matrícula
                </a>
                <a href="#" class="btn btn-accent">
                    📧 Enviar Notificaciones
                </a>
                <a href="#" class="btn" style="background-color: #8b5cf6; color: white;">
                    📊 Reportes de Pagos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection