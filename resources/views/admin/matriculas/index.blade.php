@extends('layouts.app')

@section('title', 'Gestión de Matrículas - COKITO+ Academia')
@section('header', 'Gestión de Matrículas')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Listado de Matrículas</h3>
        <a href="{{ route('admin.matriculas.create') }}" class="btn btn-primary">Nueva Matrícula</a>
    </div>
    <div class="card-body">
        @if($matriculas->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem;">ID</th>
                            <th style="text-align: left; padding: 0.75rem;">Estudiante</th>
                            <th style="text-align: left; padding: 0.75rem;">Ciclo</th>
                            <th style="text-align: left; padding: 0.75rem;">Fecha</th>
                            <th style="text-align: left; padding: 0.75rem;">Monto</th>
                            <th style="text-align: left; padding: 0.75rem;">Método Pago</th>
                            <th style="text-align: left; padding: 0.75rem;">Estado Pago</th>
                            <th style="text-align: left; padding: 0.75rem;">Nombre Pago</th>
                            <th style="text-align: left; padding: 0.75rem;">Trabajador</th>
                            <th style="text-align: left; padding: 0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matriculas as $matricula)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem;">{{ $matricula->id }}</td>
                            <td style="padding: 0.75rem;">{{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}</td>
                            <td style="padding: 0.75rem;">{{ $matricula->ciclo->nombre_area ?? 'N/A' }}</td>
                            <td style="padding: 0.75rem;">{{ $matricula->fecha->format('d/m/Y') }}</td>
                            <td style="padding: 0.75rem;">{{ $matricula->monto }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($matricula->metodo_pago) }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($matricula->estado_pago) }}</td>
                            <td style="padding: 0.75rem;">{{ $matricula->nombre_pago }}</td>
                            <td style="padding: 0.75rem;">{{ $matricula->trabajador->nombre ?? 'N/A' }} {{ $matricula->trabajador->apellido ?? '' }}</td>
                            <td style="padding: 0.75rem;">
                                <a href="{{ route('admin.matriculas.show', $matricula->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.matriculas.edit', $matricula->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.matriculas.destroy', $matricula->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta matrícula?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay matrículas registradas.</p>
        @endif
    </div>
</div>
@endsection
