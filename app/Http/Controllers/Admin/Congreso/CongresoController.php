<?php

namespace App\Http\Controllers\Admin\Congreso;

use App\Http\Controllers\Controller;
use App\Models\Congreso;
use Illuminate\Http\Request;

class CongresoController extends Controller
{
    public function index()
    {
        $congresos = Congreso::with(['convocatorias', 'articulos', 'pagosInscripcion'])
            ->withCount(['convocatorias as convocatorias_count', 'articulos as articulos_count'])
            ->get();
        return view('admin.congresos.index', compact('congresos'));
    }

    public function create()
    {
        return view('admin.congresos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'string|in:activo,inactivo,pendiente'
        ]);

        $data = $request->only([
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'estado'
        ]);

        if (!isset($data['estado'])) {
            $data['estado'] = 'pendiente';
        }

        Congreso::create($data);

        return redirect()->route('admin.congresos.index')
            ->with('success', 'Congreso creado exitosamente.');
    }

    public function show(Congreso $congreso)
    {
        $congreso->load(['convocatorias', 'articulos', 'pagosInscripcion']);
        return view('admin.congresos.show', compact('congreso'));
    }

    public function edit(Congreso $congreso)
    {
        return view('admin.congresos.edit', compact('congreso'));
    }

    public function update(Request $request, Congreso $congreso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'string|in:activo,inactivo,pendiente'
        ]);

        $congreso->update($request->only([
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'estado'
        ]));

        return redirect()->route('admin.congresos.index')
            ->with('success', 'Congreso actualizado exitosamente.');
    }

    public function destroy(Congreso $congreso)
    {
        $congreso->delete();

        return redirect()->route('admin.congresos.index')
            ->with('success', 'Congreso eliminado exitosamente.');
    }
}