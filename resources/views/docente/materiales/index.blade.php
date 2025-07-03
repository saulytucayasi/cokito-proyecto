@extends('layouts.app')

@section('title', 'Gestión de Materiales - COKITO+ Academia')
@section('header', 'Gestión de Materiales')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">📁 Mis Materiales Educativos</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Administra todo el contenido educativo de tus cursos</p>
    </div>
    <a href="{{ route('docente.materiales.create') }}" class="btn btn-primary">
        ➕ Subir Material
    </a>
</div>

<!-- Estadísticas de materiales -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->materiales->count(); }) }}</div>
        <div class="stat-label">Total Materiales</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->count() }}</div>
        <div class="stat-label">Cursos Asignados</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->materiales->where('tipo', 'documento')->count(); }) }}</div>
        <div class="stat-label">Documentos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $cursosAsignados->sum(function($curso) { return $curso->videos->count(); }) }}</div>
        <div class="stat-label">Videos</div>
    </div>
</div>

@if($cursosAsignados->count() > 0)
    @foreach($cursosAsignados as $curso)
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header" style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0;">📚 {{ $curso->nombre }}</h3>
                    <p style="margin: 0.25rem 0 0 0; opacity: 0.9; font-size: 0.875rem;">
                        Ciclo: {{ $curso->ciclo->nombre_area ?? 'Sin ciclo' }}
                    </p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.875rem; opacity: 0.9;">Materiales: {{ $curso->materiales->count() }}</div>
                    <div style="font-size: 0.875rem; opacity: 0.9;">Videos: {{ $curso->videos->count() }}</div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if($curso->materiales->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
                    @foreach($curso->materiales as $material)
                    <div style="
                        border: 1px solid #e5e7eb; 
                        border-radius: var(--border-radius); 
                        padding: 1rem;
                        background: #f8fafc;
                        transition: all 0.3s ease;
                    " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" 
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <div style="
                                width: 40px; 
                                height: 40px; 
                                border-radius: 8px; 
                                background: var(--accent-color);
                                display: flex; 
                                align-items: center; 
                                justify-content: center; 
                                color: white;
                                font-size: 1.25rem;
                            ">
                                @switch($material->tipo)
                                    @case('documento')
                                        📄
                                        @break
                                    @case('video')
                                        🎥
                                        @break
                                    @case('imagen')
                                        🖼️
                                        @break
                                    @default
                                        📁
                                @endswitch
                            </div>
                            <div style="flex: 1;">
                                <h4 style="margin: 0 0 0.25rem 0; font-size: 0.875rem; line-height: 1.25;">
                                    {{ $material->nombre_material }}
                                </h4>
                                <div style="font-size: 0.75rem; color: #6b7280;">
                                    Orden: {{ $material->orden }} • 
                                    {{ $material->es_publico ? 'Público' : 'Privado' }}
                                </div>
                            </div>
                        </div>
                        
                        @if($material->descripcion)
                        <p style="font-size: 0.75rem; color: #6b7280; margin-bottom: 1rem; line-height: 1.4;">
                            {{ Str::limit($material->descripcion, 80) }}
                        </p>
                        @endif
                        
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ Storage::url($material->path_material) }}" 
                               target="_blank" 
                               class="btn" 
                               style="background-color: var(--success-color); color: white; font-size: 0.75rem; padding: 0.5rem 0.75rem;">
                                📥 Descargar
                            </a>
                            <a href="{{ route('docente.materiales.edit', $material) }}" 
                               class="btn btn-warning" 
                               style="font-size: 0.75rem; padding: 0.5rem 0.75rem;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('docente.materiales.destroy', $material) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este material?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger" 
                                        style="font-size: 0.75rem; padding: 0.5rem 0.75rem;">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: #6b7280;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📁</div>
                    <p>No hay materiales en este curso aún</p>
                    <a href="{{ route('docente.materiales.create') }}?curso_id={{ $curso->id }}" class="btn btn-primary" style="margin-top: 1rem;">
                        Subir primer material
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endforeach
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
            <h3 style="color: var(--dark-color); margin-bottom: 1rem;">No tienes cursos asignados</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Contacta al administrador para que te asigne cursos y puedas empezar a subir materiales.
            </p>
        </div>
    </div>
@endif

@endsection