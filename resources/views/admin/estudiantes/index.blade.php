@extends('layouts.app')

@section('title', 'Gestión de Estudiantes - COKITO+ Academia')
@section('header', 'Gestión de Estudiantes')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Listado de Estudiantes</h3>
        <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-primary">Nuevo Estudiante</a>
    </div>
    <div class="card-body">
        @if($estudiantes->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem;">ID</th>
                            <th style="text-align: left; padding: 0.75rem;">Nombre</th>
                            <th style="text-align: left; padding: 0.75rem;">Apellido</th>
                            <th style="text-align: left; padding: 0.75rem;">DNI</th>
                            <th style="text-align: left; padding: 0.75rem;">Email</th>
                            <th style="text-align: left; padding: 0.75rem;">Teléfono</th>
                            <th style="text-align: left; padding: 0.75rem;">Estado Matrícula</th>
                            <th style="text-align: left; padding: 0.75rem;">Fecha de Registro</th>
                            <th style="text-align: left; padding: 0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $estudiante)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem;">{{ $estudiante->id }}</td>
                            <td style="padding: 0.75rem;">{{ $estudiante->nombre }}</td>
                            <td style="padding: 0.75rem;">{{ $estudiante->apellido }}</td>
                            <td style="padding: 0.75rem;">{{ $estudiante->dni }}</td>
                            <td style="padding: 0.75rem;">{{ $estudiante->correo }}</td>
                            <td style="padding: 0.75rem;">{{ $estudiante->telefono }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($estudiante->estado_matricula) }}</td>
                            <td style="padding: 0.75rem;">{{ $estudiante->fecha_registro ? $estudiante->fecha_registro->format('d/m/Y') : 'No definida' }}</td>
                            <td style="padding: 0.75rem;">
                                <a href="{{ route('admin.estudiantes.show', $estudiante->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.estudiantes.edit', $estudiante->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.estudiantes.destroy', $estudiante->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este estudiante?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay estudiantes registrados.</p>
        @endif
    </div>
</div>
@endsection
