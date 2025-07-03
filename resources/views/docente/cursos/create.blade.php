@extends('layouts.app')

@section('title', 'Crear Curso - COKITO+ Academia')
@section('header', 'Crear Curso')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Creación de Curso</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('docente.cursos.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="nivel" class="form-label">Nivel</label>
                <input type="text" name="nivel" id="nivel" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="costo" class="form-label">Costo</label>
                <input type="number" name="costo" id="costo" class="form-control" step="0.01">
            </div>
            <div class="form-group mb-3">
                <label for="duracion" class="form-label">Duración</label>
                <input type="text" name="duracion" id="duracion" class="form-control" placeholder="Ej: 3 meses, 40 horas">
            </div>
            <div class="form-group mb-3">
                <label for="modalidad" class="form-label">Modalidad</label>
                <input type="text" name="modalidad" id="modalidad" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="ciclo_id" class="form-label">Ciclo</label>
                <select name="ciclo_id" id="ciclo_id" class="form-control" required>
                    <option value="">Seleccione un ciclo</option>
                    @foreach($ciclos as $ciclo)
                        <option value="{{ $ciclo->id }}">{{ $ciclo->nombre_area }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Curso</button>
            <a href="{{ route('docente.cursos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
