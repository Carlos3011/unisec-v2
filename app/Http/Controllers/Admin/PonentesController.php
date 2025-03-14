<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ponente;
use Illuminate\Http\Request;

class PonentesController extends Controller
{
    public function index()
    {
        $ponentes = Ponente::all();
        return view('admin.ponentes.index', compact('ponentes'));
    }

    public function create()
    {
        return view('admin.ponentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'bio' => 'required|string',
            'especialidad' => 'required|string|max:255'
        ]);

        Ponente::create($request->all());

        return redirect()->route('admin.ponentes.index')
            ->with('success', 'Ponente creado exitosamente.');
    }

    public function edit(Ponente $ponente)
    {
        return view('admin.ponentes.edit', compact('ponente'));
    }

    public function update(Request $request, Ponente $ponente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'bio' => 'required|string',
            'especialidad' => 'required|string|max:255'
        ]);

        $ponente->update($request->all());

        return redirect()->route('admin.ponentes.index')
            ->with('success', 'Ponente actualizado exitosamente.');
    }

    public function destroy(Ponente $ponente)
    {
        $ponente->delete();

        return redirect()->route('admin.ponentes.index')
            ->with('success', 'Ponente eliminado exitosamente.');
    }
}