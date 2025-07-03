@extends('layouts.app')

@section('title', 'Detalle de Academia - COKITO+ Academia')
@section('header', 'Detalle de Academia')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Academia</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <p>{{ $academia->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <p>{{ $academia->nombre }}</p>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <p>{{ $academia->direccion }}</p>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <p>{{ $academia->telefono }}</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <p>{{ $academia->email }}</p>
                    </div>
                    <a href="{{ route('admin.academias.index') }}" class="btn btn-primary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
