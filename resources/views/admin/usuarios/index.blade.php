@extends('layouts.app')

@section('title', 'Gestión de Usuarios - COKITO+ Academia')
@section('header', 'Gestión de Usuarios')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Listado de Usuarios</h3>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">Crear Nuevo Usuario</a>
    </div>
    <div class="card-body">
        @if($usuarios->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem;">ID</th>
                            
                            <th style="text-align: left; padding: 0.75rem;">Email</th>
                            <th style="text-align: left; padding: 0.75rem;">Rol</th>
                            <th style="text-align: left; padding: 0.75rem;">Fecha de Creación</th>
                            <th style="text-align: left; padding: 0.75rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem;">{{ $usuario->id }}</td>
                            
                            <td style="padding: 0.75rem;">{{ $usuario->email }}</td>
                            <td style="padding: 0.75rem;">{{ ucfirst($usuario->rol) }}</td>
                            <td style="padding: 0.75rem;">{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                            <td style="padding: 0.75rem;">
                                {{-- Add action buttons here (e.g., Edit, Delete) --}}
                                <a href="{{ route('admin.usuarios.show', $usuario->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No hay usuarios registrados.</p>
        @endif
    </div>
</div>
@endsection