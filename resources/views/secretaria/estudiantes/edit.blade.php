@extends('layouts.app')

@section('title', 'Editar Estudiante - COKITO+ Academia')
@section('header', 'Editar Estudiante')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Edición de Estudiante</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('secretaria.estudiantes.update', $estudiante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $estudiante->nombre }}" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" value="{{ $estudiante->apellido }}" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" id="dni" class="form-control" value="{{ $estudiante->dni }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $estudiante->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ $estudiante->fecha_nacimiento ? $estudiante->fecha_nacimiento->format('Y-m-d') : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $estudiante->telefono }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Estudiante</button>
                        <a href="{{ route('secretaria.estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
