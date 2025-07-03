<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Curso;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('curso.ciclo')->orderBy('curso_id')->orderBy('orden')->paginate(15);
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        $cursos = Curso::with('ciclo')->get();
        return view('videos.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'url_youtube' => 'required|url|regex:/^(https?\:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)/',
            'curso_id' => 'required|exists:curso,id',
            'orden' => 'required|integer|min:1',
            'duracion' => 'nullable|string|max:20'
        ]);

        Video::create($request->all());

        return redirect()->route('videos.index')->with('success', 'Video agregado exitosamente');
    }

    public function show($id)
    {
        $video = Video::with('curso.ciclo')->findOrFail($id);
        return view('videos.show', compact('video'));
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $cursos = Curso::with('ciclo')->get();
        return view('videos.edit', compact('video', 'cursos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'url_youtube' => 'required|url|regex:/^(https?\:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)/',
            'curso_id' => 'required|exists:curso,id',
            'orden' => 'required|integer|min:1',
            'duracion' => 'nullable|string|max:20'
        ]);

        $video = Video::findOrFail($id);
        $video->update($request->all());

        return redirect()->route('videos.index')->with('success', 'Video actualizado exitosamente');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video eliminado exitosamente');
    }

    public function porCurso($cursoId)
    {
        $curso = Curso::with('ciclo')->findOrFail($cursoId);
        $videos = Video::where('curso_id', $cursoId)
            ->where('estado', 'activo')
            ->orderBy('orden')
            ->get();

        return view('videos.por-curso', compact('curso', 'videos'));
    }
}
