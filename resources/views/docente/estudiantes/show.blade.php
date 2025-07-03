@extends('layouts.app')

@section('title', ($estudiante->nombre ?? 'Estudiante') . ' - Detalle Estudiante')
@section('header', 'Detalle del Estudiante')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('docente.estudiantes.index') }}" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver a Estudiantes
    </a>
</div>

<!-- Header del Estudiante -->
<div class="card" style="margin-bottom: 2rem; background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%); color: white;">
    <div class="card-body" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <div style="
                    width: 80px; 
                    height: 80px; 
                    border-radius: 50%;
                    background: rgba(255,255,255,0.2);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-weight: 700;
                    font-size: 2rem;
                ">
                    {{ strtoupper(substr($estudiante->nombre ?? 'N', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2rem;">
                        👨‍🎓 {{ $estudiante->nombre ?? 'Sin nombre' }} {{ $estudiante->apellido ?? '' }}
                    </h1>
                    <p style="margin: 0 0 0.5rem 0; opacity: 0.9; font-size: 1.1rem;">
                        📧 {{ $estudiante->correo ?? 'Sin correo' }}
                    </p>
                    <p style="margin: 0; opacity: 0.8; font-size: 0.9rem;">
                        🆔 DNI: {{ $estudiante->dni ?? 'No registrado' }}
                    </p>
                </div>
            </div>
            <div style="text-align: right;">
                <span style="
                    background: var(--success-color);
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 9999px;
                    font-size: 0.875rem;
                    font-weight: 600;
                ">
                    📚 {{ $estadisticas['total_cursos'] }} Curso(s)
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Generales -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $estadisticas['total_cursos'] }}</div>
        <div class="stat-label">Total Cursos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $estadisticas['cursos_activos'] }}</div>
        <div class="stat-label">Cursos Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ number_format($estadisticas['progreso_promedio'], 1) }}%</div>
        <div class="stat-label">Progreso Promedio</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">
            @if($estadisticas['calificacion_promedio'])
                {{ number_format($estadisticas['calificacion_promedio'], 1) }}
            @else
                --
            @endif
        </div>
        <div class="stat-label">Nota Promedio</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $estadisticas['cursos_aprobados'] }}</div>
        <div class="stat-label">Cursos Aprobados</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $estadisticas['cursos_con_calificacion'] }}</div>
        <div class="stat-label">Con Calificación</div>
    </div>
</div>

