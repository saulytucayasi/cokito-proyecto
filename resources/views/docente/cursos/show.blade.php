@extends('layouts.app')

@section('title', $curso->nombre . ' - Gestión Docente')
@section('header', $curso->nombre)

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('docente.cursos.index') }}" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver a Mis Cursos
    </a>
</div>

<!-- Header del Curso -->
<div class="card" style="margin-bottom: 2rem; background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%); color: white;">
    <div class="card-body" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div style="flex: 1;">
                <h1 style="margin: 0 0 0.5rem 0; font-size: 2rem;">📚 {{ $curso->nombre }}</h1>
                <p style="margin: 0 0 1rem 0; opacity: 0.9; font-size: 1.1rem;">
                    {{ $curso->ciclo->nombre_area ?? 'Sin ciclo asignado' }}
                </p>
                <div style="display: flex; gap: 2rem; font-size: 0.875rem; opacity: 0.8;">
                    <span>⏱️ {{ $curso->duracion_horas ?? 'N/A' }} horas</span>
                    <span>🎯 {{ ucfirst($curso->modalidad ?? 'N/A') }}</span>
                    <span>📅 {{ $curso->sesiones->count() }} sesiones</span>
                    <span>👥 {{ $curso->cursoEstudiantes->count() }} estudiantes</span>
                </div>
            </div>
            <div style="text-align: right;">
                <span style="
                    background: {{ $curso->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 9999px;
                    font-size: 0.875rem;
                    font-weight: 600;
                ">
                    {{ $curso->estado === 'activo' ? '✅ Activo' : '⏸️ Inactivo' }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas del Curso -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $curso->sesiones->count() }}</div>
        <div class="stat-label">Sesiones Programadas</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $curso->materiales->count() }}</div>
        <div class="stat-label">Materiales Subidos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $curso->videos->count() }}</div>
        <div class="stat-label">Videos Disponibles</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $curso->cursoEstudiantes->count() }}</div>
        <div class="stat-label">Estudiantes Matriculados</div>
    </div>
</div>

<!-- Navegación por Pestañas -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; border-bottom: 2px solid #e5e7eb;">
        <button class="tab-button active" onclick="showTab('sesiones')" id="tab-sesiones">
            📅 Sesiones del Curso
        </button>
        <button class="tab-button" onclick="showTab('materiales')" id="tab-materiales">
            📁 Materiales
        </button>
        <button class="tab-button" onclick="showTab('videos')" id="tab-videos">
            🎥 Videos
        </button>
        <button class="tab-button" onclick="showTab('estudiantes')" id="tab-estudiantes">
            👥 Estudiantes
        </button>
    </div>
</div>

<!-- Contenido de Pestañas -->

