<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taller;
use App\Models\Categoria;
use App\Models\Tema;
use App\Models\Ponente;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        $talleres = Taller::with(['categoria', 'tema', 'ponente'])->get();
        return view('admin.talleres.index', compact('talleres'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $temas = Tema::all();
        $ponentes = Ponente::all();
        return view('admin.talleres.create', compact('categorias', 'temas', 'ponentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'ponente_id' => 'required|exists:ponentes,id',
            'costo' => 'required|numeric|min:0',
            'fecha' => 'required|date'
        ]);

        Taller::create($request->all());

        return redirect()->route('admin.talleres.index')
            ->with('success', 'Taller creado exitosamente.');
    }

    public function edit(Taller $taller)
    {
        $categorias = Categoria::all();
        $temas = Tema::all();
        $ponentes = Ponente::all();
        return view('admin.talleres.edit', compact('taller', 'categorias', 'temas', 'ponentes'));
    }

    public function update(Request $request, Taller $taller)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'ponente_id' => 'required|exists:ponentes,id',
            'costo' => 'required|numeric|min:0',
            'fecha' => 'required|date'
        ]);

        $taller->update($request->all());

        return redirect()->route('admin.talleres.index')
            ->with('success', 'Taller actualizado exitosamente.');
    }

    public function destroy(Taller $taller)
    {
        $taller->delete();

        return redirect()->route('admin.talleres.index')
            ->with('success', 'Taller eliminado exitosamente.');
    }
}