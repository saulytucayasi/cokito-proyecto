@extends('layouts.app')

@section('title', 'Agregar Video - COKITO+ Academia')
@section('header', 'Agregar Video')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('docente.videos.index') }}" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver a Videos
    </a>
</div>

<div class="card">
    <div class="card-header">
        @if(request('curso_id'))
            @php
                $cursoSeleccionado = $cursosAsignados->find(request('curso_id'));
            @endphp
            @if($cursoSeleccionado)
                <h3>🎥 Agregar Video a "{{ $cursoSeleccionado->nombre }}"</h3>
                <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
                    Agrega un nuevo video de YouTube a este curso específico
                </p>
            @else
                <h3>🎥 Agregar Nuevo Video</h3>
                <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
                    Agrega videos de YouTube a tus cursos asignados
                </p>
            @endif
        @else
            <h3>🎥 Agregar Nuevo Video</h3>
            <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
                Agrega videos de YouTube a tus cursos asignados
            </p>
        @endif
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

        <form action="{{ route('docente.videos.store') }}" method="POST" style="display: grid; gap: 1.5rem;">
            @csrf
            
            <!-- Título del Video -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    🎬 Título del Video *
                </label>
                <input type="text" 
                       name="titulo" 
                       value="{{ old('titulo') }}"
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
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
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
                          placeholder="Describe brevemente el contenido del video...">{{ old('descripcion') }}</textarea>
            </div>

            <!-- URL de YouTube -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    🔗 URL de YouTube *
                </label>
                <input type="url" 
                       name="url_youtube" 
                       value="{{ old('url_youtube') }}"
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
            @if(request('curso_id'))
                @php
                    $cursoSeleccionado = $cursosAsignados->find(request('curso_id'));
                @endphp
                @if($cursoSeleccionado)
                    <div style="
                        padding: 1rem; 
                        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                        border: 1px solid #0ea5e9;
                        border-radius: var(--border-radius);
                        margin-bottom: 0.5rem;
                    ">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1.5rem;">📚</span>
                            <div>
                                <h4 style="margin: 0; color: var(--primary-blue);">{{ $cursoSeleccionado->nombre }}</h4>
                                <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">
                                    Ciclo: {{ $cursoSeleccionado->ciclo->nombre_area ?? 'Sin ciclo' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="curso_id" value="{{ request('curso_id') }}">
                    <p style="color: #059669; font-size: 0.875rem; margin-bottom: 1rem;">
                        ✓ Video se agregará al curso seleccionado arriba
                    </p>
                @else
                    <div style="color: var(--danger-color); padding: 1rem; background: #fef2f2; border-radius: var(--border-radius); margin-bottom: 1rem;">
                        ⚠️ El curso seleccionado no es válido o no tienes permisos para agregar videos a él.
                    </div>
                @endif
            @else
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
                                    {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }} - {{ $curso->ciclo->nombre_area ?? 'Sin ciclo' }}
                            </option>
                        @endforeach
                    </select>
                    @if($cursosAsignados->count() === 0)
                    <p style="color: var(--warning-color); font-size: 0.875rem; margin-top: 0.5rem;">
                        ⚠️ No tienes cursos asignados para agregar videos.
                    </p>
                    @endif
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <!-- Orden -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        📋 Orden de Presentación *
                    </label>
                    <input type="number" 
                           name="orden" 
                           value="{{ old('orden', 1) }}"
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
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        ⏱️ Duración (opcional)
                    </label>
                    <input type="text" 
                           name="duracion" 
                           value="{{ old('duracion') }}"
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
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
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
                        <option value="activo" {{ old('estado', 'activo') === 'activo' ? 'selected' : '' }}>
                            🌍 Activo (visible para estudiantes)
                        </option>
                        <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>
                            🔒 Inactivo (oculto)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Preview del Video (si hay URL) -->
            <div id="video-preview" style="display: none;">
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    👁️ Vista Previa
                </label>
                <div style="
                    border: 1px solid #e5e7eb; 
                    border-radius: var(--border-radius); 
                    padding: 1rem;
                    background: #f9fafb;
                ">
                    <div id="video-thumbnail" style="text-align: center;">
                        <!-- Thumbnail se cargará aquí -->
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <a href="{{ route('docente.videos.index') }}" 
                   class="btn" 
                   style="background-color: #6b7280; color: white; padding: 0.75rem 2rem;">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-primary" 
                        style="padding: 0.75rem 2rem;"
                        {{ $cursosAsignados->count() === 0 ? 'disabled' : '' }}>
                    🎥 Agregar Video
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
    
    if (videoId) {
        // Mostrar thumbnail
        thumbnailDiv.innerHTML = `
            <img src="https://img.youtube.com/vi/${videoId}/mqdefault.jpg" 
                 alt="Video thumbnail"
                 style="max-width: 320px; width: 100%; border-radius: var(--border-radius);">
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