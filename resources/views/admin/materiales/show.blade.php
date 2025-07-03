@extends('layouts.app')

@section('title', 'Detalle de Material - COKITO+ Academia')
@section('header', 'Detalle de Material')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Material</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <p>{{ $material->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <p>{{ $material->titulo }}</p>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <p>{{ $material->descripcion }}</p>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <p>{{ $material->tipo }}</p>
                    </div>
                    <div class="form-group">
                        <label for="curso">Curso:</label>
                        <p>{{ $material->curso->nombre }}</p>
                    </div>
                    <div class="form-group">
                        <label for="ruta_archivo">Archivo/Enlace:</label>
                        @if($material->ruta_archivo)
                            @if($material->tipo == 'enlace')
                                <p><a href="{{ $material->ruta_archivo }}" target="_blank">{{ $material->ruta_archivo }}</a></p>
                            @else
                                <p><a href="{{ asset('storage/' . $material->ruta_archivo) }}" target="_blank">Ver Archivo</a></p>
                            @endif
                        @else
                            <p>N/A</p>
                        @endif
                    </div>
                    <a href="{{ route('admin.materiales.index') }}" class="btn btn-primary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
