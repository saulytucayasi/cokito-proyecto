@extends('layouts.app')

@section('title', 'Gestión de Academias - COKITO+ Academia')
@section('header', 'Gestión de Academias')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Academias</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.academias.create') }}" class="btn btn-primary">Nueva Academia</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="academias-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Aquí se cargarán los datos de las academias --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
