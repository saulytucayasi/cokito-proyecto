@extends('layouts.app')

@section('title', 'Registrar Nuevo Pago - COKITO+ Academia')
@section('header', 'Registrar Nuevo Pago')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Registro de Pago</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('secretaria.pagos.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="estudiante_id">Estudiante</label>
                            <select name="estudiante_id" id="estudiante_id" class="form-control" required>
                                <option value="">Seleccione un estudiante</option>
                                {{-- Opciones de estudiantes --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="matricula_id">Matrícula</label>
                            <select name="matricula_id" id="matricula_id" class="form-control" required>
                                <option value="">Seleccione una matrícula</option>
                                {{-- Opciones de matrículas --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_pago">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar Pago</button>
                        <a href="{{ route('secretaria.pagos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