<!-- Cursos del Estudiante -->
<div class="card">
    <div class="card-header">
        <h3>📚 Cursos del Estudiante</h3>
    </div>
    <div class="card-body">
        @if($cursosCompartidos->count() > 0)
            <div style="display: grid; gap: 1.5rem;">
                @foreach($cursosCompartidos as $cursoEstudiante)
                @php
                    $curso = $cursoEstudiante->curso;
                    $progreso = $cursoEstudiante->progreso ?? 0;
                    $calificacion = $cursoEstudiante->calificacion_final;
                @endphp
                
                <div style="
                    padding: 1.5rem; 
                    border: 1px solid #e5e7eb; 
                    border-radius: var(--border-radius);
                    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                " 
                data-curso-estudiante-id="{{ $cursoEstudiante->id }}"
                data-calificacion="{{ $calificacion ?? '' }}"
                data-progreso="{{ number_format($progreso, 1) }}">
                    
                    <!-- Header del curso -->
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div style="flex: 1;">
                            <h4 style="color: var(--primary-blue); margin-bottom: 0.5rem; font-size: 1.25rem;">
                                📖 {{ $curso->nombre ?? 'Sin nombre' }}
                            </h4>
                            <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 0.75rem;">
                                <span>🎯 {{ $curso->ciclo->nombre_area ?? 'Sin área' }}</span>
                                <span>⏱️ {{ $curso->duracion_horas ?? 'N/A' }} horas</span>
                                <span>🎓 {{ ucfirst($curso->modalidad ?? 'N/A') }}</span>
                            </div>
                            @if($curso->descripcion)
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                {{ Str::limit($curso->descripcion, 150) }}
                            </p>
                            @endif
                        </div>
                        <div style="text-align: right;">
                            <span style="
                                background: {{ $cursoEstudiante->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                                color: white;
                                padding: 0.25rem 0.75rem;
                                border-radius: 9999px;
                                font-size: 0.75rem;
                                font-weight: 600;
                                text-transform: uppercase;
                            ">
                                {{ $cursoEstudiante->estado === 'activo' ? '✅ Activo' : '⏸️ Inactivo' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Progreso del curso -->
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
                    
                    <!-- Información académica -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="text-align: center; padding: 1rem; background: #f0f9ff; border-radius: var(--border-radius);">
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue);">
                                @if($calificacion)
                                    {{ number_format($calificacion, 1) }}
                                @else
                                    --
                                @endif
                            </div>
                            <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                                Calificación
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding: 1rem; background: #f0fdf4; border-radius: var(--border-radius);">
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--success-color);">
                                @if($calificacion >= 11)
                                    ✅
                                @elseif($calificacion)
                                    ❌
                                @else
                                    ⏳
                                @endif
                            </div>
                            <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                                Estado
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding: 1rem; background: #fef3c7; border-radius: var(--border-radius);">
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent-color);">
                                📅
                            </div>
                            <div style="font-size: 0.75rem; color: #6b7280; font-weight: 600;">
                                Matriculado
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fechas importantes -->
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                            <span style="color: #374151;">
                                <strong>Matriculado:</strong> {{ $cursoEstudiante->created_at->format('d/m/Y') }}
                            </span>
                            @if($cursoEstudiante->fecha_inscripcion)
                            <span style="color: #374151;">
                                <strong>Inscripción:</strong> {{ $cursoEstudiante->fecha_inscripcion->format('d/m/Y') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Observaciones -->
                    @if($cursoEstudiante->observaciones)
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fffbeb; border-radius: var(--border-radius); border-left: 4px solid var(--warning-color);">
                        <div style="font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">📝 Observaciones:</div>
                        <div style="color: #374151; font-size: 0.875rem;">{{ $cursoEstudiante->observaciones }}</div>
                    </div>
                    @endif
                    
                    <!-- Acciones -->
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="button" 
                                class="btn btn-success"
                                style="font-size: 0.875rem; padding: 0.5rem 1rem;"
                                onclick="calificarEstudiante({{ $cursoEstudiante->id }})"
                                title="Calificar estudiante en este curso">
                            📊 Calificar
                        </button>
                        <a href="{{ route('docente.cursos.show', $curso->id) }}" 
                           class="btn btn-primary" 
                           style="font-size: 0.875rem; padding: 0.5rem 1rem; text-decoration: none;"
                           title="Ver curso completo">
                            📖 Ver Curso
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #6b7280;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3 style="margin-bottom: 1rem;">No hay cursos compartidos</h3>
                <p>Este estudiante no está matriculado en ninguno de sus cursos</p>
            </div>
        @endif
    </div>
</div>

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
        <h3 style="margin: 0 0 1.5rem 0; color: var(--dark-color);">📊 Calificar a {{ $estudiante->nombre ?? 'Estudiante' }}</h3>
        
        <form id="form-calificar">
            <input type="hidden" id="curso-estudiante-id">
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark-color);">Nota Final (0-20)</label>
                <input type="number" id="calificacion-final" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: var(--border-radius);" min="0" max="20" step="0.1" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark-color);">Progreso (%)</label>
                <input type="number" id="progreso-estudiante" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: var(--border-radius);" min="0" max="100" step="1" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark-color);">Observaciones</label>
                <textarea id="observaciones" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: var(--border-radius);" rows="4" placeholder="Comentarios sobre el desempeño del estudiante..."></textarea>
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
function calificarEstudiante(cursoEstudianteId) {
    document.getElementById('curso-estudiante-id').value = cursoEstudianteId;
    
    // Buscar los datos actuales del estudiante en la página
    const estudianteCard = document.querySelector(`[data-curso-estudiante-id="${cursoEstudianteId}"]`);
    if (estudianteCard) {
        // Si ya tiene calificación, llenar el modal con los datos existentes
        const calificacionActual = estudianteCard.getAttribute('data-calificacion');
        const progresoActual = estudianteCard.getAttribute('data-progreso');
        
        if (calificacionActual && calificacionActual !== '--' && calificacionActual !== 'null' && calificacionActual !== '') {
            document.getElementById('calificacion-final').value = calificacionActual;
        }
        if (progresoActual) {
            document.getElementById('progreso-estudiante').value = progresoActual;
        }
    }
    
    document.getElementById('modal-calificar').style.display = 'flex';
}

function cerrarModalCalificar() {
    document.getElementById('modal-calificar').style.display = 'none';
    document.getElementById('form-calificar').reset();
}

// Manejar envío del formulario de calificación
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-calificar').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const cursoEstudianteId = document.getElementById('curso-estudiante-id').value;
        const calificacion = document.getElementById('calificacion-final').value;
        const progreso = document.getElementById('progreso-estudiante').value;
        const observaciones = document.getElementById('observaciones').value;
        
        // Deshabilitar el botón mientras se procesa
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Guardando...';
        
        // Enviar datos al servidor
        fetch('{{ route("docente.estudiantes.calificar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                curso_estudiante_id: cursoEstudianteId,
                calificacion_final: calificacion,
                progreso: progreso,
                observaciones: observaciones
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                cerrarModalCalificar();
                location.reload();
            } else {
                alert('❌ Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al guardar la calificación. Intente nuevamente.');
        })
        .finally(() => {
            // Rehabilitar el botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Cerrar modal al hacer click fuera
    document.getElementById('modal-calificar').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalCalificar();
        }
    });
});
</script>

<style>
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .card .card-body > div:nth-child(3) {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection