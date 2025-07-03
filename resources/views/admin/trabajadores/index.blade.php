@extends('layouts.app')

@section('title', 'Gestión de Trabajadores - COKITO+ Academia')
@section('header', 'Gestión de Trabajadores')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Listado de Trabajadores</h3>
        <a href="{{ route('admin.trabajadores.create') }}" class="btn btn-primary">Nuevo Trabajador</a>
    </div>
    <div class="card-body">
        @if($trabajadores->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem;">ID</th>
                            <th style="text-align: left; padding: 0.75rem;">Nombre</th>
                            <th style="text-align: left; padding: 0.75rem;">Correo</th>
                            <th style="text-align: left; padding: 0.75rem;">Teléfono</th>
                            <th style="text-align: left; padding: 0.75rem;">Estado</th>
                            <th style="text-align: left; padding: 0.75rem;">Usuario Asociado</th>
                            <th style="text-align: left; padding: 0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trabajadores as $trabajador)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem;">{{ $trabajador->id }}</td>
                            <td style="padding: 0.75rem;">{{ $trabajador->nombre }}</td>
                            <td style="padding: 0.75rem;">{{ $trabajador->correo }}</td>
                            <td style="padding: 0.75rem;">{{ $trabajador->telefono ?? 'N/A' }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($trabajador->estado) }}</td>
                            <td style="padding: 0.75rem;">
                                @if($trabajador->usuario)
                                    {{ $trabajador->usuario->email }}
                                @else
                                    Sin usuario
                                @endif
                            </td>
                            <td style="padding: 0.75rem;">
                                <a href="{{ route('admin.trabajadores.show', $trabajador->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.trabajadores.edit', $trabajador->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                @php
                                    $puedeEliminar = $trabajador->cursosAsignados->isEmpty() && 
                                                    $trabajador->matriculas->isEmpty() && 
                                                    $trabajador->materialesSubidos->isEmpty();
                                @endphp
                                @if($puedeEliminar)
                                    <form action="{{ route('admin.trabajadores.destroy', $trabajador->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este trabajador?')">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay trabajadores registrados.</p>
        @endif
    </div>
</div>
@endsection
