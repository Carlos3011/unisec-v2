<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FechaImportante;
use Illuminate\Http\Request;

class FechaImportanteController extends Controller
{
    public function index()
    {
        $fechasImportantes = FechaImportante::with('convocatoria')->latest()->paginate(10);
        return view('admin.fechas-importantes.index', compact('fechasImportantes'));
    }

    public function create()
    {
        return view('admin.fechas-importantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'convocatoria_id' => 'required|exists:convocatorias,id',
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date'
        ]);

        FechaImportante::create($request->all());

        return redirect()->route('admin.fechas-importantes.index')
            ->with('success', 'Fecha importante creada exitosamente.');
    }

    public function show(FechaImportante $fechaImportante)
    {
        return view('admin.fechas-importantes.show', compact('fechaImportante'));
    }

    public function edit(FechaImportante $fechaImportante)
    {
        return view('admin.fechas-importantes.edit', compact('fechaImportante'));
    }

    public function update(Request $request, FechaImportante $fechaImportante)
    {
        $request->validate([
            'convocatoria_id' => 'required|exists:convocatorias,id',
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date'
        ]);

        $fechaImportante->update($request->all());

        return redirect()->route('admin.fechas-importantes.index')
            ->with('success', 'Fecha importante actualizada exitosamente.');
    }

    public function destroy(FechaImportante $fechaImportante)
    {
        $fechaImportante->delete();

        return redirect()->route('admin.fechas-importantes.index')
            ->with('success', 'Fecha importante eliminada exitosamente.');
    }
}