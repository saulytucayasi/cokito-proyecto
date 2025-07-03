@extends('layouts.app')

@section('title', 'Detalle de Curso - COKITO+ Academia')
@section('header', 'Detalle de Curso')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalles del Curso</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">ID:</label>
            <p class="form-control-static">{{ $curso->id }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nombre:</label>
            <p class="form-control-static">{{ $curso->nombre }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Descripción:</label>
            <p class="form-control-static">{{ $curso->descripcion }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nivel:</label>
            <p class="form-control-static">{{ ucfirst($curso->nivel) }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Costo:</label>
            <p class="form-control-static">{{ $curso->costo }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Duración:</label>
            <p class="form-control-static">{{ $curso->duracion }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Modalidad:</label>
            <p class="form-control-static">{{ ucfirst($curso->modalidad) }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Fecha de Inicio:</label>
            <p class="form-control-static">{{ $curso->fecha_inicio->format('d/m/Y') }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Fecha de Fin:</label>
            <p class="form-control-static">{{ $curso->fecha_fin->format('d/m/Y') }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Ciclo:</label>
            <p class="form-control-static">{{ $curso->ciclo->nombre_area ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('admin.cursos.index') }}" class="btn btn-primary">Volver a la Lista</a>
    </div>
</div>
@endsection
