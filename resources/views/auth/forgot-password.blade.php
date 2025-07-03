@extends('layouts.app')

@section('title', 'Recuperar Contraseña - COKITO+ Academia')

@section('content')
<style>
    .forgot-container {
        min-height: 100vh;
        background: var(--gradient-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .forgot-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        padding: 3rem;
        width: 100%;
        max-width: 400px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-blue);
        text-decoration: none;
        margin-bottom: 2rem;
        font-size: 0.875rem;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="forgot-container">
    <div class="forgot-card">
        <a href="{{ route('login') }}" class="back-link">
            ← Volver al inicio de sesión
        </a>

        <div class="login-logo">
            <h1>Recuperar Contraseña</h1>
            <p>Te enviaremos un enlace para restablecer tu contraseña</p>
        </div>

        <form method="POST" action="#">
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

            <button type="submit" class="login-btn">
                Enviar enlace de recuperación
            </button>
        </form>
    </div>
</div>
@endsection