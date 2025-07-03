@extends('layouts.app')

@section('title', 'Crear Sesión - COKITO+ Academia')
@section('header', 'Crear Nueva Sesión')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="javascript:history.back()" class="btn" style="background-color: #6b7280; color: white;">
        ← Volver
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3>📅 Crear Nueva Sesión</h3>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
            Agrega una nueva sesión a tu curso
        </p>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div style="background-color: var(--danger-color); color: white; padding: 1rem; border-radius: var(--border-radius); margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('docente.sesiones.store') }}" method="POST" style="display: grid; gap: 1.5rem;">
            @csrf
            
            <!-- Título de la Sesión -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    📝 Título de la Sesión *
                </label>
                <input type="text" 
                       name="titulo" 
                       value="{{ old('titulo') }}"
                       style="
                           width: 100%; 
                           padding: 0.75rem 1rem; 
                           border: 1px solid #e5e7eb; 
                           border-radius: var(--border-radius);
                           font-size: 1rem;
                       " 
                       placeholder="Ej: Introducción a Variables"
                       required>
            </div>

            <!-- Descripción -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    📄 Descripción
                </label>
                <textarea name="descripcion" 
                          rows="3"
                          style="
                              width: 100%; 
                              padding: 0.75rem 1rem; 
                              border: 1px solid #e5e7eb; 
                              border-radius: var(--border-radius);
                              font-size: 1rem;
                              resize: vertical;
                          " 
                          placeholder="Describe el contenido y objetivos de la sesión...">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Curso -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    📚 Curso *
                </label>
                <select name="curso_id" 
                        style="
                            width: 100%; 
                            padding: 0.75rem 1rem; 
                            border: 1px solid #e5e7eb; 
                            border-radius: var(--border-radius);
                            font-size: 1rem;
                            background: white;
                        " 
                        required>
                    <option value="">Selecciona un curso</option>
                    @foreach($cursosAsignados as $curso)
                        <option value="{{ $curso->id }}" 
                                {{ (old('curso_id') == $curso->id || $cursoId == $curso->id) ? 'selected' : '' }}>
                            {{ $curso->nombre }} - {{ $curso->ciclo->nombre_area ?? 'Sin ciclo' }}
                        </option>
                    @endforeach
                </select>
                @if($cursosAsignados->count() === 0)
                <p style="color: var(--warning-color); font-size: 0.875rem; margin-top: 0.5rem;">
                    ⚠️ No tienes cursos asignados para crear sesiones.
                </p>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <!-- Fecha Programada -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        📅 Fecha Programada
                    </label>
                    <input type="date" 
                           name="fecha_programada" 
                           value="{{ old('fecha_programada') }}"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           ">
                </div>

                <!-- Duración en Minutos -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        ⏱️ Duración (minutos)
                    </label>
                    <input type="number" 
                           name="duracion_minutos" 
                           value="{{ old('duracion_minutos', 60) }}"
                           min="1"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           "
                           placeholder="60">
                    <small style="color: #6b7280; font-size: 0.875rem;">
                        Duración estimada en minutos
                    </small>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <!-- Hora Inicio -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        🕐 Hora de Inicio
                    </label>
                    <input type="time" 
                           name="hora_inicio" 
                           value="{{ old('hora_inicio') }}"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           ">
                </div>

                <!-- Hora Fin -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        🕐 Hora de Fin
                    </label>
                    <input type="time" 
                           name="hora_fin" 
                           value="{{ old('hora_fin') }}"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           ">
                </div>

                <!-- Orden -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                        📋 Orden de Sesión *
                    </label>
                    <input type="number" 
                           name="orden" 
                           value="{{ old('orden', 1) }}"
                           min="1"
                           style="
                               width: 100%; 
                               padding: 0.75rem 1rem; 
                               border: 1px solid #e5e7eb; 
                               border-radius: var(--border-radius);
                               font-size: 1rem;
                           " 
                           required>
                    <small style="color: #6b7280; font-size: 0.875rem;">
                        Orden secuencial en el curso
                    </small>
                </div>
            </div>

            <!-- Estado -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    🎯 Estado de la Sesión *
                </label>
                <select name="estado" 
                        style="
                            width: 100%; 
                            padding: 0.75rem 1rem; 
                            border: 1px solid #e5e7eb; 
                            border-radius: var(--border-radius);
                            font-size: 1rem;
                            background: white;
                        " 
                        required>
                    <option value="programada" {{ old('estado', 'programada') === 'programada' ? 'selected' : '' }}>
                        📅 Programada
                    </option>
                    <option value="en_curso" {{ old('estado') === 'en_curso' ? 'selected' : '' }}>
                        ▶️ En Curso
                    </option>
                    <option value="completada" {{ old('estado') === 'completada' ? 'selected' : '' }}>
                        ✅ Completada
                    </option>
                    <option value="cancelada" {{ old('estado') === 'cancelada' ? 'selected' : '' }}>
                        ❌ Cancelada
                    </option>
                </select>
            </div>

            <!-- Contenido -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem;">
                    📝 Contenido de la Sesión
                </label>
                <textarea name="contenido" 
                          rows="5"
                          style="
                              width: 100%; 
                              padding: 0.75rem 1rem; 
                              border: 1px solid #e5e7eb; 
                              border-radius: var(--border-radius);
                              font-size: 1rem;
                              resize: vertical;
                          " 
                          placeholder="Detalla el contenido que se abordará en esta sesión...">{{ old('contenido') }}</textarea>
                <small style="color: #6b7280; font-size: 0.875rem;">
                    Opcional: Describe los temas específicos que se cubrirán
                </small>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <a href="javascript:history.back()" 
                   class="btn" 
                   style="background-color: #6b7280; color: white; padding: 0.75rem 2rem;">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-primary" 
                        style="padding: 0.75rem 2rem;"
                        {{ $cursosAsignados->count() === 0 ? 'disabled' : '' }}>
                    📅 Crear Sesión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection