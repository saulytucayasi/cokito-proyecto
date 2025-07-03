@extends('layouts.app')

@section('title', 'Detalle de Material - COKITO+ Academia')
@section('header', 'Detalle de Material')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalles del Material</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">ID:</label>
            <p class="form-control-static">{{ $material->id }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nombre del Material:</label>
            <p class="form-control-static">{{ $material->nombre_material }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Orden:</label>
            <p class="form-control-static">{{ $material->orden }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Curso - Estudiante:</label>
            <p class="form-control-static">{{ $material->cursoEstudiante?->curso?->nombre ?? 'N/A' }} - {{ $material->cursoEstudiante?->estudiante?->nombre ?? 'N/A' }} {{ $material->cursoEstudiante?->estudiante?->apellido ?? '' }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Archivo:</label>
            <p class="form-control-static">
                @if($material->path_material)
                    <a href="{{ Storage::url($material->path_material) }}" target="_blank">{{ basename($material->path_material) }}</a>
                @else
                    N/A
                @endif
            </p>
        </div>
        <a href="{{ route('docente.materiales.index') }}" class="btn btn-primary">Volver a la Lista</a>
    </div>
</div>
@endsection
