@extends('layouts.app')

@section('title', 'Crear Material - COKITO+ Academia')
@section('header', 'Crear Material')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Creación de Material</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.materiales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="documento">Documento</option>
                                <option value="video">Video</option>
                                <option value="enlace">Enlace</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="curso_id">Curso</label>
                            <select name="curso_id" id="curso_id" class="form-control" required>
                                <option value="">Seleccione un curso</option>
                                {{-- Opciones de cursos --}}
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="archivo">Archivo/Enlace</label>
                            <input type="file" name="archivo" id="archivo" class="form-control-file">
                            <input type="text" name="enlace" id="enlace" class="form-control" placeholder="Ingrese el enlace si el tipo es 'enlace'" style="display:none;">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Material</button>
                        <a href="{{ route('admin.materiales.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const archivoInput = document.getElementById('archivo');
        const enlaceInput = document.getElementById('enlace');

        tipoSelect.addEventListener('change', function () {
            if (this.value === 'enlace') {
                archivoInput.style.display = 'none';
                enlaceInput.style.display = 'block';
                archivoInput.removeAttribute('required');
                enlaceInput.setAttribute('required', 'required');
            } else {
                archivoInput.style.display = 'block';
                enlaceInput.style.display = 'none';
                archivoInput.setAttribute('required', 'required');
                enlaceInput.removeAttribute('required');
            }
        });
    });
</script>
@endsection
