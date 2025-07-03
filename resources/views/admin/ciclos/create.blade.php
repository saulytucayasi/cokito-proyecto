@extends('layouts.app')

@section('title', 'Crear Ciclo - COKITO+ Academia')
@section('header', 'Crear Ciclo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Creación de Ciclo</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ciclos.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nombre_area" class="form-label">Nombre Área</label>
                <input type="text" name="nombre_area" id="nombre_area" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="nivel_complejidad" class="form-label">Nivel de Complejidad</label>
                <input type="text" name="nivel_complejidad" id="nivel_complejidad" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Ciclo</button>
            <a href="{{ route('admin.ciclos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
