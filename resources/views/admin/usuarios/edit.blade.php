@extends('layouts.app')

@section('title', 'Editar Usuario - COKITO+ Academia')
@section('header', 'Editar Usuario')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Formulario de Edición de Usuario</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="{{ old('usuario', $usuario->usuario) }}" required>
                @error('usuario')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="">Seleccione un rol</option>
                    <option value="admin" {{ old('rol', $usuario->rol) == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="docente" {{ old('rol', $usuario->rol) == 'docente' ? 'selected' : '' }}>Docente</option>
                    <option value="secretaria" {{ old('rol', $usuario->rol) == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                    <option value="estudiante" {{ old('rol', $usuario->rol) == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                </select>
                @error('rol')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
