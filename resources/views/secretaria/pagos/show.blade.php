@extends('layouts.app')

@section('title', 'Detalle de Pago - COKITO+ Academia')
@section('header', 'Detalle de Pago')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Pago</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <p>{{ $pago->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="estudiante">Estudiante:</label>
                        <p>{{ $pago->estudiante->nombre }}</p>
                    </div>
                    <div class="form-group">
                        <label for="matricula">Matrícula:</label>
                        <p>{{ $pago->matricula->codigo }}</p>
                    </div>
                    <div class="form-group">
                        <label for="monto">Monto:</label>
                        <p>{{ $pago->monto }}</p>
                    </div>
                    <div class="form-group">
                        <label for="fecha_pago">Fecha de Pago:</label>
                        <p>{{ $pago->fecha_pago->format('d/m/Y') }}</p>
                    </div>
                    <a href="{{ route('secretaria.pagos.index') }}" class="btn btn-primary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
