@extends('layouts.app')

@section('title', 'Gestión de Cursos - COKITO+ Academia')
@section('header', 'Gestión de Cursos')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Listado de Cursos</h3>
        <a href="{{ route('admin.cursos.create') }}" class="btn btn-primary">Nuevo Curso</a>
    </div>
    <div class="card-body">
        @if($cursos->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem;">ID</th>
                            <th style="text-align: left; padding: 0.75rem;">Nombre</th>
                            <th style="text-align: left; padding: 0.75rem;">Descripción</th>
                            <th style="text-align: left; padding: 0.75rem;">Nivel</th>
                            <th style="text-align: left; padding: 0.75rem;">Costo</th>
                            <th style="text-align: left; padding: 0.75rem;">Duración</th>
                            <th style="text-align: left; padding: 0.75rem;">Modalidad</th>
                            <th style="text-align: left; padding: 0.75rem;">Fecha Inicio</th>
                            <th style="text-align: left; padding: 0.75rem;">Fecha Fin</th>
                            <th style="text-align: left; padding: 0.75rem;">Ciclo</th>
                            <th style="text-align: left; padding: 0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem;">{{ $curso->id }}</td>
                            <td style="padding: 0.75rem;">{{ $curso->nombre }}</td>
                            <td style="padding: 0.75rem;">{{ Str::limit($curso->descripcion, 50) }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($curso->nivel) }}</td>
                            <td style="padding: 0.75rem;">{{ $curso->costo }}</td>
                            <td style="padding: 0.75rem;">{{ $curso->duracion }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($curso->modalidad) }}</td>
                            <td style="padding: 0.75rem;">{{ $curso->fecha_inicio->format('d/m/Y') }}</td>
                            <td style="padding: 0.75rem;">{{ $curso->fecha_fin->format('d/m/Y') }}</td>
                            <td style="padding: 0.75rem;">{{ $curso->ciclo->nombre ?? 'N/A' }}</td>
                            <td style="padding: 0.75rem;">
                                <a href="{{ route('admin.cursos.show', $curso->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.cursos.edit', $curso->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                @php
                                    $puedeEliminar = $curso->cursoEstudiantes->isEmpty() && 
                                                    $curso->videos->isEmpty() && 
                                                    $curso->materiales->isEmpty() && 
                                                    $curso->sesiones->isEmpty();
                                @endphp
                                @if($puedeEliminar)
                                    <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este curso?')">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay cursos registrados.</p>
        @endif
    </div>
</div>
@endsection
