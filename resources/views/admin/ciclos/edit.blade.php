@extends('layouts.app')

@section('title', 'Editar Ciclo - COKITO+ Academia')
@section('header', 'Editar Ciclo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Edición de Ciclo</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ciclos.update', $ciclo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="nombre_area" class="form-label">Nombre Área</label>
                <input type="text" name="nombre_area" id="nombre_area" class="form-control" value="{{ $ciclo->nombre_area }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="nivel_complejidad" class="form-label">Nivel de Complejidad</label>
                <input type="text" name="nivel_complejidad" id="nivel_complejidad" class="form-control" value="{{ $ciclo->nivel_complejidad }}">
            </div>
            <div class="form-group mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="activo" {{ $ciclo->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $ciclo->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="finalizado" {{ $ciclo->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Ciclo</button>
            <a href="{{ route('admin.ciclos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
