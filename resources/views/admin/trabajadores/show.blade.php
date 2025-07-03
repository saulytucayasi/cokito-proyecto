@extends('layouts.app')

@section('title', 'Detalle de Trabajador - COKITO+ Academia')
@section('header', 'Detalle de Trabajador')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalles del Trabajador</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">ID:</label>
            <p class="form-control-static">{{ $trabajador->id }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nombre:</label>
            <p class="form-control-static">{{ $trabajador->nombre }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Correo:</label>
            <p class="form-control-static">{{ $trabajador->correo }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Teléfono:</label>
            <p class="form-control-static">{{ $trabajador->telefono ?? 'N/A' }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Estado:</label>
            <p class="form-control-static">{{ ucfirst($trabajador->estado) }}</p>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Usuario Asociado:</label>
            <p class="form-control-static">
                @if($trabajador->usuario)
                    {{ $trabajador->usuario->email }}
                @else
                    Sin usuario
                @endif
            </p>
        </div>
        <a href="{{ route('admin.trabajadores.index') }}" class="btn btn-primary">Volver a la Lista</a>
    </div>
</div>
@endsection
