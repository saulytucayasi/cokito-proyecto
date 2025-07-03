@extends('layouts.app')

@section('title', 'Detalle de Estudiante - COKITO+ Academia')
@section('header', 'Detalle de Estudiante')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Estudiante</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <p>{{ $estudiante->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <p>{{ $estudiante->nombre }}</p>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <p>{{ $estudiante->apellido }}</p>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <p>{{ $estudiante->dni }}</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <p>{{ $estudiante->email }}</p>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <p>{{ $estudiante->fecha_nacimiento ? $estudiante->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <p>{{ $estudiante->direccion }}</p>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <p>{{ $estudiante->telefono }}</p>
                    </div>
                    <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-primary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
