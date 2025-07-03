<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'COKITO+ Academia')</title>
    
    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
   <style>
    :root {
        --overlay-color: rgba(161, 148, 237, 0.9); /* capa rosada sobre imagen */
        --primary-blue: #4f46e5;
        --sidebar-bg: rgba(130, 110, 218, 0.95);
        --card-bg: #c4b8f5; /* rosado claro */
        --text-color: #1e1b4b;
        --white: #ffffff;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --accent-color: #8b5cf6; /* Morado accent */
        --border-radius: 12px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-image: url('https://escuelasdelmundo.com/wp-content/uploads/2021/10/postulante-1024x1024.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        color: var(--text-color);
    }

    /* Overlay rosado */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background: var(--overlay-color);
        z-index: -1;
    }

    .app-layout {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: 280px;
        background: var(--sidebar-bg);
        color: white;
        position: fixed;
        height: 100vh;
        box-shadow: var(--box-shadow);
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        padding: 1.5rem;
        font-weight: bold;
        font-size: 1.5rem;
        color: white;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }

    .nav-item {
        margin: 0.25rem 1rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        color: white;
        border-radius: var(--border-radius);
        text-decoration: none;
        transition: 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
        background-color: var(--primary-blue);
    }

    /* Main content */
    .main-content {
        flex: 1;
        margin-left: 280px;
        transition: margin-left 0.3s ease;
        min-height: 100vh;
    }

    .sidebar.collapsed + .main-content {
        margin-left: 80px;
    }

    .header {
        background: rgba(255, 255, 255, 0.95);
        padding: 1rem 2rem;
        box-shadow: var(--box-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(161, 148, 237, 0.2);
    }

    .header h1 {
        color: var(--primary-blue);
        margin: 0;
    }

    .user-name {
        color: var(--text-color);
        font-weight: 500;
        margin-right: 1rem;
    }

    .content {
        padding: 2rem;
    }

    /* Cards y estadísticas */
    .card,
    .stat-card {
        background: rgba(255, 255, 255, 0.98); /* Fondo más opaco */
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: var(--text-color);
        border: 1px solid rgba(161, 148, 237, 0.2); /* Borde sutil morado */
    }

    /* Texto en cards con mejor contraste */
    .card p,
    .card-body p {
        color: #374151 !important; /* Gris más oscuro */
    }

    .card .text-gray {
        color: #4b5563 !important; /* Gris medio más oscuro */
    }

    /* Corregir todos los textos con colores claros */
    [style*="color: #6b7280"],
    [style*="color:#6b7280"] {
        color: #374151 !important;
    }

    [style*="color: #9ca3af"],
    [style*="color:#9ca3af"] {
        color: #4b5563 !important;
    }

    /* Mejorar contraste en elementos específicos */
    .card span,
    .card div {
        color: inherit;
    }

    /* Asegurar que los textos principales sean visibles */
    .card h1, .card h2, .card h3, .card h4, .card h5, .card h6 {
        color: var(--text-color) !important;
    }

    /* Información de cursos y estudiantes más legible */
    .card small,
    .card .small-text {
        color: #4b5563 !important;
        font-weight: 500;
    }

    /* Información de estadísticas */
    .stat-info,
    .course-info {
        color: #374151 !important;
        font-weight: 500;
    }

    /* Mejorar contraste de labels y texto secundario */
    .card .opacity-80,
    .card .opacity-90,
    [style*="opacity: 0.8"],
    [style*="opacity: 0.9"] {
        opacity: 1 !important;
        color: #374151 !important;
    }

    .card-header {
        font-weight: bold;
        margin-bottom: 1rem;
        color: var(--text-color);
        border-bottom: 2px solid rgba(161, 148, 237, 0.3);
        padding-bottom: 0.5rem;
    }

    .card-header h3 {
        margin: 0;
        color: var(--primary-blue);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-blue);
    }

    .stat-label {
        color: #4b5563;
    }

    /* Botones */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: var(--primary-blue);
        color: white;
    }
    .btn-primary:hover {
        background-color: #3730a3;
        transform: translateY(-1px);
    }

    .btn-success {
        background-color: var(--success-color);
        color: white;
    }
    .btn-success:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .btn-warning {
        background-color: var(--warning-color);
        color: white;
    }
    .btn-warning:hover {
        background-color: #d97706;
        transform: translateY(-1px);
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
    }
    .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }

    .btn-info {
        background-color: #3b82f6;
        color: white;
    }
    .btn-info:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-1px);
    }

    /* Botones pequeños */
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .btn-accent {
        background-color: var(--accent-color);
        color: white;
    }
    .btn-accent:hover {
        background-color: #7c3aed;
        transform: translateY(-1px);
    }

    /* Botones con estilos específicos para cards de cursos */
    .course-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .course-btn-primary {
        background-color: var(--primary-blue);
        color: white;
    }
    .course-btn-primary:hover {
        background-color: #3730a3;
        transform: translateY(-1px);
    }

    .course-btn-success {
        background-color: var(--success-color);
        color: white;
    }
    .course-btn-success:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .course-btn-accent {
        background-color: var(--accent-color);
        color: white;
    }
    .course-btn-accent:hover {
        background-color: #7c3aed;
        transform: translateY(-1px);
    }

    .course-btn-warning {
        background-color: var(--warning-color);
        color: white;
    }
    .course-btn-warning:hover {
        background-color: #d97706;
        transform: translateY(-1px);
    }

    .course-btn-disabled {
        background-color: #6b7280;
        color: white;
        cursor: default;
    }

    /* Tablas */
    table {
        background: rgba(255, 255, 255, 0.9);
        border-radius: var(--border-radius);
    }

    table thead th {
        background: rgba(161, 148, 237, 0.1);
        color: var(--primary-blue);
        font-weight: 600;
        border-bottom: 2px solid rgba(161, 148, 237, 0.3);
    }

    table tbody tr:hover {
        background: rgba(161, 148, 237, 0.05);
    }

    table tbody td {
        color: var(--text-color);
    }

    /* Mejoras de contraste para texto */
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-blue);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .stat-label {
        color: #374151;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

   </style>
</head>
<body>
    <div class="app-layout">
        @auth
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Academia" style="max-width: 120px; height: auto;">
                </div>
            </div>
            <nav class="sidebar-nav">
                @php
                    $user = Auth::user();
                    $usuario = null;
                    $role = null;

                    if ($user) {
                        $usuario = \App\Models\Usuario::where('email', $user->email)->first();
                        $role = $usuario ? $usuario->rol : null;
                    }
                @endphp

                @if($role === 'admin')
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                            👥 Usuarios
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.estudiantes.index') }}" class="nav-link {{ request()->routeIs('admin.estudiantes.*') ? 'active' : '' }}">
                            🎓 Estudiantes
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.cursos.index') }}" class="nav-link {{ request()->routeIs('admin.cursos.*') ? 'active' : '' }}">
                            📚 Cursos
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.ciclos.index') }}" class="nav-link {{ request()->routeIs('admin.ciclos.*') ? 'active' : '' }}">
                            🔄 Ciclos
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.matriculas.index') }}" class="nav-link {{ request()->routeIs('admin.matriculas.*') ? 'active' : '' }}">
                            📋 Matrículas
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.trabajadores.index') }}" class="nav-link {{ request()->routeIs('admin.trabajadores.*') ? 'active' : '' }}">
                            👷 Trabajadores
                        </a>
                    </div>
                @elseif($role === 'docente')
                    <div class="nav-item">
                        <a href="{{ route('docente.dashboard') }}" class="nav-link {{ request()->routeIs('docente.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('docente.cursos.index') }}" class="nav-link {{ request()->routeIs('docente.cursos.*') ? 'active' : '' }}">
                            📚 Mis Cursos
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('docente.estudiantes.index') }}" class="nav-link {{ request()->routeIs('docente.estudiantes.*') ? 'active' : '' }}">
                            🎓 Estudiantes
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('docente.materiales.index') }}" class="nav-link {{ request()->routeIs('docente.materiales.*') ? 'active' : '' }}">
                            📁 Materiales
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('docente.videos.index') }}" class="nav-link {{ request()->routeIs('docente.videos.*') ? 'active' : '' }}">
                            🎥 Videos
                        </a>
                    </div>
                @elseif($role === 'secretaria')
                    <div class="nav-item">
                        <a href="{{ route('secretaria.dashboard') }}" class="nav-link {{ request()->routeIs('secretaria.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('secretaria.matriculas.index') }}" class="nav-link {{ request()->routeIs('secretaria.matriculas.*') ? 'active' : '' }}">
                            📋 Matrículas
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('secretaria.estudiantes.index') }}" class="nav-link {{ request()->routeIs('secretaria.estudiantes.*') ? 'active' : '' }}">
                            🎓 Estudiantes
                        </a>
                    </div>
                @elseif($role === 'estudiante')
                    <div class="nav-item">
                        <a href="{{ route('estudiante.dashboard') }}" class="nav-link {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('estudiante.cursos.index') }}" class="nav-link {{ request()->routeIs('estudiante.cursos.*') ? 'active' : '' }}">
                            📚 Mis Cursos
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('estudiante.materiales.index') }}" class="nav-link {{ request()->routeIs('estudiante.materiales.*') ? 'active' : '' }}">
                            📁 Materiales
                        </a>
                    </div>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <h1>@yield('header', 'Dashboard')</h1>
                </div>
                <div class="header-right">
                    <div class="user-info" style="text-align: right; margin-right: 1rem;">
                        @php
                            $displayName = 'Usuario';
                            $displaySubtitle = '';
                            
                            if ($role === 'admin') {
                                $displayName = 'Administrador';
                            } elseif ($role === 'estudiante') {
                                $estudiante = \App\Models\Estudiante::where('usuario_id', $usuario->id)->first();
                                if ($estudiante) {
                                    $displayName = $estudiante->nombre . ' ' . $estudiante->apellido;
                                    $displaySubtitle = 'DNI: ' . $estudiante->dni . ' | ' . $estudiante->correo;
                                }
                            } elseif ($role === 'docente') {
                                $trabajador = \App\Models\Trabajador::where('usuario_id', $usuario->id)->first();
                                if ($trabajador) {
                                    $displayName = $trabajador->nombre . ' ' . $trabajador->apellido;
                                    $displaySubtitle = $trabajador->correo;
                                }
                            }
                        @endphp
                        
                        <div class="user-name" style="font-weight: 600; color: var(--text-color);">{{ $displayName }}</div>
                        @if($displaySubtitle)
                            <div class="user-subtitle" style="font-size: 0.8rem; color: #6b7280;">{{ $displaySubtitle }}</div>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
            <div class="content">
                @if(session('success'))
                    <div style="background: var(--success-color); color: white; padding: 1rem; border-radius: var(--border-radius); margin-bottom: 1rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background: var(--danger-color); color: white; padding: 1rem; border-radius: var(--border-radius); margin-bottom: 1rem;">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
        @else
        <div class="main-content" style="margin-left: 0;">
            @yield('content')
        </div>
        @endauth
    </div>
</body>
</html>