<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\CursoEstudiante;
use App\Models\Curso;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::with('cursoEstudiante.curso')->paginate(15);
        return view('materiales.index', compact('materiales'));
    }

    public function create()
    {
        $cursos = Curso::with('ciclo')->get();
        return view('materiales.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_material' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,avi|max:10240', // 10MB max
            'curso_estudiante_id' => 'required|exists:curso_estudiante,id',
            'orden' => 'required|integer|min:1'
        ]);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/materiales', $fileName, 'public');

            Material::create([
                'nombre_material' => $request->nombre_material,
                'path_material' => $filePath,
                'orden' => $request->orden,
                'curso_estudiante_id' => $request->curso_estudiante_id
            ]);

            return redirect()->back()->with('success', 'Material subido exitosamente');
        }

        return redirect()->back()->with('error', 'Error al subir el archivo');
    }

    public function download($id)
    {
        $material = Material::findOrFail($id);
        $filePath = storage_path('app/public/' . $material->path_material);

        if (file_exists($filePath)) {
            return response()->download($filePath, $material->nombre_material);
        }

        return redirect()->back()->with('error', 'Archivo no encontrado');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        
        if (Storage::disk('public')->exists($material->path_material)) {
            Storage::disk('public')->delete($material->path_material);
        }
        
        $material->delete();
        
        return redirect()->back()->with('success', 'Material eliminado exitosamente');
    }

    public function porCurso($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $materiales = Material::whereHas('cursoEstudiante', function($query) use ($cursoId) {
            $query->where('curso_id', $cursoId);
        })->with('cursoEstudiante.estudiante')->get();

        return view('materiales.por-curso', compact('curso', 'materiales'));
    }
}
