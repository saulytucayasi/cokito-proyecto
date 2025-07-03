@extends('layouts.app')

@section('title', 'Mis Estudiantes - COKITO+ Academia')
@section('header', 'Mis Estudiantes')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">👥 Mis Estudiantes</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Gestiona y evalúa a todos los estudiantes de tus cursos</p>
    </div>
</div>

<!-- Filtro por áreas -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body" style="padding: 1rem 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span style="font-weight: 600; color: var(--dark-color);">Filtrar por Área:</span>
            
            <select id="filtro-area" style="
                padding: 0.5rem 1rem; 
                border: 1px solid #e5e7eb; 
                border-radius: var(--border-radius);
                background: white;
                min-width: 200px;
                font-size: 0.9rem;
            " onchange="filtrarEstudiantesPorArea()">
                <option value="">👥 Todas las Áreas</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">🎯 {{ $area->nombre_area ?? 'Área sin nombre' }}</option>
                @endforeach
            </select>
            
            <span id="contador-estudiantes" style="color: #6b7280; font-size: 0.875rem;">
                Mostrando {{ $estudiantesUnicos->count() }} estudiante(s)
            </span>
        </div>
    </div>
</div>

<!-- Estadísticas de estudiantes -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesUnicos->count() }}</div>
        <div class="stat-label">Total Estudiantes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesUnicos->flatMap(function($e) { return $e->mis_cursos; })->where('estado', 'activo')->count() }}</div>
        <div class="stat-label">Matrículas Activas</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesUnicos->flatMap(function($e) { return $e->mis_cursos; })->count() }}</div>
        <div class="stat-label">Total Matrículas</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesUnicos->flatMap(function($e) { return $e->mis_cursos; })->whereNotNull('calificacion_final')->count() }}</div>
        <div class="stat-label">Con Calificación</div>
    </div>
</div>

<!-- Filtros -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body" style="padding: 1rem 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span style="font-weight: 600; color: var(--dark-color);">Filtros:</span>
            
            <select id="filtro-curso" style="
                padding: 0.5rem 1rem; 
                border: 1px solid #e5e7eb; 
                border-radius: var(--border-radius);
                background: white;
                min-width: 200px;
            " onchange="filtrarEstudiantes()">
                <option value="">Todos los cursos</option>
                @foreach($estudiantesUnicos->flatMap(function($e) { return $e->mis_cursos; })->pluck('curso.nombre')->unique() as $nombreCurso)
                    <option value="{{ $nombreCurso }}">{{ $nombreCurso }}</option>
                @endforeach
            </select>
            
            <select id="filtro-estado" style="
                padding: 0.5rem 1rem; 
                border: 1px solid #e5e7eb; 
                border-radius: var(--border-radius);
                background: white;
            " onchange="filtrarEstudiantes()">
                <option value="">Todos los estados</option>
                <option value="activo">Activos</option>
                <option value="inactivo">Inactivos</option>
            </select>
            
            <input type="text" 
                   id="buscar-estudiante" 
                   placeholder="Buscar por nombre..." 
                   style="
                       padding: 0.5rem 1rem; 
                       border: 1px solid #e5e7eb; 
                       border-radius: var(--border-radius);
                       min-width: 250px;
                   "
                   onkeyup="filtrarEstudiantes()">
        </div>
    </div>
</div>

