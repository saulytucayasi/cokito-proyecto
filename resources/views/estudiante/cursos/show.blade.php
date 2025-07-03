@extends('layouts.app')

@section('title', $curso->nombre . ' - COKITO+ Academia')
@section('header', $curso->nombre)

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('estudiante.cursos.index') }}" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver a Mis Cursos
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Información Principal del Curso -->
    <div>
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h3>📚 Información del Curso</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <strong>Ciclo:</strong> {{ $curso->ciclo->nombre_area ?? 'N/A' }}
                        <span style="color: #6b7280; font-size: 0.875rem; margin-left: 1rem;">
                            ({{ $curso->ciclo->fecha_inicio ?? 'N/A' }} - {{ $curso->ciclo->fecha_fin ?? 'N/A' }})
                        </span>
                    </div>
                    <div>
                        <strong>Docente:</strong> {{ $curso->docente->nombre ?? 'Sin docente asignado' }}
                        @if($curso->docente)
                        <span style="color: #6b7280; font-size: 0.875rem; margin-left: 1rem;">
                            📧 {{ $curso->docente->correo }}
                        </span>
                        @endif
                    </div>
                    <div>
                        <strong>Duración:</strong> {{ $curso->duracion_horas ?? 'N/A' }} horas
                    </div>
                    <div>
                        <strong>Modalidad:</strong> {{ ucfirst($curso->modalidad ?? 'N/A') }}
                    </div>
                    @if($curso->descripcion)
                    <div>
                        <strong>Descripción:</strong>
                        <p style="margin-top: 0.5rem; color: #6b7280;">{{ $curso->descripcion }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sesiones del Curso -->
        @if($curso->sesiones->count() > 0)
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h3>📅 Sesiones del Curso</h3>
                <span style="font-size: 0.875rem; color: #6b7280;">
                    {{ $curso->sesiones->count() }} sesiones programadas
                </span>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    @foreach($curso->sesiones->sortBy('orden') as $sesion)
                    @php
                        $progreso = $progresoSesiones[$sesion->id] ?? null;
                        $completada = $progreso && $progreso->completada;
                        $calificacion = $progreso ? $progreso->calificacion : null;
                    @endphp
                    <div style="
                        padding: 1rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background-color: {{ $completada ? '#f0fdf4' : '#f9fafb' }};
                        border-left: 4px solid {{ $completada ? 'var(--success-color)' : '#d1d5db' }};
                    ">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div style="flex: 1;">
                                <h4 style="margin-bottom: 0.5rem; color: var(--primary-blue);">
                                    Sesión {{ $sesion->orden }}: {{ $sesion->titulo }}
                                </h4>
                                <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">
                                    <span>📅 {{ $sesion->fecha_programada ? \Carbon\Carbon::parse($sesion->fecha_programada)->format('d/m/Y') : 'Sin fecha' }}</span>
                                    <span>⏱️ {{ $sesion->duracion_minutos ?? 'N/A' }} minutos</span>
                                </div>
                                @if($sesion->descripcion)
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                    {{ $sesion->descripcion }}
                                </p>
                                @endif
                                @if($calificacion)
                                <div style="margin-top: 0.5rem;">
                                    <span style="font-size: 0.875rem; color: #374151;">Calificación: </span>
                                    <span style="
                                        font-weight: 600; 
                                        padding: 0.25rem 0.5rem;
                                        border-radius: 4px;
                                        color: white;
                                        background-color: {{ $calificacion >= 14 ? 'var(--success-color)' : 'var(--danger-color)' }};
                                    ">
                                        {{ $calificacion }}/20
                                    </span>
                                </div>
                                @endif
                            </div>
                            <div style="text-align: center;">
                                @if($completada)
                                <span style="
                                    padding: 0.25rem 0.75rem; 
                                    border-radius: 9999px; 
                                    font-size: 0.75rem;
                                    background-color: var(--success-color);
                                    color: white;
                                ">
                                    ✓ Completada
                                </span>
                                @else
                                <span style="
                                    padding: 0.25rem 0.75rem; 
                                    border-radius: 9999px; 
                                    font-size: 0.75rem;
                                    background-color: #6b7280;
                                    color: white;
                                ">
                                    Pendiente
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Materiales del Curso -->
        @if($curso->materiales->count() > 0)
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h3>📁 Materiales del Curso</h3>
                <span style="font-size: 0.875rem; color: #6b7280;">
                    {{ $curso->materiales->where('es_publico', true)->count() }} materiales disponibles
                </span>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    @foreach($curso->materiales->where('es_publico', true)->sortBy('orden') as $material)
                    <div style="
                        display: flex; 
                        align-items: center; 
                        padding: 1rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background-color: #f9fafb;
                    ">
                        <div style="margin-right: 1rem; font-size: 1.5rem;">
                            @if(str_contains($material->tipo_archivo, 'pdf'))
                                📄
                            @elseif(str_contains($material->tipo_archivo, 'image'))
                                🖼️
                            @elseif(str_contains($material->tipo_archivo, 'video'))
                                🎥
                            @else
                                📄
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <h4 style="margin-bottom: 0.25rem;">{{ $material->titulo }}</h4>
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">
                                {{ $material->descripcion ?? 'Sin descripción' }}
                            </p>
                            <span style="font-size: 0.75rem; color: #9ca3af;">
                                Subido: {{ $material->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <a href="{{ route('materiales.download', $material->id) }}" class="btn btn-primary" style="font-size: 0.875rem;">
                            📥 Descargar
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Videos del Curso -->
        @if($curso->videos->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3>🎥 Videos del Curso</h3>
                <span style="font-size: 0.875rem; color: #6b7280;">
                    {{ $curso->videos->where('estado', 'activo')->count() }} videos disponibles
                </span>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 2rem;">
                    @foreach($curso->videos->where('estado', 'activo')->sortBy('orden') as $video)
                    <div id="video-{{ $video->id }}" style="
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                        scroll-margin-top: 2rem;
                    ">
                        <div style="margin-bottom: 1rem;">
                            <h4 style="margin-bottom: 0.5rem; color: var(--primary-blue);">
                                Video {{ $video->orden ?? '' }}: {{ $video->titulo }}
                            </h4>
                            @if($video->descripcion)
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                {{ $video->descripcion }}
                            </p>
                            @endif
                            <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                                <span>⏱️ {{ $video->duracion ?? 'N/A' }}</span>
                                <span>📅 Subido: {{ $video->created_at->format('d/m/Y') }}</span>
                                @if($video->orden)
                                <span>📋 Orden: {{ $video->orden }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Reproductor de Video Integrado -->
                        <div style="
                            position: relative; 
                            width: 100%; 
                            height: 0; 
                            padding-bottom: 56.25%; /* 16:9 aspect ratio */
                            margin-bottom: 1rem;
                            border-radius: var(--border-radius);
                            overflow: hidden;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                        ">
                            @php
                                // Extraer ID del video de YouTube de la URL
                                $videoId = '';
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->url_youtube, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            
                            @if($videoId)
                            <iframe 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1&showinfo=0"
                                title="{{ $video->titulo }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                            @else
                            <div style="
                                position: absolute; 
                                top: 0; 
                                left: 0; 
                                width: 100%; 
                                height: 100%;
                                background-color: #f3f4f6;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                flex-direction: column;
                                color: #6b7280;
                            ">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">🎥</div>
                                <p>Video no disponible</p>
                                <a href="{{ $video->url_youtube }}" target="_blank" class="btn btn-primary" style="margin-top: 1rem; font-size: 0.875rem;">
                                    Ver en YouTube
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Controles adicionales -->
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; gap: 0.5rem;">
                                @if($video->orden && $video->orden > 1)
                                @php
                                    $prevVideo = $curso->videos->where('estado', 'activo')->where('orden', $video->orden - 1)->first();
                                @endphp
                                @if($prevVideo)
                                <button onclick="scrollToVideo('video-{{ $prevVideo->id }}')" class="btn" style="font-size: 0.875rem; padding: 0.5rem 1rem; background-color: #6b7280; color: white;">
                                    ⬅️ Anterior
                                </button>
                                @endif
                                @endif

                                @if($video->orden && $video->orden < $curso->videos->where('estado', 'activo')->max('orden'))
                                @php
                                    $nextVideo = $curso->videos->where('estado', 'activo')->where('orden', $video->orden + 1)->first();
                                @endphp
                                @if($nextVideo)
                                <button onclick="scrollToVideo('video-{{ $nextVideo->id }}')" class="btn" style="font-size: 0.875rem; padding: 0.5rem 1rem; background-color: var(--primary-blue); color: white;">
                                    Siguiente ➡️
                                </button>
                                @endif
                                @endif
                            </div>

                            <a href="{{ $video->url_youtube }}" target="_blank" class="btn" style="font-size: 0.875rem; padding: 0.5rem 1rem; background-color: #ff0000; color: white;">
                                🔗 Abrir en YouTube
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
        function scrollToVideo(videoId) {
            const element = document.getElementById(videoId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        </script>
        @endif
    </div>

    <!-- Panel Lateral -->
    <div>
        <!-- Progreso del Estudiante -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h3>📊 Mi Progreso</h3>
            </div>
            <div class="card-body" style="text-align: center;">
                <div style="display: inline-block; position: relative; margin-bottom: 1rem;">
                    <div style="
                        width: 100px; 
                        height: 100px; 
                        border-radius: 50%; 
                        background: conic-gradient(var(--primary-blue) {{ ($cursoEstudiante->progreso ?? 0) * 3.6 }}deg, #e5e7eb 0deg);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        position: relative;
                    ">
                        <div style="
                            width: 70px; 
                            height: 70px; 
                            background: white; 
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 1.25rem;
                            font-weight: 700;
                            color: var(--primary-blue);
                        ">
                            {{ number_format($cursoEstudiante->progreso ?? 0, 0) }}%
                        </div>
                    </div>
                </div>
                <p style="color: #6b7280; margin-bottom: 1rem;">Progreso general del curso</p>
                
                @if($cursoEstudiante->calificacion_final)
                <div style="
                    padding: 1rem; 
                    background-color: {{ $cursoEstudiante->calificacion_final >= 14 ? '#f0fdf4' : '#fef2f2' }};
                    border-radius: var(--border-radius);
                    border: 1px solid {{ $cursoEstudiante->calificacion_final >= 14 ? '#bbf7d0' : '#fecaca' }};
                ">
                    <div style="font-size: 0.875rem; color: #374151; margin-bottom: 0.25rem;">Calificación Final</div>
                    <div style="
                        font-size: 1.5rem; 
                        font-weight: 700; 
                        color: {{ $cursoEstudiante->calificacion_final >= 14 ? 'var(--success-color)' : 'var(--danger-color)' }};
                    ">
                        {{ $cursoEstudiante->calificacion_final }}/20
                    </div>
                    <div style="font-size: 0.75rem; color: #6b7280;">
                        {{ $cursoEstudiante->calificacion_final >= 14 ? 'Aprobado' : 'Desaprobado' }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Estado de Matrícula -->
        <div class="card">
            <div class="card-header">
                <h3>📋 Estado de Matrícula</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <span style="font-size: 0.875rem; color: #374151;">Estado:</span>
                        <span style="
                            margin-left: 0.5rem;
                            padding: 0.25rem 0.75rem; 
                            border-radius: 9999px; 
                            font-size: 0.75rem;
                            background-color: {{ $cursoEstudiante->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                            color: white;
                        ">
                            {{ ucfirst($cursoEstudiante->estado) }}
                        </span>
                    </div>
                    @if($cursoEstudiante->matricula)
                    <div>
                        <span style="font-size: 0.875rem; color: #374151;">Fecha de Matrícula:</span>
                        <div style="margin-top: 0.25rem; color: #6b7280;">
                            {{ $cursoEstudiante->matricula->fecha_matricula ? \Carbon\Carbon::parse($cursoEstudiante->matricula->fecha_matricula)->format('d/m/Y') : 'N/A' }}
                        </div>
                    </div>
                    @endif
                    <div>
                        <span style="font-size: 0.875rem; color: #374151;">Sesiones Completadas:</span>
                        <div style="margin-top: 0.25rem; color: #6b7280;">
                            {{ $progresoSesiones->where('completada', true)->count() }} / {{ $curso->sesiones->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection