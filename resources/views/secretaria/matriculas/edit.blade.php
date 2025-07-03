@extends('layouts.app')

@section('title', 'Editar Matrícula - COKITO+ Academia')
@section('header', 'Editar Matrícula')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulario de Edición de Matrícula</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('secretaria.matriculas.update', $matricula->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="estudiante_id" class="form-label">Estudiante</label>
                <select name="estudiante_id" id="estudiante_id" class="form-control" required>
                    <option value="">Seleccione un estudiante</option>
                    @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}" {{ $matricula->estudiante_id == $estudiante->id ? 'selected' : '' }}>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="ciclo_id" class="form-label">Ciclo</label>
                <select name="ciclo_id" id="ciclo_id" class="form-control" required>
                    <option value="">Seleccione un ciclo</option>
                    @foreach($ciclos as $ciclo)
                        <option value="{{ $ciclo->id }}" {{ $matricula->ciclo_id == $ciclo->id ? 'selected' : '' }}>{{ $ciclo->nombre_area }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="trabajador_id" class="form-label">Trabajador</label>
                <select name="trabajador_id" id="trabajador_id" class="form-control" required>
                    <option value="">Seleccione un trabajador</option>
                    @foreach($trabajadores as $trabajador)
                        <option value="{{ $trabajador->id }}" {{ $matricula->trabajador_id == $trabajador->id ? 'selected' : '' }}>{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="fecha" class="form-label">Fecha de Matrícula</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $matricula->fecha->format('Y-m-d') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" name="monto" id="monto" class="form-control" step="0.01" value="{{ $matricula->monto }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <input type="text" name="metodo_pago" id="metodo_pago" class="form-control" value="{{ $matricula->metodo_pago }}">
            </div>
            <div class="form-group mb-3">
                <label for="estado_pago" class="form-label">Estado de Pago</label>
                <select name="estado_pago" id="estado_pago" class="form-control" required>
                    <option value="pendiente" {{ $matricula->estado_pago == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="pagado" {{ $matricula->estado_pago == 'pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="vencido" {{ $matricula->estado_pago == 'vencido' ? 'selected' : '' }}>Vencido</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="nombre_pago" class="form-label">Nombre del Pago</label>
                <input type="text" name="nombre_pago" id="nombre_pago" class="form-control" value="{{ $matricula->nombre_pago }}">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Matrícula</button>
            <a href="{{ route('secretaria.matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