<!-- Grid de estudiantes -->
@if($estudiantesUnicos->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem;" id="estudiantes-grid">
        @foreach($estudiantesUnicos as $estudiante)
        @php
            $areasEstudiante = $estudiante->mis_cursos->pluck('curso.ciclo.id')->filter()->unique()->toArray();
            $cursosNombres = $estudiante->mis_cursos->pluck('curso.nombre')->toArray();
        @endphp
        
        <div class="card estudiante-item" 
             data-areas="{{ implode(',', $areasEstudiante) }}"
             data-cursos="{{ implode(',', $cursosNombres) }}"
             data-nombre="{{ $estudiante->nombre ?? '' }} {{ $estudiante->apellido ?? '' }}"
             data-total-cursos="{{ $estudiante->total_cursos }}"
             data-progreso-promedio="{{ number_format($estudiante->progreso_promedio, 1) }}"
             data-calificacion-promedio="{{ $estudiante->calificacion_promedio ? number_format($estudiante->calificacion_promedio, 1) : '--' }}"
             style="overflow: hidden; transition: all 0.3s ease;">
            
            <!-- Header del estudiante -->
            <div style="
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
                color: white;
                padding: 1.5rem;
                position: relative;
            ">
                <div style="position: absolute; top: 1rem; right: 1rem;">
                    <span style="
                        background: var(--success-color);
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 9999px;
                        font-size: 0.75rem;
                        font-weight: 600;
                    ">
                        📚 {{ $estudiante->total_cursos }} curso(s)
                    </span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="
                        width: 60px; 
                        height: 60px; 
                        border-radius: 50%;
                        background: rgba(255,255,255,0.2);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-weight: 700;
                        font-size: 1.5rem;
                    ">
                        {{ strtoupper(substr($estudiante->nombre ?? 'N', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex: 1; padding-right: 4rem;">
                        <h3 style="margin: 0 0 0.25rem 0; font-size: 1.25rem;">
                            {{ $estudiante->nombre ?? 'Sin nombre' }} {{ $estudiante->apellido ?? '' }}
                        </h3>
                        <p style="margin: 0; opacity: 0.9; font-size: 0.875rem;">
                            Cursos: {{ implode(', ', array_slice($cursosNombres, 0, 2)) }}{{ count($cursosNombres) > 2 ? '...' : '' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Contenido del estudiante -->
            <div class="card-body" style="padding: 1.5rem;">
                <!-- Información personal -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.875rem;">
                        <div>
                            <span style="color: #6b7280;">DNI:</span><br>
                            <span style="font-weight: 600; color: var(--dark-color);">
                                {{ $estudiante->dni ?? 'No registrado' }}
                            </span>
                        </div>
                        <div>
                            <span style="color: #6b7280;">Email:</span><br>
                            <span style="font-weight: 600; color: var(--dark-color);">
                                {{ Str::limit($estudiante->correo ?? 'No registrado', 20) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Progreso promedio del estudiante -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600; color: var(--dark-color);">Progreso Promedio</span>
                        <span style="font-weight: 700; color: var(--primary-blue);">{{ number_format($estudiante->progreso_promedio, 1) }}%</span>
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
                            background: linear-gradient(90deg, var(--primary-blue) 0%, var(--success-color) 100%);
                            width: {{ $estudiante->progreso_promedio }}%;
                            transition: width 0.5s ease;
                            border-radius: 9999px;
                        "></div>
                    </div>
                </div>
                
                <!-- Calificación y estadísticas -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: #f0f9ff; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue);">
                            @if($estudiante->calificacion_promedio)
                                {{ number_format($estudiante->calificacion_promedio, 1) }}
                            @else
                                --
                            @endif
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Nota Promedio
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding: 1rem; background: #f0fdf4; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success-color);">
                            {{ $estudiante->total_cursos }}
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Cursos Inscritos
                        </div>
                    </div>
                </div>
                
                <!-- Resumen de cursos -->
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                    <div style="font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem;">
                        <strong>📚 Cursos matriculados:</strong>
                    </div>
                    @foreach($estudiante->mis_cursos->take(3) as $cursoItem)
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">
                        • {{ $cursoItem->curso->nombre ?? 'Sin nombre' }} 
                        @if($cursoItem->calificacion_final)
                            (Nota: {{ $cursoItem->calificacion_final }})
                        @endif
                    </div>
                    @endforeach
                    @if($estudiante->mis_cursos->count() > 3)
                    <div style="font-size: 0.75rem; color: #6b7280; font-style: italic;">
                        ... y {{ $estudiante->mis_cursos->count() - 3 }} curso(s) más
                    </div>
                    @endif
                </div>
                
                <!-- Acción para ver detalle -->
                <div style="text-align: center;">
                    <button type="button" 
                            class="btn btn-primary"
                            style="padding: 0.75rem 1.5rem; font-size: 0.875rem;"
                            onclick="verDetalleEstudiante({{ $estudiante->id }})"
                            title="Ver detalle completo del estudiante">
                        👁️ Ver Detalle
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    @if(method_exists($estudiantesUnicos, 'hasPages') && $estudiantesUnicos->hasPages())
    <div style="margin-top: 3rem; text-align: center;">
        {{ $estudiantesUnicos->links() }}
    </div>
    @endif
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">👥</div>
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">No tienes estudiantes asignados</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Los estudiantes aparecerán aquí cuando se matriculen en tus cursos.
            </p>
            <a href="{{ route('docente.cursos') }}" class="btn btn-primary">
                📚 Ver Mis Cursos
            </a>
        </div>
    </div>
@endif


<script>
function filtrarEstudiantes() {
    const filtroCurso = document.getElementById('filtro-curso').value.toLowerCase();
    const filtroEstado = document.getElementById('filtro-estado').value.toLowerCase();
    const buscarTexto = document.getElementById('buscar-estudiante').value.toLowerCase();
    const estudiantes = document.querySelectorAll('.estudiante-item');
    
    estudiantes.forEach(estudiante => {
        const cursos = estudiante.getAttribute('data-cursos').toLowerCase();
        const nombre = estudiante.getAttribute('data-nombre').toLowerCase();
        
        const cumpleCurso = filtroCurso === '' || cursos.includes(filtroCurso);
        const cumpleBusqueda = buscarTexto === '' || nombre.includes(buscarTexto);
        
        if (cumpleCurso && cumpleBusqueda) {
            estudiante.style.display = 'block';
        } else {
            estudiante.style.display = 'none';
        }
    });
}

function filtrarEstudiantesPorArea() {
    const areaSeleccionada = document.getElementById('filtro-area').value;
    const estudiantes = document.querySelectorAll('.estudiante-item');
    let estudiantesVisibles = 0;
    
    estudiantes.forEach(estudiante => {
        const areasDelEstudiante = estudiante.getAttribute('data-areas').split(',');
        
        if (areaSeleccionada === '' || areasDelEstudiante.includes(areaSeleccionada)) {
            estudiante.style.display = 'block';
            estudiantesVisibles++;
        } else {
            estudiante.style.display = 'none';
        }
    });
    
    // Actualizar contador
    const contador = document.getElementById('contador-estudiantes');
    if (areaSeleccionada === '') {
        contador.textContent = `Mostrando ${estudiantesVisibles} estudiante(s) - Todas las áreas`;
    } else {
        const nombreArea = document.querySelector(`option[value="${areaSeleccionada}"]`).textContent.replace('🎯 ', '');
        contador.textContent = `Mostrando ${estudiantesVisibles} estudiante(s) en ${nombreArea}`;
    }
}

function verDetalleEstudiante(estudianteId) {
    // Redirigir a la vista de detalle del estudiante
    window.location.href = `/docente/estudiantes/${estudianteId}`;
}


// Efectos hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.estudiante-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'var(--box-shadow)';
        });
    });
});
</script>

<style>
@media (max-width: 768px) {
    #estudiantes-grid {
        grid-template-columns: 1fr;
    }
    
    .estudiante-item .card-body > div:nth-child(1) > div {
        grid-template-columns: 1fr;
    }
    
    .estudiante-item .card-body > div:nth-child(3) {
        grid-template-columns: 1fr;
    }
    
    .estudiante-item .card-body > div:last-child {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection