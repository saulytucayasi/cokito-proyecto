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
    </div>
</div>

<!-- Navegación de Áreas -->
<div class="card" id="seccion-areas" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h3>🎯 Áreas Académicas</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            @foreach($areas as $area)
            @php
                $cursosDelArea = $cursosAsignados->where('ciclo.id', $area->id);
                $estudiantesDelArea = $cursosDelArea->sum(function($curso) { return $curso->cursoEstudiantes->count(); });
                $materialesDelArea = $cursosDelArea->sum(function($curso) { return $curso->materiales->count(); });
            @endphp
            
            <div class="card area-card" 
                 style="cursor: pointer; transition: all 0.3s ease; border: 2px solid transparent;"
                 onclick="verCursosDelArea('{{ $area->id }}', '{{ $area->nombre_area ?? 'Área sin nombre' }}')"
                 onmouseenter="this.style.borderColor='var(--primary-blue)'; this.style.transform='translateY(-2px)'"
                 onmouseleave="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                
                <div style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <h4 style="margin: 0 0 0.5rem 0; color: var(--primary-blue); font-size: 1.25rem;">
                                🎯 {{ $area->nombre_area ?? 'Área sin nombre' }}
                            </h4>
                            @if($area->descripcion)
                            <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">
                                {{ Str::limit($area->descripcion, 100) }}
                            </p>
                            @endif
                        </div>
                        <span style="
                            background: var(--accent-color);
                            color: white;
                            padding: 0.25rem 0.75rem;
                            border-radius: 9999px;
                            font-size: 0.75rem;
                            font-weight: 600;
                        ">
                            {{ $cursosDelArea->count() }} curso(s)
                        </span>
                    </div>
                    
                    <!-- Estadísticas del área -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem; margin-bottom: 1rem;">
                        <div style="text-align: center; padding: 0.75rem; background: #f0f9ff; border-radius: var(--border-radius);">
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary-blue);">
                                {{ $cursosDelArea->count() }}
                            </div>
                            <div style="font-size: 0.7rem; color: #6b7280; font-weight: 600;">
                                Cursos
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding: 0.75rem; background: #f0fdf4; border-radius: var(--border-radius);">
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--success-color);">
                                {{ $estudiantesDelArea }}
                            </div>
                            <div style="font-size: 0.7rem; color: #6b7280; font-weight: 600;">
                                Estudiantes
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding: 0.75rem; background: #fef3c7; border-radius: var(--border-radius);">
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--accent-color);">
                                {{ $materialesDelArea }}
                            </div>
                            <div style="font-size: 0.7rem; color: #6b7280; font-weight: 600;">
                                Materiales
                            </div>
                        </div>
                    </div>
                    
                    <div style="text-align: center;">
                        <span style="color: var(--primary-blue); font-weight: 600; font-size: 0.875rem;">
                            👆 Clic para ver cursos
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
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

<!-- Sección de cursos por área -->
<div id="seccion-cursos-area" style="display: none; margin-bottom: 2rem;">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 id="titulo-area-seleccionada">📚 Cursos del Área</h3>
                <p style="margin: 0.5rem 0 0 0; color: #6b7280;" id="descripcion-area-seleccionada">Cursos disponibles en esta área</p>
            </div>
            <button type="button" class="btn" style="background: #6b7280; color: white;" onclick="volverAreas()">
                ← Volver a Áreas
            </button>
        </div>
        <div class="card-body">
            <div id="grid-cursos-area" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem;">
                <!-- Los cursos se insertarán aquí dinámicamente -->
            </div>
        </div>
    </div>
</div>

@if($cursosAsignados->count() > 0)
    <!-- Grid de cursos (oculto inicialmente) -->
    <div id="todos-los-cursos" style="display: none; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem;">
        @foreach($cursosAsignados as $curso)
        @php
            $ciclo = $curso->ciclo ?? null;
            $estudiantesCount = $curso->cursoEstudiantes->count();
            $materialesCount = $curso->materiales->count();
            $videosCount = $curso->videos->count();
            $promedioProgreso = $curso->cursoEstudiantes->avg('progreso') ?? 0;
        @endphp
        
        <div class="card curso-item" 
             data-area-id="{{ $curso->ciclo->id ?? '' }}"
             data-area-nombre="{{ $curso->ciclo->nombre_area ?? '' }}"
             data-estado="{{ $curso->estado }}"
             data-estudiantes="{{ $estudiantesCount }}"
             data-materiales="{{ $materialesCount }}"
             data-videos="{{ $videosCount }}"
             style="overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
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
                
                <!-- Acción principal -->
                <div style="text-align: center;">
                    <a href="{{ route('docente.cursos.show', $curso->id) }}" 
                       class="btn btn-primary" 
                       style="padding: 0.75rem 2rem; font-size: 0.875rem; text-decoration: none;">
                        📖 Ver Curso
                    </a>
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

