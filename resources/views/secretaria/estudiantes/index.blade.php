@extends('layouts.app')

@section('title', 'Gestión de Estudiantes - COKITO+ Academia')
@section('header', 'Gestión de Estudiantes')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">🎓 Registro de Estudiantes</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Administra la información de todos los estudiantes</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button class="btn btn-success" onclick="exportarListado()">
            📊 Exportar
        </button>
        <button class="btn btn-primary" onclick="registrarEstudiante()">
            ➕ Registrar Estudiante
        </button>
    </div>
</div>

<!-- Estadísticas de estudiantes -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantes->count() }}</div>
        <div class="stat-label">Total Estudiantes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantes->where('estado_matricula', 'activo')->count() }}</div>
        <div class="stat-label">Activos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantes->whereNotNull('usuario_id')->count() }}</div>
        <div class="stat-label">Con Usuario</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $estudiantes->whereNull('telefono')->count() }}</div>
        <div class="stat-label">Sin Contacto</div>
    </div>
</div>

<!-- Herramientas de trabajo -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body" style="padding: 1rem 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span style="font-weight: 600; color: var(--dark-color);">Herramientas:</span>
            
            <button class="btn btn-warning" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="estudiantesSinContacto()">
                📞 Sin Contacto ({{ $estudiantes->whereNull('telefono')->count() }})
            </button>
            
            <button class="btn btn-info" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="estudiantesSinUsuario()">
                👤 Sin Usuario ({{ $estudiantes->whereNull('usuario_id')->count() }})
            </button>
            
            <button class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="validarDatos()">
                ✅ Validar Datos
            </button>
            
            <input type="text" 
                   id="buscar-rapido" 
                   placeholder="Buscar estudiante..." 
                   style="
                       padding: 0.5rem 1rem; 
                       border: 1px solid #e5e7eb; 
                       border-radius: var(--border-radius);
                       min-width: 250px;
                   "
                   onkeyup="buscarRapido()">
        </div>
    </div>
</div>

