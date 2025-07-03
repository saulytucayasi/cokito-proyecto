@extends('layouts.app')

@section('title', 'Mis Cursos - COKITO+ Academia')
@section('header', 'Mis Cursos')

@section('content')
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $cursosInscritos->count() }}</div>
        <div class="stat-label">Cursos Matriculados</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $cursosInscritos->where('estado', 'activo')->count() }}</div>
        <div class="stat-label">Cursos Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ number_format($cursosInscritos->avg('progreso') ?? 0, 1) }}%</div>
        <div class="stat-label">Progreso Promedio</div>
    </div>
</div>

@if($cursosInscritos->count() > 0)
    <div style="display: grid; gap: 1.5rem;">
        @foreach($cursosInscritos->groupBy('curso.ciclo.nombre_area') as $cicloNombre => $cursosPorCiclo)
        <div class="card">
            <div class="card-header">
                <h3>📚 {{ $cicloNombre }}</h3>
                <span style="font-size: 0.875rem; color: #6b7280;">
                    {{ $cursosPorCiclo->count() }} curso{{ $cursosPorCiclo->count() != 1 ? 's' : '' }}
                </span>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    @foreach($cursosPorCiclo as $cursoEstudiante)
                    <div style="
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    ">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <h4 style="margin-bottom: 0.5rem; color: var(--primary-blue);">
                                    {{ $cursoEstudiante->curso->nombre }}
                                </h4>
                                <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">
                                    <span>👨‍🏫 {{ $cursoEstudiante->curso->docente->nombre ?? 'Sin docente asignado' }}</span>
                                    <span>⏱️ {{ $cursoEstudiante->curso->duracion_horas ?? 'N/A' }} horas</span>
                                    <span>📅 {{ $cursoEstudiante->curso->sesiones->count() }} sesiones</span>
                                </div>
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                    {{ $cursoEstudiante->curso->descripcion ?? 'Sin descripción disponible' }}
                                </p>
                            </div>
                            <span style="
                                padding: 0.25rem 0.75rem; 
                                border-radius: 9999px; 
                                font-size: 0.75rem;
                                background-color: {{ $cursoEstudiante->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                                color: white;
                                white-space: nowrap;
                            ">
                                {{ ucfirst($cursoEstudiante->estado) }}
                            </span>
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #374151;">Progreso por Sesiones</span>
                                <span style="font-size: 0.875rem; font-weight: 600; color: var(--primary-blue);">
                                    {{ number_format($cursoEstudiante->progreso ?? 0, 1) }}%
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
                                    width: {{ $cursoEstudiante->progreso ?? 0 }}%;
                                    transition: width 0.3s ease;
                                "></div>
                            </div>
                        </div>
                        
                        @if($cursoEstudiante->calificacion_final)
                        <div style="margin-bottom: 1rem;">
                            <span style="font-size: 0.875rem; color: #374151;">Calificación Final: </span>
                            <span style="
                                font-weight: 600; 
                                padding: 0.25rem 0.5rem;
                                border-radius: 4px;
                                color: white;
                                background-color: {{ $cursoEstudiante->calificacion_final >= 14 ? 'var(--success-color)' : 'var(--danger-color)' }};
                            ">
                                {{ $cursoEstudiante->calificacion_final }}/20
                            </span>
                        </div>
                        @endif
                        
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <a href="{{ route('estudiante.cursos.show', $cursoEstudiante->curso->id) }}" class="course-btn course-btn-primary">
                                📖 Ver Curso
                            </a>
                            @if($cursoEstudiante->curso->materiales->count() > 0)
                            <a href="{{ route('estudiante.materiales.index') }}" class="course-btn course-btn-success">
                                📁 Materiales ({{ $cursoEstudiante->curso->materiales->count() }})
                            </a>
                            @endif
                            @if($cursoEstudiante->curso->videos->count() > 0)
                            <span class="course-btn course-btn-accent course-btn-disabled">
                                🎥 {{ $cursoEstudiante->curso->videos->count() }} video{{ $cursoEstudiante->curso->videos->count() != 1 ? 's' : '' }}
                            </span>
                            @endif
                            @if($cursoEstudiante->curso->sesiones->count() > 0)
                            <a href="#" class="course-btn course-btn-warning">
                                📅 Sesiones ({{ $cursoEstudiante->curso->sesiones->count() }})
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
            <h3 style="margin-bottom: 1rem; color: var(--primary-blue);">No tienes cursos matriculados</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Ponte en contacto con la administración para matricularte en los cursos disponibles.
            </p>
            <a href="{{ route('estudiante.dashboard') }}" class="btn btn-primary">
                🏠 Volver al Dashboard
            </a>
        </div>
    </div>
@endif
@endsection
