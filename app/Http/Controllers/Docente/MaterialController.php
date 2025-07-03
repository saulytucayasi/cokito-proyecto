<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Curso;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    public function index()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()->with(['materiales' => function($query) use ($docente) {
            $query->orderBy('orden');
        }, 'ciclo'])->get();

        return view('docente.materiales.index', compact('cursosAsignados'));
    }

    public function create()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()->with('ciclo')->get();
        
        return view('docente.materiales.create', compact('cursosAsignados'));
    }

    public function store(Request $request)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $validatedData = $request->validate([
            'nombre_material' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:documento,video,imagen,archivo',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:curso,id',
            'es_publico' => 'boolean',
            'material_file' => 'required|file|max:51200', // 50MB
        ]);

        // Verificar que el docente esté asignado al curso
        if (!$docente->cursosAsignados()->where('id', $validatedData['curso_id'])->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para subir materiales a este curso');
        }

        $path = $request->file('material_file')->store('materiales', 'public');

        $material = Material::create([
            'nombre_material' => $validatedData['nombre_material'],
            'descripcion' => $validatedData['descripcion'],
            'tipo' => $validatedData['tipo'],
            'path_material' => $path,
            'orden' => $validatedData['orden'],
            'curso_id' => $validatedData['curso_id'],
            'es_publico' => $request->has('es_publico'),
            'subido_por' => $docente->id,
        ]);

        return redirect()->route('docente.materiales.index')
                         ->with('success', 'Material subido exitosamente.');
    }

    public function show(Material $material)
    {
        return view('docente.materiales.show', compact('material'));
    }

    public function edit($id)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Buscar el material por ID
        $material = Material::find($id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado');
        }

        $cursosDocenteIds = $docente->cursosAsignados()->pluck('id')->toArray();
        $materialCursoId = $material->curso_id;
        
        // Debug extra
        \Log::info('Material debug', [
            'material_id' => $material->id,
            'material_curso_id' => $materialCursoId,
            'material_nombre' => $material->nombre_material,
            'docente_id' => $docente->id,
            'cursos_docente' => $cursosDocenteIds
        ]);
        
        if (!in_array($materialCursoId, $cursosDocenteIds)) {
            return redirect()->back()->with('error', 
                'No tiene permisos para editar este material. ' .
                'Material ID: ' . $material->id . 
                ', Material curso ID: ' . ($materialCursoId ?? 'NULL') . 
                ', Sus cursos asignados: ' . implode(', ', $cursosDocenteIds) .
                ', Docente ID: ' . $docente->id
            );
        }

        $cursosAsignados = $docente->cursosAsignados()->with('ciclo')->get();
        return view('docente.materiales.edit', compact('material', 'cursosAsignados'));
    }

    public function update(Request $request, $id)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Buscar el material por ID
        $material = Material::find($id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado');
        }

        $validatedData = $request->validate([
            'nombre_material' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|string|in:documento,presentacion,imagen,video,audio,otro',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:curso,id',
            'es_publico' => 'boolean',
            'material_file' => 'nullable|file|max:51200', // 50MB
        ]);

        // Verificar que el docente esté asignado al curso
        if (!$docente->cursosAsignados()->where('id', $validatedData['curso_id'])->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para mover este material a ese curso');
        }

        $data = [
            'nombre_material' => $validatedData['nombre_material'],
            'descripcion' => $validatedData['descripcion'],
            'tipo' => $validatedData['tipo'],
            'orden' => $validatedData['orden'],
            'curso_id' => $validatedData['curso_id'],
            'es_publico' => $request->has('es_publico'),
        ];

        if ($request->hasFile('material_file')) {
            // Eliminar archivo antiguo si existe
            if ($material->path_material && Storage::disk('public')->exists($material->path_material)) {
                Storage::disk('public')->delete($material->path_material);
            }
            $data['path_material'] = $request->file('material_file')->store('materiales', 'public');
        }

        $material->update($data);

        return redirect()->route('docente.materiales.index')
                         ->with('success', 'Material actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        // Buscar el material por ID
        $material = Material::find($id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado');
        }

        // Verificar permisos (docente asignado al curso del material)
        if (!$docente->cursosAsignados()->where('id', $material->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para eliminar este material');
        }

        if ($material->path_material && Storage::disk('public')->exists($material->path_material)) {
            Storage::disk('public')->delete($material->path_material);
        }
        
        $material->delete();

        return redirect()->route('docente.materiales.index')
                         ->with('success', 'Material eliminado exitosamente.');
    }

    protected function getDocenteActual()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        // Buscar usuario en tabla usuario por email
        $usuario = \App\Models\Usuario::where('email', $user->email)->first();
        
        if (!$usuario) {
            return null;
        }

        // Buscar trabajador por usuario_id que corresponde al ID de la tabla usuario
        return Trabajador::where('usuario_id', $usuario->id)->first();
    }

    public function verMaterialesPorCurso(Curso $curso)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este curso');
        }

        $materiales = $curso->materiales()->orderBy('orden')->get();
        
        return view('docente.materiales.por-curso', compact('curso', 'materiales'));
    }
}
