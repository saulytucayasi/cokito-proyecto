<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $credentials['email'])->first();

        if ($usuario && Hash::check($credentials['password'], $usuario->password)) {
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                $user = User::create([
                    'id' => $usuario->id,
                    'name' => $usuario->usuario,
                    'email' => $credentials['email'],
                    'password' => Hash::make($credentials['password'])
                ]);
            }
            
            Auth::login($user);
            
            switch ($usuario->rol) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'docente':
                    return redirect('/docente/dashboard');
                case 'secretaria':
                    return redirect('/secretaria/dashboard');
                case 'estudiante':
                    return redirect('/estudiante/dashboard');
                default:
                    return redirect('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
}
