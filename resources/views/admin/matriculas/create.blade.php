@extends('layouts.app')

@section('title', 'Crear Matrícula - COKITO+ Academia')
@section('header', 'Crear Matrícula')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Creación de Matrícula</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.matriculas.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="estudiante_id" class="form-label">Estudiante</label>
                <select name="estudiante_id" id="estudiante_id" class="form-control" required>
                    <option value="">Seleccione un estudiante</option>
                    @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>
                    @endforeach
                </select>
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
            <div class="form-group mb-3">
                <label for="trabajador_id" class="form-label">Trabajador</label>
                <select name="trabajador_id" id="trabajador_id" class="form-control" required>
                    <option value="">Seleccione un trabajador</option>
                    @foreach($trabajadores as $trabajador)
                        <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="fecha" class="form-label">Fecha de Matrícula</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" name="monto" id="monto" class="form-control" step="0.01" required>
            </div>
            <div class="form-group mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <input type="text" name="metodo_pago" id="metodo_pago" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="estado_pago" class="form-label">Estado de Pago</label>
                <select name="estado_pago" id="estado_pago" class="form-control" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="pagado">Pagado</option>
                    <option value="vencido">Vencido</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="nombre_pago" class="form-label">Nombre del Pago</label>
                <input type="text" name="nombre_pago" id="nombre_pago" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Matrícula</button>
            <a href="{{ route('admin.matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
