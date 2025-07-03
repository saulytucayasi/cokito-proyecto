@extends('layouts.app')

@section('title', 'Crear Trabajador - COKITO+ Academia')
@section('header', 'Crear Trabajador')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Creación de Trabajador</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.trabajadores.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="usuario_id" class="form-label">Usuario Asociado</label>
                <select name="usuario_id" id="usuario_id" class="form-control">
                    <option value="">Seleccione un usuario (opcional)</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->email }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Trabajador</button>
            <a href="{{ route('admin.trabajadores.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
