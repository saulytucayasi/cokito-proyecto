@extends('layouts.app')

@section('title', 'Editar Pago - COKITO+ Academia')
@section('header', 'Editar Pago')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Edición de Pago</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('secretaria.pagos.update', $pago->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="estudiante_id">Estudiante</label>
                            <select name="estudiante_id" id="estudiante_id" class="form-control" required>
                                <option value="">Seleccione un estudiante</option>
                                {{-- Opciones de estudiantes --}}
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}" {{ $pago->estudiante_id == $estudiante->id ? 'selected' : '' }}>{{ $estudiante->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="matricula_id">Matrícula</label>
                            <select name="matricula_id" id="matricula_id" class="form-control" required>
                                <option value="">Seleccione una matrícula</option>
                                {{-- Opciones de matrículas --}}
                                @foreach($matriculas as $matricula)
                                    <option value="{{ $matricula->id }}" {{ $pago->matricula_id == $matricula->id ? 'selected' : '' }}>{{ $matricula->codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control" step="0.01" value="{{ $pago->monto }}" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_pago">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" value="{{ $pago->fecha_pago->format('Y-m-d') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Pago</button>
                        <a href="{{ route('secretaria.pagos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
