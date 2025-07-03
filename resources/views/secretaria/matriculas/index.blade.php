@extends('layouts.app')

@section('title', 'Procesamiento de Matrículas - COKITO+ Academia')
@section('header', 'Procesamiento de Matrículas')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0; color: var(--dark-color);">📝 Gestión de Matrículas</h2>
        <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Procesa nuevas inscripciones y gestiona pagos</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button class="btn btn-success" onclick="procesarMatriculaMasiva()">
            📋 Matrícula Masiva
        </button>
        <button class="btn btn-primary" onclick="nuevaMatricula()">
            ➕ Nueva Matrícula
        </button>
    </div>
</div>

<!-- Estadísticas de matrículas -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    @php
        $pendientes = $matriculas->where('estado_pago', 'pendiente');
        $pagadas = $matriculas->where('estado_pago', 'pagado');
        $vencidas = $matriculas->where('estado_pago', 'vencido');
        $ingresosMes = $pagadas->sum('monto_pagado');
    @endphp
    
    <div class="stat-card">
        <div class="stat-value">{{ $pendientes->count() }}</div>
        <div class="stat-label">Pendientes de Pago</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $pagadas->count() }}</div>
        <div class="stat-label">Pagadas Hoy</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $vencidas->count() }}</div>
        <div class="stat-label">Vencidas</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">S/. {{ number_format($ingresosMes, 0) }}</div>
        <div class="stat-label">Ingresos del Mes</div>
    </div>
</div>

<!-- Alertas importantes -->
@if($vencidas->count() > 0)
<div style="
    background: #fef3f3; 
    border: 1px solid #fca5a5; 
    border-radius: var(--border-radius); 
    padding: 1rem; 
    margin-bottom: 2rem;
    border-left: 4px solid #ef4444;
">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        <span style="font-size: 1.25rem;">⚠️</span>
        <strong style="color: #dc2626;">Atención:</strong>
        <span style="color: #7f1d1d;">{{ $vencidas->count() }} matrículas vencidas requieren seguimiento</span>
    </div>
</div>
@endif

<!-- Filtros de trabajo -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body" style="padding: 1rem 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span style="font-weight: 600; color: var(--dark-color);">Vista rápida:</span>
            
            <button class="btn btn-warning" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="mostrarPendientes()">
                ⏳ Pendientes ({{ $pendientes->count() }})
            </button>
            
            <button class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="mostrarVencidas()">
                ⚠️ Vencidas ({{ $vencidas->count() }})
            </button>
            
            <button class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="mostrarPagadas()">
                ✅ Pagadas Hoy ({{ $pagadas->count() }})
            </button>
            
            <button class="btn" style="background: #6b7280; color: white; padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="mostrarTodas()">
                📋 Todas
            </button>
        </div>
    </div>
</div>

<!-- Lista de matrículas para procesar -->
@if($matriculas->count() > 0)
    <div style="display: grid; gap: 1rem;" id="matriculas-grid">
        @foreach($matriculas as $matricula)
        @php
            $estudiante = $matricula->estudiante;
            $academia = $matricula->academia;
            $estadoPago = $matricula->estado_pago;
            $urgente = $matricula->fecha_vencimiento && $matricula->fecha_vencimiento->isPast();
        @endphp
        
        <div class="card matricula-item {{ $urgente ? 'urgente' : '' }}" 
             data-estado-pago="{{ $estadoPago }}"
             style="
                 transition: all 0.3s ease;
                 {{ $urgente ? 'border-left: 4px solid #ef4444; background: #fef3f3;' : '' }}
             ">
            <div class="card-body" style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: auto 1fr auto auto; gap: 1.5rem; align-items: center;">
                    
                    <!-- Avatar y info del estudiante -->
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
                                DNI: {{ $estudiante->dni ?? 'No registrado' }}
                            </div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">
                                📧 {{ $estudiante->correo ?? 'Sin email' }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de la matrícula -->
                    <div>
                        <div style="margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--dark-color);">Academia:</span>
                            <span style="color: #6b7280;">{{ $academia->nombre ?? 'Sin academia' }}</span>
                        </div>
                        <div style="margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--dark-color);">Matrícula:</span>
                            <span style="color: #6b7280;">{{ $matricula->fecha_matricula->format('d/m/Y') }}</span>
                        </div>
                        @if($matricula->fecha_vencimiento)
                        <div>
                            <span style="font-weight: 600; color: var(--dark-color);">Vencimiento:</span>
                            <span style="color: {{ $matricula->fecha_vencimiento->isPast() ? '#ef4444' : '#6b7280' }}; font-weight: {{ $matricula->fecha_vencimiento->isPast() ? '600' : 'normal' }};">
                                {{ $matricula->fecha_vencimiento->format('d/m/Y') }}
                                @if($matricula->fecha_vencimiento->isPast())
                                    (Vencido)
                                @elseif($matricula->fecha_vencimiento->isToday())
                                    (Vence hoy)
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Estado y monto -->
                    <div style="text-align: center;">
                        @php
                            $estadoColors = [
                                'pagado' => 'var(--success-color)',
                                'pendiente' => 'var(--warning-color)',
                                'vencido' => '#ef4444'
                            ];
                            $estadoIcons = [
                                'pagado' => '✅',
                                'pendiente' => '⏳',
                                'vencido' => '⚠️'
                            ];
                        @endphp
                        <div style="margin-bottom: 0.5rem;">
                            <span style="
                                background: {{ $estadoColors[$estadoPago] ?? '#6b7280' }};
                                color: white;
                                padding: 0.5rem 1rem;
                                border-radius: var(--border-radius);
                                font-size: 0.875rem;
                                font-weight: 600;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                            ">
                                {{ $estadoIcons[$estadoPago] ?? '❓' }}
                                {{ ucfirst($estadoPago) }}
                            </span>
                        </div>
                        
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--dark-color);">
                            S/. {{ number_format($matricula->monto_pagado ?? 0, 2) }}
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280;">
                            {{ $matricula->metodo_pago ?? 'Sin método' }}
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        @if($estadoPago === 'pendiente' || $estadoPago === 'vencido')
                        <button type="button" 
                                class="btn btn-success"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="procesarPago({{ $matricula->id }})">
                            💳 Procesar Pago
                        </button>
                        @endif
                        
                        <button type="button" 
                                class="btn btn-warning"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="editarMatricula({{ $matricula->id }})">
                            ✏️ Editar
                        </button>
                        
                        <button type="button" 
                                class="btn btn-accent"
                                style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                onclick="verDetalles({{ $matricula->id }})">
                            👁️ Detalles
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    @if($matriculas->hasPages())
    <div style="margin-top: 2rem; text-align: center;">
        {{ $matriculas->links() }}
    </div>
    @endif
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 4rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📝</div>
            <h3 style="margin-bottom: 1rem; color: var(--dark-color);">No hay matrículas por procesar</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">
                Todas las matrículas están al día. ¡Excelente trabajo!
            </p>
            <button class="btn btn-primary" onclick="nuevaMatricula()">
                ➕ Procesar Nueva Matrícula
            </button>
        </div>
    </div>
