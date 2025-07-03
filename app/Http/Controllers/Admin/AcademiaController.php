<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academia;
use Illuminate\Http\Request;

class AcademiaController extends Controller
{
    public function index()
    {
        $academias = Academia::all();
        return view('admin.academias.index', compact('academias'));
    }

    public function create()
    {
        return view('admin.academias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:academias',
        ]);

        Academia::create($request->all());

        return redirect()->route('admin.academias.index')
                         ->with('success', 'Academia creada exitosamente.');
    }

    public function show(Academia $academia)
    {
        return view('admin.academias.show', compact('academia'));
    }

    public function edit(Academia $academia)
    {
        return view('admin.academias.edit', compact('academia'));
    }

    public function update(Request $request, Academia $academia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:academias,email,' . $academia->id,
        ]);

        $academia->update($request->all());

        return redirect()->route('admin.academias.index')
                         ->with('success', 'Academia actualizada exitosamente.');
    }

    public function destroy(Academia $academia)
    {
        $academia->delete();

        return redirect()->route('admin.academias.index')
                         ->with('success', 'Academia eliminada exitosamente.');
    }
}
