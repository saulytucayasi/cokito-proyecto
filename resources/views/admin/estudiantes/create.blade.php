@extends('layouts.app')

@section('title', 'Crear Estudiante - COKITO+ Academia')
@section('header', 'Crear Estudiante')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Creación de Estudiante</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.estudiantes.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" id="dni" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="correo">Email</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Estudiante</button>
                        <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
