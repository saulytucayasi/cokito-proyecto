@extends('layouts.app')

@section('title', 'Subir Material - COKITO+ Academia')
@section('header', 'Subir Material')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('docente.materiales.index') }}" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver a Materiales
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3>📁 Subir Nuevo Material</h3>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
            Agrega contenido educativo a tus cursos asignados
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

        <form action="{{ route('docente.materiales.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 1.5rem;">
            @csrf
            
            <!-- Título del Material -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    📝 Título del Material *
                </label>
                <input type="text" 
                       name="nombre_material" 
                       value="{{ old('nombre_material') }}"
                       style="
                           width: 100%; 
                           padding: 0.75rem 1rem; 
                           border: 1px solid #e5e7eb; 
                           border-radius: var(--border-radius);
                           font-size: 1rem;
                       " 
                       placeholder="Ej: Introducción a la Programación"
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
                          placeholder="Describe brevemente el contenido del material...">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Curso -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
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
                                {{ (old('curso_id') == $curso->id || request('curso_id') == $curso->id) ? 'selected' : '' }}>
                            {{ $curso->nombre }} - {{ $curso->ciclo->nombre_area ?? 'Sin ciclo' }}
                        </option>
                    @endforeach
                </select>
                @if($cursosAsignados->count() === 0)
                <p style="color: var(--warning-color); font-size: 0.875rem; margin-top: 0.5rem;">
                    ⚠️ No tienes cursos asignados para subir materiales.
                </p>
                @endif
            </div>

            <!-- Tipo de Material -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    📄 Tipo de Material *
                </label>
                <select name="tipo" 
                        style="
                            width: 100%; 
                            padding: 0.75rem 1rem; 
                            border: 1px solid #e5e7eb; 
                            border-radius: var(--border-radius);
                            font-size: 1rem;
                            background: white;
                        " 
                        required>
                    <option value="">Selecciona el tipo</option>
                    <option value="documento" {{ old('tipo') === 'documento' ? 'selected' : '' }}>📝 Documento</option>
                    <option value="presentacion" {{ old('tipo') === 'presentacion' ? 'selected' : '' }}>📊 Presentación</option>
                    <option value="imagen" {{ old('tipo') === 'imagen' ? 'selected' : '' }}>🖼️ Imagen</option>
                    <option value="video" {{ old('tipo') === 'video' ? 'selected' : '' }}>🎥 Video</option>
                    <option value="audio" {{ old('tipo') === 'audio' ? 'selected' : '' }}>🎵 Audio</option>
                    <option value="otro" {{ old('tipo') === 'otro' ? 'selected' : '' }}>📁 Otro</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
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
                        Define el orden de aparición en el curso
                    </small>
                </div>

                <!-- Estado -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        👁️ Visibilidad *
                    </label>
                    <select name="es_publico" 
                            style="
                                width: 100%; 
                                padding: 0.75rem 1rem; 
                                border: 1px solid #e5e7eb; 
                                border-radius: var(--border-radius);
                                font-size: 1rem;
                                background: white;
                            " 
                            required>
                        <option value="1" {{ old('es_publico', '1') === '1' ? 'selected' : '' }}>
                            🌍 Público (visible para estudiantes)
                        </option>
                        <option value="0" {{ old('es_publico') === '0' ? 'selected' : '' }}>
                            🔒 Privado (solo docentes)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Archivo -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    📎 Archivo del Material *
                </label>
                <div style="
                    border: 2px dashed #e5e7eb; 
                    border-radius: var(--border-radius); 
                    padding: 2rem; 
                    text-align: center;
                    background: #f9fafb;
                    transition: all 0.3s ease;
                " 
                ondrop="dropHandler(event);" 
                ondragover="dragOverHandler(event);"
                ondragenter="dragEnterHandler(event);"
                ondragleave="dragLeaveHandler(event);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📁</div>
                    <p style="margin-bottom: 1rem; color: #6b7280;">
                        Arrastra tu archivo aquí o <label for="material_file" style="color: var(--primary-blue); cursor: pointer; text-decoration: underline;">selecciona un archivo</label>
                    </p>
                    <input type="file" 
                           name="material_file" 
                           id="material_file"
                           style="display: none;"
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov"
                           required
                           onchange="fileSelected(this)">
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                        Formatos soportados: PDF, DOC, PPT, XLS, imágenes, videos (máx. 50MB)
                    </p>
                    <div id="file-info" style="margin-top: 1rem; display: none;">
                        <div style="
                            background: var(--success-color); 
                            color: white; 
                            padding: 0.5rem 1rem; 
                            border-radius: var(--border-radius);
                            display: inline-block;
                        ">
                            <span id="file-name"></span>
                            <button type="button" onclick="clearFile()" style="
                                background: none; 
                                border: none; 
                                color: white; 
                                margin-left: 0.5rem;
                                cursor: pointer;
                            ">✕</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- URL Externa (opcional) -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    🔗 URL Externa (opcional)
                </label>
                <input type="url" 
                       name="url_externa" 
                       value="{{ old('url_externa') }}"
                       style="
                           width: 100%; 
                           padding: 0.75rem 1rem; 
                           border: 1px solid #e5e7eb; 
                           border-radius: var(--border-radius);
                           font-size: 1rem;
                       " 
                       placeholder="https://...">
                <small style="color: #6b7280; font-size: 0.875rem;">
                    Link adicional relacionado con el material (opcional)
                </small>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <a href="{{ route('docente.materiales.index') }}" 
                   class="btn" 
                   style="background-color: #6b7280; color: white; padding: 0.75rem 2rem;">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-primary" 
                        style="padding: 0.75rem 2rem;"
                        {{ $cursosAsignados->count() === 0 ? 'disabled' : '' }}>
                    📁 Subir Material
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function dragOverHandler(ev) {
    ev.preventDefault();
    ev.currentTarget.style.borderColor = 'var(--primary-blue)';
    ev.currentTarget.style.backgroundColor = '#f0f9ff';
}

function dragEnterHandler(ev) {
    ev.preventDefault();
}

function dragLeaveHandler(ev) {
    ev.currentTarget.style.borderColor = '#e5e7eb';
    ev.currentTarget.style.backgroundColor = '#f9fafb';
}

function dropHandler(ev) {
    ev.preventDefault();
    ev.currentTarget.style.borderColor = '#e5e7eb';
    ev.currentTarget.style.backgroundColor = '#f9fafb';
    
    const files = ev.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('material_file').files = files;
        fileSelected(document.getElementById('archivo'));
    }
}

function fileSelected(input) {
    const file = input.files[0];
    if (file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-info').style.display = 'block';
    }
}

function clearFile() {
    document.getElementById('archivo').value = '';
    document.getElementById('file-info').style.display = 'none';
}
</script>
@endsection
