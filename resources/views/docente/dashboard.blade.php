@extends('layouts.app')

@section('title', 'Dashboard Docente - COKITO+ Academia')
@section('header', 'Dashboard Docente')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $misCursos }}</div>
        <div class="stat-label">Mis Cursos Asignados</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $misEstudiantes }}</div>
        <div class="stat-label">Estudiantes en mis Cursos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $materialesSubidos }}</div>
        <div class="stat-label">Materiales Subidos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $videosSubidos }}</div>
        <div class="stat-label">Videos Subidos</div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header">
            <h3>Mis Cursos Recientes</h3>
        </div>
        <div class="card-body">
            @if($cursosRecientes->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($cursosRecientes as $curso)
                    <div style="
                        padding: 1rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: #f9fafb;
                    ">
                        <h4 style="margin-bottom: 0.5rem; color: var(--primary-blue);">{{ $curso->nombre }}</h4>
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                            📚 Ciclo: {{ $curso->ciclo->nombre_area ?? 'N/A' }}
                        </p>
                        <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                            <span>⏱️ {{ $curso->duracion_horas ?? 'N/A' }} horas</span>
                            <span>📅 {{ $curso->sesiones->count() }} sesiones</span>
                            <span>📁 {{ $curso->materiales->count() }} materiales</span>
                            <span>🎥 {{ $curso->videos->count() }} videos</span>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <span style="
                                padding: 0.25rem 0.75rem; 
                                border-radius: 9999px; 
                                font-size: 0.75rem;
                                background-color: var(--success-color);
                                color: white;
                            ">
                                {{ ucfirst($curso->modalidad ?? 'N/A') }}
                            </span>
                            <a href="{{ route('docente.cursos.show', $curso->id) }}" class="btn btn-primary" style="font-size: 0.75rem; padding: 0.25rem 0.75rem;">
                                Ver Curso
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #6b7280; padding: 2rem;">No tienes cursos asignados</p>
            @endif
        </div>
    </div>
</div>
@endsection