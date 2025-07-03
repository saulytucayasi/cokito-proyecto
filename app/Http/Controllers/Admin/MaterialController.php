<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::all();
        return view('admin.materiales.index', compact('materiales'));
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('admin.materiales.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:documento,video,enlace',
            'curso_id' => 'required|exists:cursos,id',
            'archivo' => 'nullable|file|max:102400',
            'enlace' => 'nullable|url|max:255',
        ]);

        $data = $request->all();

        if ($request->tipo === 'enlace') {
            $data['ruta_archivo'] = $request->enlace;
        } elseif ($request->hasFile('archivo')) {
            $data['ruta_archivo'] = $request->file('archivo')->store('materiales', 'public');
        }

        Material::create($data);

        return redirect()->route('admin.materiales.index')
                         ->with('success', 'Material creado exitosamente.');
    }

    public function show(Material $material)
    {
        return view('admin.materiales.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $cursos = Curso::all();
        return view('admin.materiales.edit', compact('material', 'cursos'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:documento,video,enlace',
            'curso_id' => 'required|exists:cursos,id',
            'archivo' => 'nullable|file|max:102400',
            'enlace' => 'nullable|url|max:255',
        ]);

        $data = $request->all();

        if ($request->tipo === 'enlace') {
            $data['ruta_archivo'] = $request->enlace;
        } elseif ($request->hasFile('archivo')) {
            if ($material->ruta_archivo && Storage::disk('public')->exists($material->ruta_archivo)) {
                Storage::disk('public')->delete($material->ruta_archivo);
            }
            $data['ruta_archivo'] = $request->file('archivo')->store('materiales', 'public');
        } else {
            unset($data['ruta_archivo']);
        }

        $material->update($data);

        return redirect()->route('admin.materiales.index')
                         ->with('success', 'Material actualizado exitosamente.');
    }

    public function destroy(Material $material)
    {
        if ($material->ruta_archivo && $material->tipo !== 'enlace' && Storage::disk('public')->exists($material->ruta_archivo)) {
            Storage::disk('public')->delete($material->ruta_archivo);
        }
        $material->delete();

        return redirect()->route('admin.materiales.index')
                         ->with('success', 'Material eliminado exitosamente.');
    }
}
