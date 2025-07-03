<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Curso;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()->with(['videos' => function($query) {
            $query->orderBy('orden');
        }, 'ciclo'])->get();

        return view('docente.videos.index', compact('cursosAsignados'));
    }

    public function create()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $cursosAsignados = $docente->cursosAsignados()->with('ciclo')->get();
        
        return view('docente.videos.create', compact('cursosAsignados'));
    }

    public function store(Request $request)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('login')->with('error', 'Acceso denegado');
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'url_youtube' => 'required|url',
            'curso_id' => 'required|exists:curso,id',
            'orden' => 'required|integer|min:1',
            'duracion' => 'nullable|string|max:20'
        ]);

        // Validar que sea una URL de YouTube válida
        if (!$this->esUrlYoutubeValida($validatedData['url_youtube'])) {
            return redirect()->back()->withErrors(['url_youtube' => 'La URL debe ser de YouTube (youtube.com o youtu.be)'])->withInput();
        }

        // Verificar que el docente esté asignado al curso
        if (!$docente->cursosAsignados()->where('id', $validatedData['curso_id'])->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para agregar videos a este curso');
        }

        // Extraer video ID de YouTube
        $videoId = $this->extraerVideoIdYoutube($validatedData['url_youtube']);
        
        if (!$videoId) {
            return redirect()->back()->with('error', 'URL de YouTube no válida');
        }

        Video::create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'url_youtube' => $validatedData['url_youtube'],
            'video_id_youtube' => $videoId,
            'curso_id' => $validatedData['curso_id'],
            'orden' => $validatedData['orden'],
            'duracion' => $validatedData['duracion'],
            'estado' => 'activo'
        ]);

        return redirect()->route('docente.videos.index')
                         ->with('success', 'Video agregado exitosamente.');
    }

    public function show(Video $video)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $video->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este video');
        }

        return view('docente.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $video->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para editar este video');
        }

        $cursosAsignados = $docente->cursosAsignados()->with('ciclo')->get();
        
        return view('docente.videos.edit', compact('video', 'cursosAsignados'));
    }

    public function update(Request $request, Video $video)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $video->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para editar este video');
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'url_youtube' => 'required|url',
            'curso_id' => 'required|exists:curso,id',
            'orden' => 'required|integer|min:1',
            'duracion' => 'nullable|string|max:20',
            'estado' => 'required|in:activo,inactivo'
        ]);

        // Validar que sea una URL de YouTube válida
        if (!$this->esUrlYoutubeValida($validatedData['url_youtube'])) {
            return redirect()->back()->withErrors(['url_youtube' => 'La URL debe ser de YouTube (youtube.com o youtu.be)'])->withInput();
        }

        // Verificar que el docente esté asignado al nuevo curso
        if (!$docente->cursosAsignados()->where('id', $validatedData['curso_id'])->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para mover este video a ese curso');
        }

        // Extraer video ID de YouTube
        $videoId = $this->extraerVideoIdYoutube($validatedData['url_youtube']);
        
        if (!$videoId) {
            return redirect()->back()->with('error', 'URL de YouTube no válida');
        }

        $video->update([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'url_youtube' => $validatedData['url_youtube'],
            'video_id_youtube' => $videoId,
            'curso_id' => $validatedData['curso_id'],
            'orden' => $validatedData['orden'],
            'duracion' => $validatedData['duracion'],
            'estado' => $validatedData['estado']
        ]);

        return redirect()->route('docente.videos.index')
                         ->with('success', 'Video actualizado exitosamente.');
    }

    public function destroy(Video $video)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $video->curso_id)->exists()) {
            return redirect()->back()->with('error', 'No tiene permisos para eliminar este video');
        }

        $video->delete();

        return redirect()->route('docente.videos.index')
                         ->with('success', 'Video eliminado exitosamente.');
    }

    public function verVideosPorCurso(Curso $curso)
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente || !$docente->cursosAsignados()->where('id', $curso->id)->exists()) {
            return redirect()->back()->with('error', 'No tiene acceso a este curso');
        }

        $videos = $curso->videos()->orderBy('orden')->get();
        
        return view('docente.videos.por-curso', compact('curso', 'videos'));
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

    protected function extraerVideoIdYoutube($url)
    {
        $pattern = '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/';
        
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    protected function esUrlYoutubeValida($url)
    {
        return strpos($url, 'youtube.com/watch?v=') !== false || 
               strpos($url, 'youtu.be/') !== false;
    }
}