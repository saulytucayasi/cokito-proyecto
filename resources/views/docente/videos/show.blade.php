@extends('layouts.app')

@section('title', 'Ver Video - COKITO+ Academia')
@section('header', 'Detalles del Video')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="color: var(--primary-blue);">{{ $video->titulo }}</h2>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('docente.videos.edit', $video->id) }}" class="btn btn-warning">
            ✏️ Editar Video
        </a>
        <a href="{{ route('docente.videos.index') }}" class="btn btn-secondary">
            ← Volver a Videos
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Video Principal -->
    <div class="card">
        <div class="card-header">
            <h3>🎥 Video</h3>
        </div>
        <div class="card-body">
            @if($video->video_id_youtube)
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: var(--border-radius);">
                    <iframe 
                        src="https://www.youtube.com/embed/{{ $video->video_id_youtube }}" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                        allowfullscreen>
                    </iframe>
                </div>
            @else
                <div style="background: #f3f4f6; padding: 3rem; text-align: center; border-radius: var(--border-radius);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎥</div>
                    <p style="color: #6b7280;">No se pudo cargar el video</p>
                    <a href="{{ $video->url_youtube }}" target="_blank" class="btn btn-primary" style="margin-top: 1rem;">
                        Ver en YouTube
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Información del Video -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Información</h3>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Curso:</label>
                <p style="color: #6b7280;">{{ $video->curso->nombre ?? 'N/A' }}</p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Ciclo:</label>
                <p style="color: #6b7280;">{{ $video->curso->ciclo->nombre_area ?? 'N/A' }}</p>
            </div>

            @if($video->descripcion)
            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Descripción:</label>
                <p style="color: #6b7280; line-height: 1.6;">{{ $video->descripcion }}</p>
            </div>
            @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Orden:</label>
                <p style="color: #6b7280;"># {{ $video->orden }}</p>
            </div>

            @if($video->duracion)
            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Duración:</label>
                <p style="color: #6b7280;">{{ $video->duracion }}</p>
            </div>
            @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Estado:</label>
                <span style="
                    padding: 0.25rem 0.75rem; 
                    border-radius: 9999px; 
                    font-size: 0.875rem;
                    background-color: {{ $video->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                    color: white;
                ">
                    {{ ucfirst($video->estado) }}
                </span>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">URL de YouTube:</label>
                <a href="{{ $video->url_youtube }}" target="_blank" style="color: var(--primary-blue); text-decoration: none; word-break: break-all;">
                    {{ $video->url_youtube }}
                </a>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.5rem;">Fecha de Creación:</label>
                <p style="color: #6b7280;">{{ $video->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Acciones -->
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h3>⚡ Acciones</h3>
    </div>
    <div class="card-body">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('docente.videos.edit', $video->id) }}" class="btn btn-warning">
                ✏️ Editar Video
            </a>
            <a href="{{ $video->url_youtube }}" target="_blank" class="btn btn-info">
                🔗 Abrir en YouTube
            </a>
            <form action="{{ route('docente.videos.destroy', $video->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este video?')">
                    🗑️ Eliminar Video
                </button>
            </form>
        </div>
    </div>
</div>
@endsection