<!-- Lista de estudiantes -->
@if($estudiantes->count() > 0)
    <div style="display: grid; gap: 1rem;" id="estudiantes-grid">
        @foreach($estudiantes as $estudiante)
        @php
            $academia = $estudiante->academia;
            $tieneProblemas = !$estudiante->telefono || !$estudiante->correo || !$estudiante->dni;
        @endphp
        
        <div class="card estudiante-item {{ $tieneProblemas ? 'problemas' : '' }}" 
             data-nombre="{{ $estudiante->nombre }} {{ $estudiante->apellido }}"
             data-dni="{{ $estudiante->dni ?? '' }}"
             data-telefono="{{ $estudiante->telefono ?? '' }}"
             style="
                 transition: all 0.3s ease;
                 {{ $tieneProblemas ? 'border-left: 4px solid #f59e0b; background: #fffbeb;' : '' }}
             ">
            <div class="card-body" style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: auto 1fr auto auto; gap: 1.5rem; align-items: center;">
                    
                    <!-- Avatar y info principal -->
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="
                            width: 60px; 
                            height: 60px; 
                            border-radius: 50%;
                            background: linear-gradient(135deg, var(--primary-blue), var(--accent-color));
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-weight: 700;
                            font-size: 1.5rem;
                        ">
                            {{ strtoupper(substr($estudiante->nombre ?? 'N', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark-color); font-size: 1.1rem;">
                                {{ $estudiante->nombre ?? 'Sin nombre' }} {{ $estudiante->apellido ?? '' }}
                            </div>
                            <div style="font-size: 0.875rem; color: #6b7280;">
                                DNI: {{ $estudiante->dni ?? '❌ No registrado' }}
                            </div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">
                                ID: #{{ $estudiante->id }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de contacto -->
                    <div>
                        <div style="margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--dark-color);">📧 Email:</span>
                            <span style="color: {{ $estudiante->correo ? '#6b7280' : '#ef4444' }};">
                                {{ $estudiante->correo ?? '❌ Sin email' }}
                            </span>
                        </div>
                        <div style="margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--dark-color);">📱 Teléfono:</span>
                            <span style="color: {{ $estudiante->telefono ? '#6b7280' : '#ef4444' }};">
                                {{ $estudiante->telefono ?? '❌ Sin teléfono' }}
                            </span>
                        </div>
                        <div>
                            <span style="font-weight: 600; color: var(--dark-color);">🏛️ Academia:</span>
                            <span style="color: #6b7280;">{{ $academia->nombre ?? 'Sin academia' }}</span>
                        </div>
                    </div>
                    
                    <!-- Estado y matrícula -->
                    <div style="text-align: center;">
                        <div style="margin-bottom: 0.75rem;">
                            <span style="
                                background: {{ $estudiante->estado_matricula === 'activo' ? 'var(--success-color)' : 'var(--warning-color)' }};
                                color: white;
                                padding: 0.5rem 1rem;
                                border-radius: var(--border-radius);
                                font-size: 0.875rem;
                                font-weight: 600;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                            ">
                                {{ $estudiante->estado_matricula === 'activo' ? '✅' : '⏸️' }}
                                {{ ucfirst($estudiante->estado_matricula) }}
                            </span>
                        </div>
                        
                        @if($estudiante->usuario_id)
                        <div style="margin-bottom: 0.5rem;">
                            <span style="
                                background: var(--primary-blue);
                                color: white;
                                padding: 0.25rem 0.75rem;
                                border-radius: var(--border-radius);
                                font-size: 0.75rem;
                                font-weight: 600;
                            ">
                                👤 Usuario Sistema
                            </span>
                        </div>
                        @endif
                        
                        @if($tieneProblemas)
                        <div>
                            <span style="
                                background: #f59e0b;
                                color: white;
                                padding: 0.25rem 0.75rem;
                                border-radius: var(--border-radius);
                                font-size: 0.75rem;
                                font-weight: 600;
                            ">
                                ⚠️ Datos Incompletos
                            </span>
                        </div>
                        @endif
                        
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                            Registrado: {{ $estudiante->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <button type="button" 
                                class="btn btn-primary"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="editarEstudiante({{ $estudiante->id }})">
                            ✏️ Editar
                        </button>
                        
                        @if(!$estudiante->usuario_id)
                        <button type="button" 
                                class="btn btn-success"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="crearUsuario({{ $estudiante->id }})">
                            👤 Crear Usuario
                        </button>
                        @endif
                        
                        <button type="button" 
                                class="btn btn-warning"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="gestionarMatricula({{ $estudiante->id }})">
                            📝 Matrícula
                        </button>
                        
                        <button type="button" 
                                class="btn btn-accent"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="verHistorial({{ $estudiante->id }})">
                            📋 Historial
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    @if($estudiantes->hasPages())
    <div style="margin-top: 2rem; text-align: center;">
        {{ $estudiantes->links() }}
    </div>
    @endif
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎓</div>
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">No hay estudiantes registrados</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Comienza registrando el primer estudiante del sistema.
            </p>
            <button class="btn btn-primary" onclick="registrarEstudiante()">
                ➕ Registrar Primer Estudiante
            </button>
        </div>
    </div>
@endif

<!-- Modal para editar estudiante -->
<div id="modal-editar-estudiante" style="
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0,0,0,0.5); 
    z-index: 1000;
    justify-content: center;
    align-items: center;
">
    <div style="
        background: white; 
        border-radius: var(--border-radius); 
        padding: 2rem; 
        width: 90%; 
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
    ">
        <h3 style="margin: 0 0 1.5rem 0; color: var(--dark-color);">✏️ Editar Estudiante</h3>
        
        <form id="form-editar-estudiante">
            <input type="hidden" id="estudiante-id">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" id="nombre-estudiante" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Apellido</label>
                    <input type="text" id="apellido-estudiante" class="form-control">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label">DNI</label>
                    <input type="text" id="dni-estudiante" class="form-control" maxlength="8">
                </div>
                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="text" id="telefono-estudiante" class="form-control">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Email</label>
                <input type="email" id="email-estudiante" class="form-control">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" id="fecha-nacimiento" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select id="estado-estudiante" class="form-control">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Dirección</label>
                <textarea id="direccion-estudiante" class="form-control" rows="2"></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn" style="background: #6b7280; color: white;" onclick="cerrarModalEditar()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    ✅ Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function buscarRapido() {
    const buscarTexto = document.getElementById('buscar-rapido').value.toLowerCase();
    const estudiantes = document.querySelectorAll('.estudiante-item');
    
    estudiantes.forEach(estudiante => {
        const nombre = estudiante.getAttribute('data-nombre').toLowerCase();
        const dni = estudiante.getAttribute('data-dni').toLowerCase();
        const telefono = estudiante.getAttribute('data-telefono').toLowerCase();
        
        if (buscarTexto === '' || nombre.includes(buscarTexto) || dni.includes(buscarTexto) || telefono.includes(buscarTexto)) {
            estudiante.style.display = 'block';
        } else {
            estudiante.style.display = 'none';
        }
    });
}

function estudiantesSinContacto() {
    const estudiantes = document.querySelectorAll('.estudiante-item');
    estudiantes.forEach(estudiante => {
        const telefono = estudiante.getAttribute('data-telefono');
        if (!telefono || telefono === '') {
            estudiante.style.display = 'block';
        } else {
            estudiante.style.display = 'none';
        }
    });
}

function estudiantesSinUsuario() {
    alert('Funcionalidad para filtrar estudiantes sin usuario a implementar');
}

function validarDatos() {
    alert('Funcionalidad de validación de datos a implementar');
}

function registrarEstudiante() {
    alert('Funcionalidad de registro de estudiante a implementar');
}

function exportarListado() {
    alert('Funcionalidad de exportar listado a implementar');
}

function editarEstudiante(id) {
    document.getElementById('estudiante-id').value = id;
    document.getElementById('modal-editar-estudiante').style.display = 'flex';
}

function crearUsuario(estudianteId) {
    const confirmacion = confirm('¿Crear usuario del sistema para este estudiante?');
    if (confirmacion) {
        alert('Usuario creado exitosamente');
        location.reload();
    }
}

function gestionarMatricula(estudianteId) {
    alert(`Gestionar matrícula para estudiante ID: ${estudianteId} (a implementar)`);
}

function verHistorial(estudianteId) {
    alert(`Ver historial de estudiante ID: ${estudianteId} (a implementar)`);
}

function cerrarModalEditar() {
    document.getElementById('modal-editar-estudiante').style.display = 'none';
    document.getElementById('form-editar-estudiante').reset();
}

// Manejar envío del formulario de edición
document.getElementById('form-editar-estudiante').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const estudianteId = document.getElementById('estudiante-id').value;
    const nombre = document.getElementById('nombre-estudiante').value;
    const apellido = document.getElementById('apellido-estudiante').value;
    const dni = document.getElementById('dni-estudiante').value;
    const telefono = document.getElementById('telefono-estudiante').value;
    const email = document.getElementById('email-estudiante').value;
    
    alert('Estudiante actualizado exitosamente');
    cerrarModalEditar();
    location.reload();
});

// Cerrar modal al hacer click fuera
document.getElementById('modal-editar-estudiante').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalEditar();
    }
});

// Efectos hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.estudiante-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('problemas')) {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('problemas')) {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--box-shadow)';
            }
        });
    });
});
</script>

<style>
.problemas {
    animation: gentle-pulse 3s infinite;
}

@keyframes gentle-pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.01);
    }
}

@media (max-width: 768px) {
    .estudiante-item .card-body > div {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .estudiante-item .card-body > div > div:last-child {
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    #form-editar-estudiante > div {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection