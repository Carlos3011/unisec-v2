<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\Concurso;
use App\Models\Categoria;
use App\Models\ConvocatoriaConcurso;
use Illuminate\Http\Request;

class ConcursoUserController extends Controller
{
    public function index()
    {
        $concursos = Concurso::with(['categoria', 'convocatorias'])
            ->where('estado', 'activo')
            ->get();

        return view('user.concursos.index', compact('concursos'));
    }

    public function show(Concurso $concurso)
    {
        if ($concurso->estado !== 'activo') {
            return redirect()->route('user.concursos.index')
                ->with('error', 'El concurso no está disponible.');
        }

        $convocatoria = $concurso->convocatorias->first();
        
        return view('user.concursos.show', compact('concurso', 'convocatoria'));
    }

    public function showConvocatoria(Concurso $concurso)
    {
        if ($concurso->estado !== 'activo') {
            return redirect()->route('user.concursos.index')
                ->with('error', 'El concurso no está disponible.');
        }

        $convocatoria = $concurso->convocatorias->first();
        if (!$convocatoria) {
            return redirect()->route('user.concursos.show', $concurso)
                ->with('error', 'La convocatoria no está disponible.');
        }

        return view('user.concursos.convocatoria', compact('concurso', 'convocatoria'));
    }

    public function filterByCategoria(Request $request)
    {
        $categoria_id = $request->input('categoria_id');
        
        $concursos = Concurso::with(['categoria'])
            ->where('estado', 'activo')
            ->when($categoria_id, function($query) use ($categoria_id) {
                return $query->where('categoria_id', $categoria_id);
            })
            ->get();

        return response()->json($concursos);
    }
}