@endif

<!-- Modal para procesar pago -->
<div id="modal-procesar-pago" style="
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
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    ">
        <h3 style="margin: 0 0 1.5rem 0; color: var(--dark-color);">💳 Procesar Pago</h3>
        
        <form id="form-procesar-pago">
            <input type="hidden" id="matricula-id">
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Monto a Pagar (S/.)</label>
                <input type="number" id="monto-pago" class="form-control" step="0.01" min="0" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Método de Pago</label>
                <select id="metodo-pago" class="form-control" required>
                    <option value="">Seleccionar método</option>
                    <option value="efectivo">💵 Efectivo</option>
                    <option value="transferencia">🏦 Transferencia</option>
                    <option value="tarjeta">💳 Tarjeta</option>
                    <option value="yape">📱 Yape/Plin</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Número de Comprobante</label>
                <input type="text" id="comprobante" class="form-control" placeholder="Boleta, factura o recibo">
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Observaciones</label>
                <textarea id="observaciones-pago" class="form-control" rows="3" placeholder="Comentarios adicionales..."></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn" style="background: #6b7280; color: white;" onclick="cerrarModalPago()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    ✅ Confirmar Pago
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function mostrarPendientes() {
    filtrarPorEstado('pendiente');
}

function mostrarVencidas() {
    filtrarPorEstado('vencido');
}

function mostrarPagadas() {
    filtrarPorEstado('pagado');
}

function mostrarTodas() {
    filtrarPorEstado('');
}

function filtrarPorEstado(estado) {
    const matriculas = document.querySelectorAll('.matricula-item');
    matriculas.forEach(matricula => {
        const estadoPago = matricula.getAttribute('data-estado-pago');
        if (estado === '' || estadoPago === estado) {
            matricula.style.display = 'block';
        } else {
            matricula.style.display = 'none';
        }
    });
}

function procesarPago(matriculaId) {
    document.getElementById('matricula-id').value = matriculaId;
    document.getElementById('modal-procesar-pago').style.display = 'flex';
}

function editarMatricula(id) {
    alert(`Editar matrícula ID: ${id} (a implementar)`);
}

function verDetalles(id) {
    alert(`Ver detalles de matrícula ID: ${id} (a implementar)`);
}

function nuevaMatricula() {
    alert('Funcionalidad de nueva matrícula a implementar');
}

function procesarMatriculaMasiva() {
    alert('Funcionalidad de matrícula masiva a implementar');
}

function cerrarModalPago() {
    document.getElementById('modal-procesar-pago').style.display = 'none';
    document.getElementById('form-procesar-pago').reset();
}

// Manejar envío del formulario de pago
document.getElementById('form-procesar-pago').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const matriculaId = document.getElementById('matricula-id').value;
    const monto = document.getElementById('monto-pago').value;
    const metodo = document.getElementById('metodo-pago').value;
    const comprobante = document.getElementById('comprobante').value;
    const observaciones = document.getElementById('observaciones-pago').value;
    
    alert('Pago procesado exitosamente');
    cerrarModalPago();
    location.reload();
});

// Cerrar modal al hacer click fuera
document.getElementById('modal-procesar-pago').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalPago();
    }
});

// Efectos hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.matricula-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('urgente')) {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('urgente')) {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--box-shadow)';
            }
        });
    });
});
</script>

<style>
.urgente {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.02);
    }
}

@media (max-width: 768px) {
    .matricula-item .card-body > div {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .matricula-item .card-body > div > div:last-child {
        flex-direction: row;
        justify-content: center;
    }
}
</style>
@endsection