function verCursosDelArea(areaId, nombreArea) {
    // Ocultar la sección de áreas
    document.getElementById('seccion-areas').style.display = 'none';
    
    // Mostrar la sección de cursos del área
    document.getElementById('seccion-cursos-area').style.display = 'block';
    
    // Actualizar el título
    document.getElementById('titulo-area-seleccionada').textContent = `📚 Cursos de ${nombreArea}`;
    document.getElementById('descripcion-area-seleccionada').textContent = `Cursos disponibles en el área de ${nombreArea}`;
    
    // Filtrar y mostrar solo los cursos del área seleccionada
    const todosLosCursos = document.querySelectorAll('.curso-item');
    const gridCursosArea = document.getElementById('grid-cursos-area');
    
    // Limpiar el grid del área
    gridCursosArea.innerHTML = '';
    
    let cursosEncontrados = 0;
    todosLosCursos.forEach(curso => {
        const areaDelCurso = curso.getAttribute('data-area-id');
        
        if (areaDelCurso === areaId) {
            // Clonar el curso y agregarlo al grid del área
            const cursoClonado = curso.cloneNode(true);
            gridCursosArea.appendChild(cursoClonado);
            cursosEncontrados++;
        }
    });
    
    // Si no hay cursos en el área
    if (cursosEncontrados === 0) {
        gridCursosArea.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #6b7280;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3 style="margin-bottom: 1rem;">No hay cursos en esta área</h3>
                <p>No tienes cursos asignados en el área de ${nombreArea}</p>
            </div>
        `;
    }
    
    // Actualizar estadísticas para el área
    actualizarEstadisticasArea(areaId);
}

function volverAreas() {
    // Mostrar la sección de áreas
    document.getElementById('seccion-areas').style.display = 'block';
    
    // Ocultar la sección de cursos del área
    document.getElementById('seccion-cursos-area').style.display = 'none';
    
    // Restaurar estadísticas generales
    restaurarEstadisticasGenerales();
}

function actualizarEstadisticasArea(areaId) {
    const cursos = document.querySelectorAll('.curso-item');
    let cursosDelArea = 0;
    let cursosActivos = 0;
    let totalEstudiantes = 0;
    let totalMateriales = 0;
    
    cursos.forEach(curso => {
        const areaDelCurso = curso.getAttribute('data-area-id');
        
        if (areaDelCurso === areaId) {
            cursosDelArea++;
            
            if (curso.getAttribute('data-estado') === 'activo') {
                cursosActivos++;
            }
            
            totalEstudiantes += parseInt(curso.getAttribute('data-estudiantes')) || 0;
            totalMateriales += parseInt(curso.getAttribute('data-materiales')) || 0;
        }
    });
    
    // Actualizar las tarjetas de estadísticas
    const statsCards = document.querySelectorAll('.stat-card .stat-value');
    if (statsCards.length >= 4) {
        statsCards[0].textContent = cursosDelArea;
        statsCards[1].textContent = cursosActivos;
        statsCards[2].textContent = totalEstudiantes;
        statsCards[3].textContent = totalMateriales;
    }
}

function restaurarEstadisticasGenerales() {
    // Restaurar los valores originales de las estadísticas
    const statsCards = document.querySelectorAll('.stat-card .stat-value');
    if (statsCards.length >= 4) {
        statsCards[0].textContent = '{{ $cursosAsignados->count() }}';
        statsCards[1].textContent = '{{ $cursosAsignados->where("estado", "activo")->count() }}';
        statsCards[2].textContent = '{{ $cursosAsignados->sum(function($curso) { return $curso->cursoEstudiantes->count(); }) }}';
        statsCards[3].textContent = '{{ $cursosAsignados->sum(function($curso) { return $curso->materiales->count(); }) }}';
    }
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
    /* Responsivo para áreas */
    #seccion-areas .card-body > div {
        grid-template-columns: 1fr !important;
    }
    
    /* Responsivo para cursos */
    .card .card-body > div:nth-child(3) {
        grid-template-columns: 1fr;
    }
    
    .card .card-body > div:nth-child(5),
    .card .card-body > div:nth-child(6) {
        grid-template-columns: 1fr;
    }
    
    /* Grid de cursos en área */
    #grid-cursos-area {
        grid-template-columns: 1fr !important;
    }
}

/* Efectos hover para las áreas */
.area-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
@endsection