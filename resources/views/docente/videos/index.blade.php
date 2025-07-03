@extends('layouts.app')

@section('title', 'Gestión de Videos - COKITO+ Academia')
@section('header', 'Gestión de Videos')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="color: var(--primary-blue);">Mis Videos por Curso</h2>
    <a href="{{ route('docente.videos.create') }}" class="btn btn-primary">
        ➕ Agregar Nuevo Video
    </a>
</div>

<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->count() }}</div>
        <div class="stat-label">Cursos Asignados</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->videos->count(); }) }}</div>
        <div class="stat-label">Videos Totales</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->videos->where('estado', 'activo')->count(); }) }}</div>
        <div class="stat-label">Videos Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->filter(function($curso) { return $curso->videos->count() > 0; })->count() }}</div>
        <div class="stat-label">Cursos con Videos</div>
    </div>
</div>

@if($cursosAsignados->count() > 0)
    <div style="display: grid; gap: 2rem;">
        @foreach($cursosAsignados as $curso)
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3>📚 {{ $curso->nombre }}</h3>
                    <span style="font-size: 0.875rem; color: #6b7280;">
                        Ciclo: {{ $curso->ciclo->nombre_area ?? 'N/A' }} | 
                        {{ $curso->videos->count() }} video{{ $curso->videos->count() != 1 ? 's' : '' }}
                    </span>
                </div>
                <a href="{{ route('docente.videos.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary" style="font-size: 0.875rem;">
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
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                ">
                                    @php
                                        // Extraer ID del video de YouTube
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
                                    <div style="color: white; font-size: 2rem;">🎥</div>
                                    @endif
                                </div>
                                
                                <!-- Información del video -->
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                        <h4 style="color: var(--primary-blue); margin-bottom: 0.25rem;">
                                            {{ $video->titulo }}
                                        </h4>
                                        <span style="
                                            padding: 0.25rem 0.75rem; 
                                            border-radius: 9999px; 
                                            font-size: 0.75rem;
                                            background-color: {{ $video->estado === 'activo' ? 'var(--success-color)' : '#6b7280' }};
                                            color: white;
                                            white-space: nowrap;
                                        ">
                                            {{ ucfirst($video->estado) }}
                                        </span>
                                    </div>
                                    
                                    @if($video->descripcion)
                                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem; line-height: 1.4;">
                                        {{ Str::limit($video->descripcion, 150) }}
                                    </p>
                                    @endif
                                    
                                    <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                                        @if($video->orden)
                                        <span>📋 Orden: {{ $video->orden }}</span>
                                        @endif
                                        @if($video->duracion)
                                        <span>⏱️ {{ $video->duracion }}</span>
                                        @endif
                                        <span>📅 {{ $video->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <a href="{{ route('docente.videos.show', $video->id) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                            👁️ Ver
                                        </a>
                                        <a href="{{ route('docente.videos.edit', $video->id) }}" class="btn" style="font-size: 0.875rem; padding: 0.5rem 1rem; background-color: var(--warning-color); color: white;">
                                            ✏️ Editar
                                        </a>
                                        <a href="{{ $video->url_youtube }}" target="_blank" class="btn" style="font-size: 0.875rem; padding: 0.5rem 1rem; background-color: #ff0000; color: white;">
                                            🔗 YouTube
                                        </a>
                                        <form method="POST" action="{{ route('docente.videos.destroy', $video->id) }}" style="display: inline;" 
                                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este video?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎥</div>
                        <p style="margin-bottom: 1rem;">No hay videos en este curso aún</p>
                        <a href="{{ route('docente.videos.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary">
                            ➕ Agregar Primer Video
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
            <h3 style="margin-bottom: 1rem; color: var(--primary-blue);">No tienes cursos asignados</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Necesitas tener cursos asignados para poder subir videos.
            </p>
            <a href="{{ route('docente.cursos.index') }}" class="btn btn-primary">
                📚 Ver Mis Cursos
            </a>
        </div>
    </div>
@endif
@endsection