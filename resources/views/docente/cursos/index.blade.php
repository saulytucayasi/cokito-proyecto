@extends('layouts.app')

@section('title', 'Mis Cursos - COKITO+ Academia')
@section('header', 'Mis Cursos')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0; color: var(--dark-color);">📚 Mis Cursos Asignados</h2>
            <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Administra tus cursos, estudiantes y contenido educativo</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button class="btn btn-success" onclick="calificarEstudiantes()">
                📊 Calificar
            </button>
            <button class="btn btn-primary" onclick="exportarReporte()">
                📋 Exportar
            </button>
        </div>
    </div>
</div>

<!-- Estadísticas de cursos del docente -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->count() }}</div>
        <div class="stat-label">Cursos Asignados</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->where('estado', 'activo')->count() }}</div>
        <div class="stat-label">Cursos Activos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->cursoEstudiantes->count(); }) }}</div>
        <div class="stat-label">Total Estudiantes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->materiales->count(); }) }}</div>
        <div class="stat-label">Materiales Subidos</div>
    </div>
</div>

@if($cursosAsignados->count() > 0)
    <!-- Grid de cursos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem;">
        @foreach($cursosAsignados as $curso)
        @php
            $ciclo = $curso->ciclo ?? null;
            $estudiantesCount = $curso->cursoEstudiantes->count();
            $materialesCount = $curso->materiales->count();
            $videosCount = $curso->videos->count();
            $promedioProgreso = $curso->cursoEstudiantes->avg('progreso') ?? 0;
        @endphp
        
        <div class="card" style="overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
            <!-- Header del curso -->
            <div style="
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
                color: white;
                padding: 1.5rem;
                position: relative;
            ">
                <div style="position: absolute; top: 1rem; right: 1rem;">
                    <span style="
                        background: {{ $curso->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 9999px;
                        font-size: 0.75rem;
                        font-weight: 600;
                        text-transform: uppercase;
                    ">
                        {{ $curso->estado === 'activo' ? '✅' : '⏸️' }} {{ ucfirst($curso->estado) }}
                    </span>
                </div>
                
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; padding-right: 6rem;">{{ $curso->nombre }}</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 0.875rem;">
                    {{ $ciclo->nombre_area ?? 'Sin área definida' }}
                </p>
                <p style="margin: 0.5rem 0 0 0; opacity: 0.8; font-size: 0.75rem;">
                    {{ ucfirst($curso->modalidad ?? 'N/A') }} | {{ $curso->duracion_horas ?? $curso->duracion ?? 'N/A' }} horas
                </p>
            </div>
            
            <!-- Contenido del curso -->
            <div class="card-body" style="padding: 1.5rem;">
                <!-- Descripción -->
                <p style="color: #374151; margin-bottom: 1.5rem; line-height: 1.6; font-weight: 500;">
                    {{ Str::limit($curso->descripcion, 120) }}
                </p>
                
                <!-- Progreso general del curso -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600; color: var(--text-color);">Progreso Promedio</span>
                        <span style="font-weight: 700; color: var(--primary-blue);">{{ number_format($promedioProgreso, 1) }}%</span>
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
                            width: {{ $promedioProgreso }}%;
                            transition: width 0.5s ease;
                            border-radius: 9999px;
                        "></div>
                    </div>
                </div>
                
                <!-- Estadísticas -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: #f0f9ff; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue);">
                            {{ $estudiantesCount }}
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Estudiantes
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding: 1rem; background: #f0fdf4; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success-color);">
                            {{ $materialesCount }}
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Materiales
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding: 1rem; background: #fef3c7; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent-color);">
                            {{ $videosCount }}
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Videos
                        </div>
                    </div>
                </div>
                
                <!-- Fechas del curso -->
                @if($curso->fecha_inicio || $curso->fecha_fin)
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                        <span style="color: #374151;">
                            <strong>Inicio:</strong> {{ $curso->fecha_inicio ? $curso->fecha_inicio->format('d/m/Y') : 'No definida' }}
                        </span>
                        <span style="color: #374151;">
                            <strong>Fin:</strong> {{ $curso->fecha_fin ? $curso->fecha_fin->format('d/m/Y') : 'No definida' }}
                        </span>
                    </div>
                </div>
                @endif
                
                <!-- Acciones de gestión -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                    <a href="{{ route('docente.estudiantes.por-curso', $curso->id) }}" 
                       class="btn btn-primary" 
                       style="text-align: center; padding: 0.75rem; font-size: 0.875rem;">
                        👥 Estudiantes
                    </a>
                    
                    <a href="{{ route('docente.materiales.por-curso', $curso->id) }}" 
                       class="btn" 
                       style="
                           background: var(--success-color); 
                           color: white; 
                           text-align: center; 
                           padding: 0.75rem; 
                           font-size: 0.875rem;
                           text-decoration: none;
                       ">
                        📁 Materiales
                    </a>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <a href="{{ route('docente.videos.por-curso', $curso->id) }}" 
                       class="btn btn-accent" 
                       style="
                           text-align: center; 
                           padding: 0.75rem; 
                           font-size: 0.875rem;
                           text-decoration: none;
                       ">
                        🎥 Videos
                    </a>
                    
                    <button type="button"
                            class="btn btn-warning"
                            style="padding: 0.75rem; font-size: 0.875rem;"
                            onclick="generarReporte({{ $curso->id }})">
                        📊 Reporte
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    @if(method_exists($cursosAsignados, 'hasPages') && $cursosAsignados->hasPages())
    <div style="margin-top: 3rem; text-align: center;">
        {{ $cursosAsignados->links() }}
    </div>
    @endif
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">No tienes cursos asignados</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Contacta con el administrador para que te asigne cursos para gestionar.
            </p>
            <a href="{{ route('docente.dashboard') }}" class="btn btn-primary">
                🏠 Volver al Dashboard
            </a>
        </div>
    </div>
@endif

<!-- Herramientas rápidas -->
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h3>🛠️ Herramientas Rápidas</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <button type="button" 
                    class="btn btn-primary" 
                    style="padding: 1rem; text-align: left;"
                    onclick="subirMaterial()">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📎</div>
                <div style="font-weight: 600;">Subir Material</div>
                <div style="font-size: 0.875rem; opacity: 0.8;">Agrega contenido a tus cursos</div>
            </button>
            
            <button type="button" 
                    class="btn btn-accent" 
                    style="padding: 1rem; text-align: left;"
                    onclick="agregarVideo()">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🎥</div>
                <div style="font-weight: 600;">Agregar Video</div>
                <div style="font-size: 0.875rem; opacity: 0.8;">Añade videos de YouTube</div>
            </button>
            
            <button type="button" 
                    class="btn btn-success" 
                    style="padding: 1rem; text-align: left;"
                    onclick="calificarEstudiantes()">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📋</div>
                <div style="font-weight: 600;">Calificar</div>
                <div style="font-size: 0.875rem; opacity: 0.8;">Evalúa a tus estudiantes</div>
            </button>
            
            <button type="button" 
                    class="btn btn-warning" 
                    style="padding: 1rem; text-align: left;"
                    onclick="verReportes()">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📈</div>
                <div style="font-weight: 600;">Reportes</div>
                <div style="font-size: 0.875rem; opacity: 0.8;">Analiza el progreso</div>
            </button>
        </div>
    </div>
</div>

<script>
function generarReporte(cursoId) {
    alert(`Generar reporte para curso ID: ${cursoId} (a implementar)`);
}

function subirMaterial() {
    alert('Funcionalidad de subir material a implementar');
}

function agregarVideo() {
    alert('Funcionalidad de agregar video a implementar');
}

function calificarEstudiantes() {
    alert('Funcionalidad de calificación a implementar');
}

function verReportes() {
    alert('Funcionalidad de reportes a implementar');
}

// Efectos hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        if (!card.classList.contains('no-hover')) {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--box-shadow)';
            });
        }
    });
});
</script>

<style>
@media (max-width: 768px) {
    .card .card-body > div:nth-child(3) {
        grid-template-columns: 1fr;
    }
    
    .card .card-body > div:nth-child(5),
    .card .card-body > div:nth-child(6) {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection