<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concurso;
use App\Models\Categoria;
use App\Models\Tema;
use Illuminate\Http\Request;

class ConcursoController extends Controller
{
    public function index()
    {
        $concursos = Concurso::with(['categoria', 'inscripciones', 'tema'])
        ->withCount('inscripciones as inscritos_count')
        ->get();
        $categorias = Categoria::all();
        $temas = Tema::all();
        return view('admin.concursos.index', compact('concursos', 'categorias', 'temas'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $temas = Tema::all();
        return view('admin.concursos.create', compact('categorias', 'temas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'reglas' => 'required|string',
            'premios' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'string|in:pendiente,activo,inactivo'
        ]);

        $data = $request->all();
        if (!isset($data['estado'])) {
            $data['estado'] = 'pendiente';
        }

        Concurso::create($data);

        return redirect()->route('admin.concursos.index')
            ->with('success', 'Concurso creado exitosamente.');
    }

    public function edit(Concurso $concurso)
    {
        $categorias = Categoria::all();
        $temas = Tema::all();
        return view('admin.concursos.edit', compact('concurso', 'categorias', 'temas'));
    }

    public function update(Request $request, Concurso $concurso)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'reglas' => 'required|string',
            'premios' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'string|in:pendiente,activo,inactivo'
        ]);

        $concurso->update($request->all());

        return redirect()->route('admin.concursos.index')
            ->with('success', 'Concurso actualizado exitosamente.');
    }

    public function destroy(Concurso $concurso)
    {
        $concurso->delete();

        return redirect()->route('admin.concursos.index')
            ->with('success', 'Concurso eliminado exitosamente.');
    }
}