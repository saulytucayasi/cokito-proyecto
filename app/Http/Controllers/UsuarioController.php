<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuario,email',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|string|in:admin,docente,secretaria,estudiante',
        ]);

        Usuario::create([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(Usuario $usuario)
    {
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuario,email,' . $usuario->id,
            'rol' => 'required|string|in:admin,docente,secretaria,estudiante',
        ]);

        $usuario->update([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'rol' => $request->rol,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}