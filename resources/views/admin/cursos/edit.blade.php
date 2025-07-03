@extends('layouts.app')

@section('title', 'Editar Curso - COKITO+ Academia')
@section('header', 'Editar Curso')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Edición de Curso</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.cursos.update', $curso->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $curso->nombre }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ $curso->descripcion }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="nivel" class="form-label">Nivel</label>
                <input type="text" name="nivel" id="nivel" class="form-control" value="{{ $curso->nivel }}">
            </div>
            <div class="form-group mb-3">
                <label for="costo" class="form-label">Costo</label>
                <input type="number" name="costo" id="costo" class="form-control" step="0.01" value="{{ $curso->costo }}">
            </div>
            <div class="form-group mb-3">
                <label for="duracion" class="form-label">Duración</label>
                <input type="text" name="duracion" id="duracion" class="form-control" value="{{ $curso->duracion }}" placeholder="Ej: 3 meses, 40 horas">
            </div>
            <div class="form-group mb-3">
                <label for="modalidad" class="form-label">Modalidad</label>
                <input type="text" name="modalidad" id="modalidad" class="form-control" value="{{ $curso->modalidad }}">
            </div>
            <div class="form-group mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $curso->fecha_inicio ? $curso->fecha_inicio->format('Y-m-d') : '' }}">
            </div>
            <div class="form-group mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $curso->fecha_fin ? $curso->fecha_fin->format('Y-m-d') : '' }}">
            </div>
            <div class="form-group mb-3">
                <label for="ciclo_id" class="form-label">Ciclo</label>
                <select name="ciclo_id" id="ciclo_id" class="form-control" required>
                    <option value="">Seleccione un ciclo</option>
                    @foreach($ciclos as $ciclo)
                        <option value="{{ $ciclo->id }}" {{ $curso->ciclo_id == $ciclo->id ? 'selected' : '' }}>{{ $ciclo->nombre_area }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Curso</button>
            <a href="{{ route('admin.cursos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
