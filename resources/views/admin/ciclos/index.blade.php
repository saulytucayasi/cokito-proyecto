@extends('layouts.app')

@section('title', 'Gestión de Ciclos - COKITO+ Academia')
@section('header', 'Gestión de Ciclos')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Listado de Ciclos</h3>
        <a href="{{ route('admin.ciclos.create') }}" class="btn btn-primary">Nuevo Ciclo</a>
    </div>
    <div class="card-body">
        @if($ciclos->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem;">ID</th>
                            <th style="text-align: left; padding: 0.75rem;">Nombre Área</th>
                            <th style="text-align: left; padding: 0.75rem;">Nivel Complejidad</th>
                            <th style="text-align: left; padding: 0.75rem;">Estado</th>
                            <th style="text-align: left; padding: 0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ciclos as $ciclo)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem;">{{ $ciclo->id }}</td>
                            <td style="padding: 0.75rem;">{{ $ciclo->nombre_area }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($ciclo->nivel_complejidad) }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($ciclo->estado) }}</td>
                            <td style="padding: 0.75rem;">
                                <a href="{{ route('admin.ciclos.show', $ciclo->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.ciclos.edit', $ciclo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                @php
                                    $puedeEliminar = $ciclo->cursos->isEmpty() && $ciclo->matriculas->isEmpty();
                                @endphp
                                @if($puedeEliminar)
                                    <form action="{{ route('admin.ciclos.destroy', $ciclo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este ciclo?')">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay ciclos registrados.</p>
        @endif
    </div>
</div>
@endsection
