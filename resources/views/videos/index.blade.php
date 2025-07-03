@extends('layouts.app')

@section('title', 'Videos YouTube - COKITO+ Academia')
@section('header', 'Gestión de Videos')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">🎥 Videos de YouTube</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Gestiona todos los videos educativos</p>
    </div>
    <a href="{{ route('videos.create') }}" class="btn btn-primary">
        ➕ Agregar Video
    </a>
</div>

@if($videos->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
        @foreach($videos as $video)
        <div class="card" style="overflow: hidden;">
            <div style="position: relative; width: 100%; height: 200px; overflow: hidden;">
                <img 
                    src="{{ $video->thumbnail_url }}" 
                    alt="{{ $video->titulo }}"
                    style="width: 100%; height: 100%; object-fit: cover;"
                    onerror="this.src='https://via.placeholder.com/350x200/4f46e5/ffffff?text=Video+No+Disponible'"
                >
                <div style="
                    position: absolute; 
                    top: 0.5rem; 
                    right: 0.5rem; 
                    background: rgba(0,0,0,0.7); 
                    color: white; 
                    padding: 0.25rem 0.5rem; 
                    border-radius: var(--border-radius);
                    font-size: 0.75rem;
                ">
                    {{ $video->duracion ?? 'N/A' }}
                </div>
                <div style="
                    position: absolute; 
                    top: 50%; 
                    left: 50%; 
                    transform: translate(-50%, -50%);
                    background: rgba(255,255,255,0.9);
                    border-radius: 50%;
                    width: 60px;
                    height: 60px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                " onclick="window.open('{{ $video->url_youtube }}', '_blank')">
                    <div style="
                        width: 0; 
                        height: 0; 
                        border-left: 20px solid var(--primary-blue);
                        border-top: 12px solid transparent;
                        border-bottom: 12px solid transparent;
                        margin-left: 4px;
                    "></div>
                </div>
            </div>
            
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <h3 style="margin: 0 0 0.5rem 0; color: var(--dark-color); font-size: 1.1rem;">
                        {{ $video->titulo }}
                    </h3>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">
                        {{ $video->curso->nombre ?? 'Sin curso' }} - {{ $video->curso->ciclo->nombre_area ?? 'Sin área' }}
                    </p>
                </div>
                
                @if($video->descripcion)
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;">
                    {{ Str::limit($video->descripcion, 100) }}
                </p>
                @endif
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span style="
                        background: var(--accent-color);
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 9999px;
                        font-size: 0.75rem;
                        font-weight: 600;
                    ">
                        Orden: {{ $video->orden }}
                    </span>
                    <span style="
                        background: {{ $video->estado === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: var(--border-radius);
                        font-size: 0.75rem;
                        font-weight: 600;
                        text-transform: uppercase;
                    ">
                        {{ $video->estado }}
                    </span>
                </div>
                
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('videos.show', $video->id) }}" 
                       class="btn btn-primary" 
                       style="flex: 1; text-align: center; font-size: 0.875rem; padding: 0.5rem;">
                        👁️ Ver
                    </a>
                    <a href="{{ route('videos.edit', $video->id) }}" 
                       class="btn btn-warning" 
                       style="flex: 1; text-align: center; font-size: 0.875rem; padding: 0.5rem;">
                        ✏️ Editar
                    </a>
                    <form method="POST" action="{{ route('videos.destroy', $video->id) }}" 
                          style="flex: 1;" 
                          onsubmit="return confirm('¿Estás seguro de eliminar este video?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger" 
                                style="width: 100%; font-size: 0.875rem; padding: 0.5rem;">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top: 3rem; text-align: center;">
        {{ $videos->links() }}
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎥</div>
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">No hay videos disponibles</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">Aún no se han agregado videos de YouTube para los cursos</p>
            <a href="{{ route('videos.create') }}" class="btn btn-primary">
                ➕ Agregar Primer Video
            </a>
        </div>
    </div>
@endif
@endsection