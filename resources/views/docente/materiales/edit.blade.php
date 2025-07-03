@extends('layouts.app')

@section('title', 'Editar Material - COKITO+ Academia')
@section('header', 'Editar Material')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('docente.materiales.index') }}" class="btn btn-secondary">
        ← Volver a Materiales
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3>✏️ Editar Material: {{ $material->nombre_material }}</h3>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
            Modifica la información del material
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

        <form action="{{ route('docente.materiales.update', $material->id) }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 1.5rem;">
            @csrf
            @method('PUT')
            
            <!-- Título del Material -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    📝 Título del Material *
                </label>
                <input type="text" 
                       name="nombre_material" 
                       value="{{ old('nombre_material', $material->nombre_material) }}"
                       style="
                           width: 100%; 
                           padding: 0.75rem 1rem; 
                           border: 1px solid #e5e7eb; 
                           border-radius: var(--border-radius);
                           font-size: 1rem;
                       " 
                       placeholder="Ej: Guía de HTML5 Completa"
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
                          placeholder="Describe brevemente el contenido del material...">{{ old('descripcion', $material->descripcion) }}</textarea>
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
                    <option value="documento" {{ old('tipo', $material->tipo) === 'documento' ? 'selected' : '' }}>📝 Documento</option>
                    <option value="presentacion" {{ old('tipo', $material->tipo) === 'presentacion' ? 'selected' : '' }}>📊 Presentación</option>
                    <option value="imagen" {{ old('tipo', $material->tipo) === 'imagen' ? 'selected' : '' }}>🖼️ Imagen</option>
                    <option value="video" {{ old('tipo', $material->tipo) === 'video' ? 'selected' : '' }}>🎥 Video</option>
                    <option value="audio" {{ old('tipo', $material->tipo) === 'audio' ? 'selected' : '' }}>🎵 Audio</option>
                    <option value="otro" {{ old('tipo', $material->tipo) === 'otro' ? 'selected' : '' }}>📁 Otro</option>
                </select>
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
                                {{ old('curso_id', $material->curso_id) == $curso->id ? 'selected' : '' }}>
                            {{ $curso->nombre }} - {{ $curso->ciclo->nombre_area ?? 'Sin ciclo' }}
                        </option>
                    @endforeach
                </select>
                @if($cursosAsignados->count() === 0)
                <p style="color: var(--warning-color); font-size: 0.875rem; margin-top: 0.5rem;">
                    ⚠️ No tienes cursos asignados para mover este material.
                </p>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <!-- Orden -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                        📋 Orden de Presentación *
                    </label>
                    <input type="number" 
                           name="orden" 
                           value="{{ old('orden', $material->orden) }}"
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

                <!-- Es Público -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                        👁️ Visibilidad
                    </label>
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 0;">
                        <input type="checkbox" 
                               name="es_publico" 
                               id="es_publico"
                               value="1"
                               {{ old('es_publico', $material->es_publico) ? 'checked' : '' }}
                               style="transform: scale(1.2);">
                        <label for="es_publico" style="color: var(--text-color); cursor: pointer;">
                            📢 Material público (visible para todos los estudiantes)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Archivo Actual -->
            @if($material->path_material)
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    📁 Archivo Actual
                </label>
                <div style="
                    border: 1px solid #e5e7eb; 
                    border-radius: var(--border-radius); 
                    padding: 1rem;
                    background: #f9fafb;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                ">
                    <div style="font-size: 2rem;">
                        @if($material->tipo === 'documento') 📝
                        @elseif($material->tipo === 'presentacion') 📊
                        @elseif($material->tipo === 'imagen') 🖼️
                        @elseif($material->tipo === 'video') 🎥
                        @elseif($material->tipo === 'audio') 🎵
                        @else 📁
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 600; color: var(--text-color);">
                            {{ basename($material->path_material) }}
                        </p>
                        <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">
                            Tipo: {{ ucfirst($material->tipo) }}
                        </p>
                    </div>
                    <a href="{{ Storage::url($material->path_material) }}" 
                       target="_blank" 
                       class="btn btn-info btn-sm">
                        👁️ Ver Actual
                    </a>
                </div>
            </div>
            @endif

            <!-- Nuevo Archivo -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem;">
                    📎 Nuevo Archivo (opcional)
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
                        Arrastra tu nuevo archivo aquí o <label for="material_file" style="color: var(--primary-blue); cursor: pointer; text-decoration: underline;">selecciona un archivo</label>
                    </p>
                    <input type="file" 
                           name="material_file" 
                           id="material_file"
                           style="display: none;"
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov"
                           onchange="fileSelected(this)">
                    <small style="color: #6b7280; font-size: 0.75rem;">
                        Deja vacío para mantener el archivo actual
                    </small>
                </div>
                
                <!-- Información del archivo seleccionado -->
                <div id="file-info" style="display: none; margin-top: 1rem; padding: 1rem; background: #f0f9ff; border-radius: var(--border-radius);">
                    <p style="margin: 0; color: var(--primary-blue); font-weight: 600;">
                        📎 Nuevo archivo seleccionado: <span id="file-name"></span>
                    </p>
                    <button type="button" onclick="clearFile()" style="color: var(--danger-color); background: none; border: none; text-decoration: underline; cursor: pointer; font-size: 0.875rem; margin-top: 0.5rem;">
                        ✕ Quitar archivo
                    </button>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <a href="{{ route('docente.materiales.index') }}" 
                   class="btn btn-secondary" 
                   style="padding: 0.75rem 2rem;">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-primary" 
                        style="padding: 0.75rem 2rem;"
                        {{ $cursosAsignados->count() === 0 ? 'disabled' : '' }}>
                    ✏️ Actualizar Material
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones para drag and drop
function dragOverHandler(ev) {
    ev.preventDefault();
}

function dragEnterHandler(ev) {
    ev.currentTarget.style.borderColor = 'var(--primary-blue)';
    ev.currentTarget.style.backgroundColor = '#f0f9ff';
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
        fileSelected(document.getElementById('material_file'));
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
    document.getElementById('material_file').value = '';
    document.getElementById('file-info').style.display = 'none';
}
</script>
@endsection