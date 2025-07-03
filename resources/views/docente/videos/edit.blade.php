@extends('layouts.app')

@section('title', 'Editar Video - COKITO+ Academia')
@section('header', 'Editar Video')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('docente.videos.show', $video->id) }}" class="btn btn-secondary">
        ← Volver al Video
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3>✏️ Editar Video: {{ $video->titulo }}</h3>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
            Modifica la información del video de YouTube
        </p>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div style="background-color: var(--danger-color); color: white; padding: 1rem; border-radius: var(--border-radius); margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('docente.videos.update', $video->id) }}" method="POST" style="display: grid; gap: 1.5rem;">
            @csrf
            @method('PUT')
            
            <!-- Título del Video -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    🎬 Título del Video *
                </label>
                <input type="text" 
                       name="titulo" 
                       value="{{ old('titulo', $video->titulo) }}"
                       style="
                           width: 100%; 
                           padding: 0.75rem 1rem; 
                           border: 1px solid #e5e7eb; 
                           border-radius: var(--border-radius);
                           font-size: 1rem;
                       " 
                       placeholder="Ej: Introducción a Variables en Python"
                       required>
            </div>

            <!-- Descripción -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    📄 Descripción
                </label>
                <textarea name="descripcion" 
                          rows="3"
                          style="
                              width: 100%; 
                              padding: 0.75rem 1rem; 
                              border: 1px solid #e5e7eb; 
                              border-radius: var(--border-radius);
                              font-size: 1rem;
                              resize: vertical;
                          " 
                          placeholder="Describe brevemente el contenido del video...">{{ old('descripcion', $video->descripcion) }}</textarea>
            </div>

            <!-- URL de YouTube -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    🔗 URL de YouTube *
                </label>
                <input type="url" 
                       name="url_youtube" 
                       value="{{ old('url_youtube', $video->url_youtube) }}"
                       style="
                           width: 100%; 
                           padding: 0.75rem 1rem; 
                           border: 1px solid #e5e7eb; 
                           border-radius: var(--border-radius);
                           font-size: 1rem;
                       " 
                       placeholder="https://www.youtube.com/watch?v=..."
                       required>
                <small style="color: #6b7280; font-size: 0.875rem;">
                    Pega la URL completa del video de YouTube
                </small>
            </div>

            <!-- Curso -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    📚 Curso *
                </label>
                <select name="curso_id" 
                        style="
                            width: 100%; 
                            padding: 0.75rem 1rem; 
                            border: 1px solid #e5e7eb; 
                            border-radius: var(--border-radius);
                            font-size: 1rem;
                            background: white;
                        " 
                        required>
                    <option value="">Selecciona un curso</option>
                    @foreach($cursosAsignados as $curso)
                        <option value="{{ $curso->id }}" 
                                {{ (old('curso_id', $video->curso_id) == $curso->id) ? 'selected' : '' }}>
                            {{ $curso->nombre }} - {{ $curso->ciclo->nombre_area ?? 'Sin ciclo' }}
                        </option>
                    @endforeach
                </select>
                @if($cursosAsignados->count() === 0)
                <p style="color: var(--warning-color); font-size: 0.875rem; margin-top: 0.5rem;">
                    ⚠️ No tienes cursos asignados para mover este video.
                </p>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <!-- Orden -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                        📋 Orden de Presentación *
                    </label>
                    <input type="number" 
                           name="orden" 
                           value="{{ old('orden', $video->orden) }}"
                           min="1"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           " 
                           required>
                    <small style="color: #6b7280; font-size: 0.875rem;">
                        Define el orden de aparición
                    </small>
                </div>

                <!-- Duración -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                        ⏱️ Duración (opcional)
                    </label>
                    <input type="text" 
                           name="duracion" 
                           value="{{ old('duracion', $video->duracion) }}"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           " 
                           placeholder="Ej: 15:30">
                    <small style="color: #6b7280; font-size: 0.875rem;">
                        Formato: mm:ss o hh:mm:ss
                    </small>
                </div>

                <!-- Estado -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                        👁️ Estado *
                    </label>
                    <select name="estado" 
                            style="
                                width: 100%; 
                                padding: 0.75rem 1rem; 
                                border: 1px solid #e5e7eb; 
                                border-radius: var(--border-radius);
                                font-size: 1rem;
                                background: white;
                            " 
                            required>
                        <option value="activo" {{ old('estado', $video->estado) === 'activo' ? 'selected' : '' }}>
                            🌍 Activo (visible para estudiantes)
                        </option>
                        <option value="inactivo" {{ old('estado', $video->estado) === 'inactivo' ? 'selected' : '' }}>
                            🔒 Inactivo (oculto)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Preview del Video Actual -->
            @if($video->video_id_youtube)
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    👁️ Video Actual
                </label>
                <div style="
                    border: 1px solid #e5e7eb; 
                    border-radius: var(--border-radius); 
                    padding: 1rem;
                    background: #f9fafb;
                ">
                    <div style="text-align: center;">
                        <img src="https://img.youtube.com/vi/{{ $video->video_id_youtube }}/mqdefault.jpg" 
                             alt="Video thumbnail actual"
                             style="max-width: 320px; width: 100%; border-radius: var(--border-radius); margin-bottom: 0.5rem;">
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">
                            Video actual: {{ $video->titulo }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Preview del Nuevo Video (si hay URL) -->
            <div id="video-preview" style="display: none;">
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    👁️ Vista Previa del Nuevo Video
                </label>
                <div style="
                    border: 1px solid #e5e7eb; 
                    border-radius: var(--border-radius); 
                    padding: 1rem;
                    background: #f0f9ff;
                ">
                    <div id="video-thumbnail" style="text-align: center;">
                        <!-- Thumbnail se cargará aquí -->
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <a href="{{ route('docente.videos.show', $video->id) }}" 
                   class="btn btn-secondary" 
                   style="padding: 0.75rem 2rem;">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-primary" 
                        style="padding: 0.75rem 2rem;"
                        {{ $cursosAsignados->count() === 0 ? 'disabled' : '' }}>
                    ✏️ Actualizar Video
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview del video cuando cambia la URL
document.querySelector('input[name="url_youtube"]').addEventListener('input', function() {
    const url = this.value;
    const previewDiv = document.getElementById('video-preview');
    const thumbnailDiv = document.getElementById('video-thumbnail');
    
    // Extraer ID del video de YouTube
    const videoId = extractYouTubeId(url);
    
    if (videoId && videoId !== '{{ $video->video_id_youtube }}') {
        // Mostrar thumbnail del nuevo video
        thumbnailDiv.innerHTML = `
            <img src="https://img.youtube.com/vi/${videoId}/mqdefault.jpg" 
                 alt="Nuevo video thumbnail"
                 style="max-width: 320px; width: 100%; border-radius: var(--border-radius); margin-bottom: 0.5rem;">
            <p style="color: #1d4ed8; font-size: 0.875rem; margin: 0;">
                Nuevo video detectado
            </p>
        `;
        previewDiv.style.display = 'block';
    } else {
        previewDiv.style.display = 'none';
    }
});

function extractYouTubeId(url) {
    const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
    const matches = url.match(regex);
    return matches ? matches[1] : null;
}
</script>
@endsection