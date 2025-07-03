@extends('layouts.app')

@section('title', 'Iniciar Sesión - COKITO+ Academia')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        background-image: url('https://escuelasdelmundo.com/wp-content/uploads/2021/10/postulante-1024x1024.png');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95); /* Fondo blanco semi-transparente para el contenido */
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        padding: 3rem;
        width: 100%;
        max-width: 400px;
        position: relative; /* Necesario para posicionar el pseudo-elemento */
        overflow: hidden; /* Para que la imagen de fondo no se salga de los bordes redondeados */
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPeKcFfTuB4bzlJDFjUT2UmT7mbyU4tgSZhg&s');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.1; /* Ajusta este valor para cambiar la opacidad de la imagen */
        z-index: -1; /* Asegura que la imagen esté detrás del contenido */
    }

    .login-logo {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-logo h1 {
        font-size: 2.5rem;
        font-weight: 700;
        background: var(--gradient-bg);
        -webkit-background-clip: text;
        -webkit-text-fill-color: var(--primary-blue);
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .login-logo p {
        color: #6b7280;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark-color);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-error {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .login-btn {
        width: 100%;
        padding: 1rem;
        background: var(--primary-blue);
        color: var(--white);
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
    }

    .forgot-password {
        text-align: center;
    }

    .forgot-password a {
        color: var(--primary-blue);
        text-decoration: none;
        font-size: 0.875rem;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Academia" style="max-width: 200px; height: auto; margin-bottom: 1rem;">
            <p>Sistema de Gestión Académica</p>
        </div>

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input @error('email') error @enderror"
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="usuario@cokito.com"
                >
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input @error('password') error @enderror"
                    required
                    placeholder="••••••••"
                >
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-btn">
                Iniciar Sesión
            </button>

            <div class="forgot-password">
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>
</div>
@endsection