<?php

namespace App\Http\Controllers\Admin\Concurso;

use App\Http\Controllers\Controller;
use App\Models\Concurso;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ConcursoController extends Controller
{
    public function index()
    {
        $concursos = Concurso::with(['categoria', 'inscripciones'])
        ->withCount(['inscripciones as inscritos_count', 'preRegistros as preregistrados_count'])
        ->get();
        $categorias = Categoria::all();
        return view('admin.concursos.index', compact('concursos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.concursos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'string|in:pendiente,activo,inactivo'
        ]);

        $data = $request->only(['titulo', 'categoria_id', 'estado']);
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
        return view('admin.concursos.edit', compact('concurso', 'categorias'));
    }

    public function update(Request $request, Concurso $concurso)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'string|in:pendiente,activo,inactivo'
        ]);

        $concurso->update($request->only(['titulo', 'categoria_id', 'estado']));

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