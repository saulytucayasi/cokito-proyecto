@extends('layouts.app')

@section('title', 'Detalle de Ciclo - COKITO+ Academia')
@section('header', 'Detalle de Ciclo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalles del Ciclo</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">ID:</label>
            <p class="form-control-static">{{ $ciclo->id }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nombre Área:</label>
            <p class="form-control-static">{{ $ciclo->nombre_area }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nivel de Complejidad:</label>
            <p class="form-control-static">{{ ucfirst($ciclo->nivel_complejidad) }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Estado:</label>
            <p class="form-control-static">{{ ucfirst($ciclo->estado) }}</p>
        </div>
        <a href="{{ route('admin.ciclos.index') }}" class="btn btn-primary">Volver a la Lista</a>
    </div>
</div>
@endsection