<!-- Pestaña Sesiones -->
<div id="content-sesiones" class="tab-content active">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>📅 Sesiones del Curso</h3>
            <button class="btn btn-primary" onclick="crearSesion()">
                ➕ Crear Nueva Sesión
            </button>
        </div>
        <div class="card-body">
            @if($curso->sesiones->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($curso->sesiones->sortBy('orden') as $sesion)
                    <div style="
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    ">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <h4 style="color: var(--primary-blue); margin-bottom: 0.5rem;">
                                    Sesión {{ $sesion->orden }}: {{ $sesion->titulo }}
                                </h4>
                                <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 0.75rem;">
                                    <span>📅 {{ $sesion->fecha_programada ? \Carbon\Carbon::parse($sesion->fecha_programada)->format('d/m/Y H:i') : 'Sin fecha' }}</span>
                                    <span>⏱️ {{ $sesion->duracion_minutos ?? 'N/A' }} min</span>
                                </div>
                                @if($sesion->descripcion)
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                    {{ $sesion->descripcion }}
                                </p>
                                @endif
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <button onclick="editarSesion({{ $sesion->id }})" class="btn" style="background-color: var(--warning-color); color: white; font-size: 0.875rem; padding: 0.5rem 1rem;">
                                    ✏️ Editar
                                </button>
                                <button onclick="calificarSesion({{ $sesion->id }})" class="btn btn-success" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                    📊 Calificar
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📅</div>
                    <h3 style="margin-bottom: 1rem;">No hay sesiones programadas</h3>
                    <p style="margin-bottom: 2rem;">Agrega sesiones para estructurar tu curso</p>
                    <button class="btn btn-primary" onclick="crearSesion()">
                        ➕ Crear Primera Sesión
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pestaña Materiales -->
<div id="content-materiales" class="tab-content">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>📁 Materiales del Curso</h3>
            <a href="{{ route('docente.materiales.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary">
                ➕ Subir Material
            </a>
        </div>
        <div class="card-body">
            @if($curso->materiales->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($curso->materiales->sortBy('orden') as $material)
                    <div style="
                        display: flex; 
                        align-items: center; 
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    ">
                        <div style="margin-right: 1.5rem; font-size: 2rem;">
                            @if(str_contains($material->tipo_archivo ?? '', 'pdf'))
                                📄
                            @elseif(str_contains($material->tipo_archivo ?? '', 'image'))
                                🖼️
                            @elseif(str_contains($material->tipo_archivo ?? '', 'video'))
                                🎥
                            @else
                                📄
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <h4 style="color: var(--primary-blue); margin-bottom: 0.5rem;">{{ $material->titulo }}</h4>
                            @if($material->descripcion)
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $material->descripcion }}</p>
                            @endif
                            <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                                <span>📋 Orden: {{ $material->orden }}</span>
                                <span>📅 {{ $material->created_at->format('d/m/Y') }}</span>
                                <span>👁️ {{ $material->es_publico ? 'Público' : 'Privado' }}</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('materiales.download', $material->id) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                📥 Descargar
                            </a>
                            <a href="{{ route('docente.materiales.edit', $material->id) }}" class="btn" style="background-color: var(--warning-color); color: white; font-size: 0.875rem; padding: 0.5rem 1rem;">
                                ✏️ Editar
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📁</div>
                    <h3 style="margin-bottom: 1rem;">No hay materiales subidos</h3>
                    <p style="margin-bottom: 2rem;">Sube contenido educativo para tus estudiantes</p>
                    <a href="{{ route('docente.materiales.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary">
                        ➕ Subir Primer Material
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pestaña Videos -->
<div id="content-videos" class="tab-content">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>🎥 Videos del Curso</h3>
            <a href="{{ route('docente.videos.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary">
                ➕ Agregar Video
            </a>
        </div>
        <div class="card-body">
            @if($curso->videos->count() > 0)
                <div style="display: grid; gap: 1.5rem;">
                    @foreach($curso->videos->sortBy('orden') as $video)
                    <div style="
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    ">
                        <div style="display: flex; gap: 1.5rem;">
                            <!-- Thumbnail del video -->
                            <div style="
                                width: 160px; 
                                height: 90px; 
                                border-radius: var(--border-radius);
                                overflow: hidden;
                                background-color: #000;
                                flex-shrink: 0;
                            ">
                                @php
                                    $videoId = '';
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->url_youtube, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                
                                @if($videoId)
                                <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" 
                                     alt="{{ $video->titulo }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white; font-size: 2rem;">🎥</div>
                                @endif
                            </div>
                            
                            <!-- Información del video -->
                            <div style="flex: 1;">
                                <h4 style="color: var(--primary-blue); margin-bottom: 0.5rem;">
                                    Video {{ $video->orden }}: {{ $video->titulo }}
                                </h4>
                                @if($video->descripcion)
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                    {{ Str::limit($video->descripcion, 150) }}
                                </p>
                                @endif
                                <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                                    <span>📋 Orden: {{ $video->orden }}</span>
                                    <span>⏱️ {{ $video->duracion ?? 'N/A' }}</span>
                                    <span>📅 {{ $video->created_at->format('d/m/Y') }}</span>
                                    <span>👁️ {{ ucfirst($video->estado) }}</span>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ $video->url_youtube }}" target="_blank" class="btn" style="background-color: #ff0000; color: white; font-size: 0.875rem; padding: 0.5rem 1rem;">
                                        ▶️ Ver en YouTube
                                    </a>
                                    <a href="{{ route('docente.videos.edit', $video->id) }}" class="btn" style="background-color: var(--warning-color); color: white; font-size: 0.875rem; padding: 0.5rem 1rem;">
                                        ✏️ Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🎥</div>
                    <h3 style="margin-bottom: 1rem;">No hay videos agregados</h3>
                    <p style="margin-bottom: 2rem;">Agrega videos de YouTube para complementar el curso</p>
                    <a href="{{ route('docente.videos.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary">
                        ➕ Agregar Primer Video
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pestaña Estudiantes -->
<div id="content-estudiantes" class="tab-content">
    <div class="card">
        <div class="card-header">
            <h3>👥 Estudiantes Matriculados</h3>
        </div>
        <div class="card-body">
            @if($curso->cursoEstudiantes->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($curso->cursoEstudiantes as $cursoEstudiante)
                    <div style="
                        display: flex; 
                        align-items: center; 
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    ">
                        <div style="
                            width: 50px; 
                            height: 50px; 
                            border-radius: 50%;
                            background: var(--primary-blue);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-weight: 700;
                            margin-right: 1rem;
                        ">
                            {{ strtoupper(substr($cursoEstudiante->estudiante->nombre ?? 'N', 0, 1)) }}{{ strtoupper(substr($cursoEstudiante->estudiante->apellido ?? 'A', 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <h4 style="color: var(--primary-blue); margin-bottom: 0.25rem;">
                                {{ $cursoEstudiante->estudiante->nombre ?? 'Sin nombre' }} {{ $cursoEstudiante->estudiante->apellido ?? '' }}
                            </h4>
                            <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280;">
                                <span>📧 {{ $cursoEstudiante->estudiante->correo ?? 'N/A' }}</span>
                                <span>📋 Progreso: {{ number_format($cursoEstudiante->progreso ?? 0, 1) }}%</span>
                                @if($cursoEstudiante->calificacion_final)
                                <span>📊 Nota: {{ $cursoEstudiante->calificacion_final }}/20</span>
                                @endif
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button onclick="calificarEstudianteCurso({{ $cursoEstudiante->id }})" class="btn btn-success" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                📊 Calificar
                            </button>
                            <a href="{{ route('docente.estudiantes.show', $cursoEstudiante->estudiante->id) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                👁️ Ver Perfil
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">👥</div>
                    <h3 style="margin-bottom: 1rem;">No hay estudiantes matriculados</h3>
                    <p>Los estudiantes aparecerán aquí cuando se matriculen en este curso</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.tab-button {
    padding: 1rem 1.5rem;
    border: none;
    background: none;
    font-size: 1rem;
    font-weight: 600;
    color: #6b7280;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-button:hover {
    color: var(--primary-blue);
    background-color: #f8fafc;
}

.tab-button.active {
    color: var(--primary-blue);
    border-bottom-color: var(--primary-blue);
    background-color: #f0f9ff;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}
</style>

<script>
function showTab(tabName) {
    // Ocultar todas las pestañas
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remover clase active de todos los botones
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Mostrar la pestaña seleccionada
    document.getElementById('content-' + tabName).classList.add('active');
    document.getElementById('tab-' + tabName).classList.add('active');
}

function crearSesion() {
    // TODO: Implementar modal o redirigir a formulario de creación de sesión
    alert('Crear sesión para curso: {{ $curso->nombre }}');
}

function editarSesion(sesionId) {
    alert('Editar sesión ID: ' + sesionId);
}

function calificarSesion(sesionId) {
    alert('Calificar sesión ID: ' + sesionId);
}

function calificarEstudianteCurso(cursoEstudianteId) {
    alert('Calificar estudiante en curso. ID: ' + cursoEstudianteId);
}
</script>
@endsection
