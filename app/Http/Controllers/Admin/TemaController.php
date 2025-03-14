<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tema;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    public function index()
    {
        $temas = Tema::all();
        return view('admin.temas.index', compact('temas'));
    }

    public function create()
    {
        return view('admin.temas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string'
        ]);

        Tema::create($request->all());

        return redirect()->route('admin.temas.index')
            ->with('success', 'Tema creado exitosamente.');
    }

    public function edit(Tema $tema)
    {
        return view('admin.temas.edit', compact('tema'));
    }

    public function update(Request $request, Tema $tema)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string'
        ]);

        $tema->update($request->all());

        return redirect()->route('admin.temas.index')
            ->with('success', 'Tema actualizado exitosamente.');
    }

    public function destroy(Tema $tema)
    {
        $tema->delete();

        return redirect()->route('admin.temas.index')
            ->with('success', 'Tema eliminado exitosamente.');
    }
}