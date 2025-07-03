@extends('layouts.app')

@section('title', 'Subir Material - COKITO+ Academia')
@section('header', 'Subir Nuevo Material')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>📁 Subir Material de Curso</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('materiales.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="nombre_material" class="form-label">Nombre del Material</label>
                    <input 
                        type="text" 
                        id="nombre_material" 
                        name="nombre_material" 
                        class="form-input @error('nombre_material') error @enderror"
                        value="{{ old('nombre_material') }}" 
                        required
                        placeholder="Ej: Introducción a HTML - Capítulo 1"
                    >
                    @error('nombre_material')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="orden" class="form-label">Orden de Visualización</label>
                    <input 
                        type="number" 
                        id="orden" 
                        name="orden" 
                        class="form-input @error('orden') error @enderror"
                        value="{{ old('orden', 1) }}" 
                        min="1"
                        required
                        placeholder="1"
                    >
                    @error('orden')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="curso_estudiante_id" class="form-label">Curso</label>
                <select 
                    id="curso_estudiante_id" 
                    name="curso_estudiante_id" 
                    class="form-input @error('curso_estudiante_id') error @enderror"
                    required
                >
                    <option value="">Selecciona un curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}" {{ old('curso_estudiante_id') == $curso->id ? 'selected' : '' }}>
                            {{ $curso->nombre }} - {{ $curso->ciclo->nombre_area ?? 'Sin área' }}
                        </option>
                    @endforeach
                </select>
                @error('curso_estudiante_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="archivo" class="form-label">Archivo del Material</label>
                <div style="
                    border: 2px dashed #e5e7eb; 
                    border-radius: var(--border-radius);
                    padding: 3rem;
                    text-align: center;
                    background: #f9fafb;
                    transition: all 0.3s ease;
                " id="dropZone">
                    <input 
                        type="file" 
                        id="archivo" 
                        name="archivo" 
                        class="@error('archivo') error @enderror"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.mp4,.avi"
                        required
                        style="display: none;"
                    >
                    <div id="dropContent">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📎</div>
                        <p style="font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--dark-color);">
                            Arrastra tu archivo aquí o <button type="button" style="color: var(--primary-blue); background: none; border: none; text-decoration: underline; cursor: pointer;" onclick="document.getElementById('archivo').click()">haz clic para seleccionar</button>
                        </p>
                        <p style="font-size: 0.875rem; color: #6b7280;">
                            Formatos permitidos: PDF, DOC, DOCX, JPG, PNG, MP4, AVI (máx. 10MB)
                        </p>
                    </div>
                    <div id="filePreview" style="display: none;">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">✅</div>
                        <p id="fileName" style="font-weight: 600; color: var(--success-color);"></p>
                        <button type="button" style="
                            background: var(--danger-color); 
                            color: white; 
                            border: none; 
                            padding: 0.5rem 1rem; 
                            border-radius: var(--border-radius);
                            cursor: pointer;
                            margin-top: 1rem;
                        " onclick="clearFile()">Cambiar Archivo</button>
                    </div>
                </div>
                @error('archivo')
                    <div class="form-error" style="margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ url()->previous() }}" class="btn" style="background-color: #6b7280; color: white;">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    📁 Subir Material
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('archivo');
const dropContent = document.getElementById('dropContent');
const filePreview = document.getElementById('filePreview');
const fileName = document.getElementById('fileName');

// Prevenir comportamiento por defecto
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

// Highlight drop zone cuando arrastra archivo
['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

// Manejar drop
dropZone.addEventListener('drop', handleDrop, false);

// Manejar click en input
fileInput.addEventListener('change', handleFiles, false);

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight() {
    dropZone.style.borderColor = 'var(--primary-blue)';
    dropZone.style.backgroundColor = '#eff6ff';
}

function unhighlight() {
    dropZone.style.borderColor = '#e5e7eb';
    dropZone.style.backgroundColor = '#f9fafb';
}

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        showFilePreview(files[0]);
    }
}

function handleFiles() {
    const files = fileInput.files;
    if (files.length > 0) {
        showFilePreview(files[0]);
    }
}

function showFilePreview(file) {
    dropContent.style.display = 'none';
    filePreview.style.display = 'block';
    fileName.textContent = file.name;
}

function clearFile() {
    fileInput.value = '';
    dropContent.style.display = 'block';
    filePreview.style.display = 'none';
}
</script>
@endsection