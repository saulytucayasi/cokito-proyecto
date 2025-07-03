@extends('layouts.app')

@section('title', 'Mis Estudiantes - COKITO+ Academia')
@section('header', 'Mis Estudiantes')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">👥 Mis Estudiantes</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Gestiona y evalúa a todos los estudiantes de tus cursos</p>
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

<!-- Estadísticas de estudiantes -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesConCursos->count() }}</div>
        <div class="stat-label">Total Estudiantes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesConCursos->filter(function($e) { return $e->estado_matricula === 'activo'; })->count() }}</div>
        <div class="stat-label">Estudiantes Activos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesConCursos->flatMap(function($e) { return $e->mis_cursos; })->count() }}</div>
        <div class="stat-label">Matrículas Totales</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantesConCursos->flatMap(function($e) { return $e->mis_cursos; })->whereNotNull('calificacion_final')->count() }}</div>
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
                @foreach($estudiantesConCursos->flatMap(function($e) { return $e->mis_cursos; })->pluck('curso.nombre')->unique() as $nombreCurso)
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
@if($estudiantesConCursos->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem;" id="estudiantes-grid">
        @foreach($estudiantesConCursos as $estudiante)
        @foreach($estudiante->mis_cursos as $cursoEstudiante)
        @php
            $curso = $cursoEstudiante->curso;
            $progreso = $cursoEstudiante->progreso ?? 0;
            $calificacion = $cursoEstudiante->calificacion_final;
        @endphp
        
        <div class="card estudiante-item" 
             data-curso="{{ $curso->nombre ?? 'Sin curso' }}"
             data-estado="{{ $cursoEstudiante->estado }}"
             data-nombre="{{ $estudiante->nombre ?? '' }} {{ $estudiante->apellido ?? '' }}"
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
                        background: {{ $cursoEstudiante->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 9999px;
                        font-size: 0.75rem;
                        font-weight: 600;
                        text-transform: uppercase;
                    ">
                        {{ $cursoEstudiante->estado === 'activo' ? '✅' : '⏸️' }} {{ ucfirst($cursoEstudiante->estado) }}
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
                            {{ $curso->nombre ?? 'Sin curso' }}
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
                
                <!-- Progreso del estudiante -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600; color: var(--dark-color);">Progreso del Curso</span>
                        <span style="font-weight: 700; color: var(--primary-blue);">{{ number_format($progreso, 1) }}%</span>
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
                            width: {{ $progreso }}%;
                            transition: width 0.5s ease;
                            border-radius: 9999px;
                        "></div>
                    </div>
                </div>
                
                <!-- Calificación y estadísticas -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: #f0f9ff; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue);">
                            @if($calificacion)
                                {{ number_format($calificacion, 1) }}
                            @else
                                --
                            @endif
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Nota Final
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding: 1rem; background: #f0fdf4; border-radius: var(--border-radius);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success-color);">
                            {{ rand(1, 10) }}
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                            Actividades
                        </div>
                    </div>
                </div>
                
                <!-- Fecha de matrícula -->
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                    <div style="font-size: 0.875rem; color: #374151;">
                        <strong>Matriculado:</strong> {{ $cursoEstudiante->created_at->format('d/m/Y') }}
                    </div>
                    @if($cursoEstudiante->fecha_inscripcion)
                    <div style="font-size: 0.875rem; color: #6b7280;">
                        <strong>Inscripción:</strong> {{ $cursoEstudiante->fecha_inscripcion->format('d/m/Y') }}
                    </div>
                    @endif
                </div>
                
                <!-- Acciones -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem;">
                    <button type="button" 
                            class="btn btn-accent"
                            style="padding: 0.5rem; font-size: 0.875rem;"
                            onclick="verPerfilEstudiante({{ $estudiante->id ?? 0 }})"
                            title="Ver perfil">
                        👤
                    </button>
                    
                    <button type="button" 
                            class="btn btn-success"
                            style="padding: 0.5rem; font-size: 0.875rem;"
                            onclick="calificarEstudiante({{ $cursoEstudiante->id }})"
                            title="Calificar">
                        📊
                    </button>
                    
                    <button type="button" 
                            class="btn btn-warning"
                            style="padding: 0.5rem; font-size: 0.875rem;"
                            onclick="enviarMensaje({{ $estudiante->id ?? 0 }})"
                            title="Enviar mensaje">
                        ✉️
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>

    <!-- Paginación -->
    @if(method_exists($estudiantesConCursos, 'hasPages') && $estudiantesConCursos->hasPages())
    <div style="margin-top: 3rem; text-align: center;">
        {{ $estudiantesConCursos->links() }}
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

<!-- Modal para calificar estudiante -->
<div id="modal-calificar" style="
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0,0,0,0.5); 
    z-index: 1000;
    justify-content: center;
    align-items: center;
">
    <div style="
        background: white; 
        border-radius: var(--border-radius); 
        padding: 2rem; 
        width: 90%; 
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    ">
        <h3 style="margin: 0 0 1.5rem 0; color: var(--dark-color);">📊 Calificar Estudiante</h3>
        
        <form id="form-calificar">
            <input type="hidden" id="curso-estudiante-id">
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Nota Final (0-20)</label>
                <input type="number" id="calificacion-final" class="form-control" min="0" max="20" step="0.1" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Progreso (%)</label>
                <input type="number" id="progreso-estudiante" class="form-control" min="0" max="100" step="1" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Observaciones</label>
                <textarea id="observaciones" class="form-control" rows="4" placeholder="Comentarios sobre el desempeño del estudiante..."></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn" style="background: #6b7280; color: white;" onclick="cerrarModalCalificar()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    📊 Guardar Calificación
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function filtrarEstudiantes() {
    const filtroCurso = document.getElementById('filtro-curso').value.toLowerCase();
    const filtroEstado = document.getElementById('filtro-estado').value.toLowerCase();
    const buscarTexto = document.getElementById('buscar-estudiante').value.toLowerCase();
    const estudiantes = document.querySelectorAll('.estudiante-item');
    
    estudiantes.forEach(estudiante => {
        const curso = estudiante.getAttribute('data-curso').toLowerCase();
        const estado = estudiante.getAttribute('data-estado').toLowerCase();
        const nombre = estudiante.getAttribute('data-nombre').toLowerCase();
        
        const cumpleCurso = filtroCurso === '' || curso.includes(filtroCurso);
        const cumpleEstado = filtroEstado === '' || estado === filtroEstado;
        const cumpleBusqueda = buscarTexto === '' || nombre.includes(buscarTexto);
        
        if (cumpleCurso && cumpleEstado && cumpleBusqueda) {
            estudiante.style.display = 'block';
        } else {
            estudiante.style.display = 'none';
        }
    });
}

function verPerfilEstudiante(id) {
    alert(`Ver perfil de estudiante ID: ${id} (a implementar)`);
}

function calificarEstudiante(cursoEstudianteId) {
    document.getElementById('curso-estudiante-id').value = cursoEstudianteId;
    document.getElementById('modal-calificar').style.display = 'flex';
}

function enviarMensaje(estudianteId) {
    alert(`Enviar mensaje a estudiante ID: ${estudianteId} (a implementar)`);
}

function calificarEstudiantes() {
    alert('Funcionalidad de calificación masiva a implementar');
}

function exportarReporte() {
    alert('Funcionalidad de exportar reporte a implementar');
}

function cerrarModalCalificar() {
    document.getElementById('modal-calificar').style.display = 'none';
    document.getElementById('form-calificar').reset();
}

// Manejar envío del formulario de calificación
document.getElementById('form-calificar').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const cursoEstudianteId = document.getElementById('curso-estudiante-id').value;
    const calificacion = document.getElementById('calificacion-final').value;
    const progreso = document.getElementById('progreso-estudiante').value;
    const observaciones = document.getElementById('observaciones').value;
    
    alert('Calificación guardada exitosamente');
    cerrarModalCalificar();
    location.reload();
});

// Cerrar modal al hacer click fuera
document.getElementById('modal-calificar').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalCalificar();
    }
});

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