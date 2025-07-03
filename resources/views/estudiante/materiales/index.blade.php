@extends('layouts.app')

@section('title', 'Mis Materiales - COKITO+ Academia')
@section('header', 'Mis Materiales')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('estudiante.cursos.index') }}" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver a Mis Cursos
    </a>
</div>

<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $materiales->count() }}</div>
        <div class="stat-label">Materiales Disponibles</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $materiales->unique('curso_id')->count() }}</div>
        <div class="stat-label">Cursos con Materiales</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $materiales->where('tipo_archivo', 'like', '%pdf%')->count() }}</div>
        <div class="stat-label">Documentos PDF</div>
    </div>
</div>

@if($materiales->count() > 0)
    <div style="display: grid; gap: 1.5rem;">
        @foreach($materiales->groupBy('curso.nombre') as $cursoNombre => $materialesPorCurso)
        <div class="card">
            <div class="card-header">
                <h3>📚 {{ $cursoNombre }}</h3>
                <span style="font-size: 0.875rem; color: #6b7280;">
                    {{ $materialesPorCurso->count() }} material{{ $materialesPorCurso->count() != 1 ? 'es' : '' }}
                </span>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    @foreach($materialesPorCurso->sortBy('orden') as $material)
                    <div style="
                        display: flex; 
                        align-items: center; 
                        padding: 1.5rem; 
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius);
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                        transition: all 0.3s ease;
                    " onmouseover="this.style.boxShadow='var(--box-shadow)'" onmouseout="this.style.boxShadow='none'">
                        
                        <!-- Icono del tipo de archivo -->
                        <div style="
                            margin-right: 1.5rem; 
                            font-size: 2.5rem;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 60px;
                            height: 60px;
                            background-color: var(--primary-blue);
                            border-radius: var(--border-radius);
                            color: white;
                        ">
                            @if(str_contains($material->tipo_archivo, 'pdf'))
                                📄
                            @elseif(str_contains($material->tipo_archivo, 'image'))
                                🖼️
                            @elseif(str_contains($material->tipo_archivo, 'video'))
                                🎥
                            @elseif(str_contains($material->tipo_archivo, 'word') || str_contains($material->tipo_archivo, 'document'))
                                📝
                            @elseif(str_contains($material->tipo_archivo, 'excel') || str_contains($material->tipo_archivo, 'spreadsheet'))
                                📊
                            @elseif(str_contains($material->tipo_archivo, 'powerpoint') || str_contains($material->tipo_archivo, 'presentation'))
                                📋
                            @else
                                📄
                            @endif
                        </div>
                        
                        <!-- Información del material -->
                        <div style="flex: 1;">
                            <h4 style="margin-bottom: 0.5rem; color: var(--primary-blue);">
                                {{ $material->titulo }}
                            </h4>
                            
                            @if($material->descripcion)
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem; line-height: 1.5;">
                                {{ $material->descripcion }}
                            </p>
                            @endif
                            
                            <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280;">
                                <span>📅 Subido: {{ $material->created_at->format('d/m/Y') }}</span>
                                @if($material->tamaño_archivo)
                                <span>📁 Tamaño: {{ number_format($material->tamaño_archivo / 1024, 2) }} KB</span>
                                @endif
                                <span>📂 Tipo: {{ strtoupper(pathinfo($material->archivo_path, PATHINFO_EXTENSION)) }}</span>
                            </div>
                            
                            @if($material->orden)
                            <div style="margin-top: 0.5rem;">
                                <span class="btn btn-accent" style="
                                    padding: 0.25rem 0.5rem;
                                    border-radius: 4px;
                                    font-size: 0.75rem;
                                ">
                                    Orden: {{ $material->orden }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Botones de acción -->
                        <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-left: 1rem;">
                            <a href="{{ route('materiales.download', $material->id) }}" 
                               class="btn btn-primary" 
                               style="font-size: 0.875rem; padding: 0.5rem 1rem; white-space: nowrap;">
                                📥 Descargar
                            </a>
                            @if($material->url_externa)
                            <a href="{{ $material->url_externa }}" 
                               target="_blank"
                               class="btn btn-accent" 
                               style="font-size: 0.875rem; padding: 0.5rem 1rem; white-space: nowrap;">
                                🔗 Ver Online
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📁</div>
            <h3 style="margin-bottom: 1rem; color: var(--primary-blue);">No hay materiales disponibles</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Aún no tienes acceso a materiales de estudio. Los materiales aparecerán aquí cuando tus docentes los suban.
            </p>
            <a href="{{ route('estudiante.cursos.index') }}" class="btn btn-primary">
                📚 Ver Mis Cursos
            </a>
        </div>
    </div>
@endif
@endsection
