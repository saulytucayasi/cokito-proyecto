@extends('layouts.app')

@section('title', 'Dashboard Estudiante - COKITO+ Academia')
@section('header', 'Mi Área de Estudiante')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $cursosMatriculados }}</div>
        <div class="stat-label">Cursos Matriculados</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ number_format($progresoPromedio, 1) }}%</div>
        <div class="stat-label">Progreso Promedio</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $materialesDisponibles }}</div>
        <div class="stat-label">Materiales Disponibles</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $misCursos->where('estado', 'activo')->count() }}</div>
        <div class="stat-label">Cursos Activos</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div class="card">
        <div class="card-header">
            <h3>Mis Cursos</h3>
        </div>
        <div class="card-body">
            @if($misCursos->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($misCursos as $cursoEstudiante)
                    <div style="
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    ">
                        <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <h4 style="margin-bottom: 0.5rem; color: var(--primary-blue);">
                                    {{ $cursoEstudiante->curso->nombre ?? 'Curso sin nombre' }}
                                </h4>
                                <p style="color: #6b7280; font-size: 0.875rem;">
                                    Área: {{ $cursoEstudiante->curso->ciclo->nombre_area ?? 'N/A' }}
                                </p>
                            </div>
                            <span style="
                                padding: 0.25rem 0.75rem; 
                                border-radius: 9999px; 
                                font-size: 0.75rem;
                                background-color: {{ $cursoEstudiante->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                                color: white;
                            ">
                                {{ ucfirst($cursoEstudiante->estado) }}
                            </span>
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #374151;">Progreso</span>
                                <span style="font-size: 0.875rem; font-weight: 600; color: var(--primary-blue);">
                                    {{ number_format($cursoEstudiante->progreso, 1) }}%
                                </span>
                            </div>
                            <div style="
                                width: 100%; 
                                height: 8px; 
                                background-color: #e5e7eb; 
                                border-radius: 9999px; 
                                overflow: hidden;
                            ">
                                <div style="
                                    height: 100%; 
                                    background: linear-gradient(90deg, var(--primary-blue) 0%, var(--accent-color) 100%);
                                    width: {{ $cursoEstudiante->progreso }}%;
                                    transition: width 0.3s ease;
                                "></div>
                            </div>
                        </div>
                        
                        @if($cursoEstudiante->calificacion_final)
                        <div style="margin-bottom: 1rem;">
                            <span style="font-size: 0.875rem; color: #374151;">Calificación Final: </span>
                            <span style="
                                font-weight: 600; 
                                color: {{ $cursoEstudiante->calificacion_final >= 14 ? 'var(--success-color)' : 'var(--danger-color)' }};
                            ">
                                {{ $cursoEstudiante->calificacion_final }}/20
                            </span>
                        </div>
                        @endif
                        
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('estudiante.cursos.index') }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                Ver Detalles
                            </a>
                            <a href="{{ route('estudiante.materiales.index') }}" class="btn btn-accent" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                Materiales
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                    <p style="color: #6b7280; margin-bottom: 1rem;">No tienes cursos matriculados aún</p>
                    <a href="#" class="btn btn-primary">Explorar Cursos Disponibles</a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Acciones Rápidas</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="{{ route('estudiante.cursos.index') }}" class="btn btn-primary">
                    📚 Ver Mis Cursos
                </a>
                <a href="{{ route('estudiante.materiales.index') }}" class="btn btn-success">
                    📁 Descargar Materiales
                </a>
                <a href="#" class="btn btn-accent">
                    📊 Ver Calificaciones
                </a>
                <a href="#" class="btn" style="background-color: #8b5cf6; color: white;">
                    📝 Subir Tareas
                </a>
                <a href="#" class="btn" style="background-color: #06b6d4; color: white;">
                    👤 Actualizar Perfil
                </a>
            </div>
        </div>
    </div>
</div>

@if($misCursos->count() > 0)
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h3>Progreso General</h3>
    </div>
    <div class="card-body">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="display: inline-block; position: relative;">
                <div style="
                    width: 120px; 
                    height: 120px; 
                    border-radius: 50%; 
                    background: conic-gradient(var(--primary-blue) {{ $progresoPromedio * 3.6 }}deg, #e5e7eb 0deg);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: relative;
                ">
                    <div style="
                        width: 80px; 
                        height: 80px; 
                        background: white; 
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.5rem;
                        font-weight: 700;
                        color: var(--primary-blue);
                    ">
                        {{ number_format($progresoPromedio, 0) }}%
                    </div>
                </div>
            </div>
            <p style="margin-top: 1rem; color: #6b7280;">Progreso promedio en todos tus cursos</p>
        </div>
    </div>
</div>
@endif
@endsection