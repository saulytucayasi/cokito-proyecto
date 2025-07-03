@extends('layouts.app')

@section('title', 'Gestión de Materiales - COKITO+ Academia')
@section('header', 'Gestión de Materiales')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Materiales</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.materiales.create') }}" class="btn btn-primary">Nuevo Material</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="materiales-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Curso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Aquí se cargarán los datos de los materiales --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
