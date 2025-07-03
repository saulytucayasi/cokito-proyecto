@extends('layouts.app')

@section('title', 'Detalles del Usuario - COKITO+ Academia')
@section('header', 'Detalles del Usuario')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Información del Usuario</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID:</strong> {{ $usuario->id }}
        </div>
        <div class="mb-3">
            <strong>Nombre de Usuario:</strong> {{ $usuario->usuario }}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> {{ $usuario->email }}
        </div>
        <div class="mb-3">
            <strong>Rol:</strong> {{ ucfirst($usuario->rol) }}
        </div>
        <div class="mb-3">
            <strong>Fecha de Creación:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="mb-3">
            <strong>Última Actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}
        </div>
        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Volver a la Lista</a>
    </div>
</div>
@endsection
