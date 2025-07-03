@extends('layouts.app')

@section('title', 'Detalle de Matrícula - COKITO+ Academia')
@section('header', 'Detalle de Matrícula')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalles de la Matrícula</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">ID:</label>
            <p class="form-control-static">{{ $matricula->id }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Estudiante:</label>
            <p class="form-control-static">{{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Ciclo:</label>
            <p class="form-control-static">{{ $matricula->ciclo->nombre_area ?? 'N/A' }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Trabajador:</label>
            <p class="form-control-static">{{ $matricula->trabajador->nombre ?? 'N/A' }} {{ $matricula->trabajador->apellido ?? '' }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Fecha de Matrícula:</label>
            <p class="form-control-static">{{ $matricula->fecha->format('d/m/Y') }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Monto:</label>
            <p class="form-control-static">{{ $matricula->monto }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Método de Pago:</label>
            <p class="form-control-static">{{ ucfirst($matricula->metodo_pago) }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Estado de Pago:</label>
            <p class="form-control-static">{{ ucfirst($matricula->estado_pago) }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nombre del Pago:</label>
            <p class="form-control-static">{{ $matricula->nombre_pago }}</p>
        </div>
        <a href="{{ route('admin.matriculas.index') }}" class="btn btn-primary">Volver a la Lista</a>
    </div>
</div>
@endsection
