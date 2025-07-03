@extends('layouts.app')

@section('title', 'Materiales - COKITO+ Academia')
@section('header', 'Gestión de Materiales')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">📁 Materiales del Curso</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Gestiona todos los materiales de aprendizaje</p>
    </div>
    <a href="{{ route('materiales.create') }}" class="btn btn-primary">
        ➕ Subir Material
    </a>
</div>

@if($materiales->count() > 0)
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                            <th style="text-align: left; padding: 1rem; font-weight: 600;">Material</th>
                            <th style="text-align: left; padding: 1rem; font-weight: 600;">Curso</th>
                            <th style="text-align: left; padding: 1rem; font-weight: 600;">Orden</th>
                            <th style="text-align: left; padding: 1rem; font-weight: 600;">Tipo</th>
                            <th style="text-align: left; padding: 1rem; font-weight: 600;">Subido</th>
                            <th style="text-align: center; padding: 1rem; font-weight: 600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiales as $material)
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: background-color 0.3s ease;">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="
                                        width: 40px; 
                                        height: 40px; 
                                        border-radius: var(--border-radius);
                                        background: var(--primary-blue);
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 1.2rem;
                                    ">
                                        @php
                                            $extension = pathinfo($material->path_material, PATHINFO_EXTENSION);
                                            $icon = match(strtolower($extension)) {
                                                'pdf' => '📄',
                                                'doc', 'docx' => '📝',
                                                'jpg', 'jpeg', 'png' => '🖼️',
                                                'mp4', 'avi' => '🎥',
                                                default => '📎'
                                            };
                                        @endphp
                                        {{ $icon }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--dark-color);">
                                            {{ $material->nombre_material }}
                                        </div>
                                        <div style="font-size: 0.875rem; color: #6b7280;">
                                            {{ basename($material->path_material) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <div>
                                    <div style="font-weight: 500; color: var(--dark-color);">
                                        {{ $material->cursoEstudiante->curso->nombre ?? 'Sin curso' }}
                                    </div>
                                    <div style="font-size: 0.875rem; color: #6b7280;">
                                        {{ $material->cursoEstudiante->curso->ciclo->nombre_area ?? 'Sin área' }}
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="
                                    background: var(--accent-color);
                                    color: white;
                                    padding: 0.25rem 0.75rem;
                                    border-radius: 9999px;
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                ">
                                    #{{ $material->orden }}
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="
                                    background: {{ $extension === 'pdf' ? '#ef4444' : ($extension === 'mp4' || $extension === 'avi' ? '#8b5cf6' : '#10b981') }};
                                    color: white;
                                    padding: 0.25rem 0.75rem;
                                    border-radius: var(--border-radius);
                                    font-size: 0.75rem;
                                    font-weight: 600;
                                    text-transform: uppercase;
                                ">
                                    {{ strtoupper($extension) }}
                                </span>
                            </td>
                            <td style="padding: 1rem; color: #6b7280; font-size: 0.875rem;">
                                {{ $material->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('materiales.download', $material->id) }}" 
                                       class="btn" 
                                       style="
                                           background: var(--success-color); 
                                           color: white; 
                                           padding: 0.5rem 0.75rem; 
                                           font-size: 0.875rem;
                                           text-decoration: none;
                                       "
                                       title="Descargar">
                                        ⬇️
                                    </a>
                                    
                                    <form method="POST" action="{{ route('materiales.destroy', $material->id) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este material?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn" 
                                                style="
                                                    background: var(--danger-color); 
                                                    color: white; 
                                                    padding: 0.5rem 0.75rem; 
                                                    font-size: 0.875rem;
                                                "
                                                title="Eliminar">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        {{ $materiales->links() }}
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📁</div>
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">No hay materiales disponibles</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">Aún no se han subido materiales para los cursos</p>
            <a href="{{ route('materiales.create') }}" class="btn btn-primary">
                ➕ Subir Primer Material
            </a>
        </div>
    </div>
@endif

<style>
tbody tr:hover {
    background-color: #f8fafc !important;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

.pagination a,
.pagination span {
    padding: 0.5rem 0.75rem;
    border: 1px solid #e5e7eb;
    color: var(--dark-color);
    text-decoration: none;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
}

.pagination a:hover {
    background-color: var(--primary-blue);
    color: white;
    border-color: var(--primary-blue);
}

.pagination .active span {
    background-color: var(--primary-blue);
    color: white;
    border-color: var(--primary-blue);
}
</style>
@endsection