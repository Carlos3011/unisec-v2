<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeccionNoticia;
use Illuminate\Http\Request;

class SeccionNoticiaController extends Controller
{
    public function index()
    {
        $secciones = SeccionNoticia::withCount('noticias')->get();
        return view('admin.noticias.secciones.index', compact('secciones'));
    }

    public function create()
    {
        return view('admin.noticias.secciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255|unique:seccion_noticias'
        ]);

        SeccionNoticia::create($request->all());

        return redirect()->route('admin.noticias.secciones.index')
            ->with('success', 'Sección creada exitosamente');
    }

    public function edit(SeccionNoticia $seccion)
    {
        return view('admin.noticias.secciones.edit', compact('seccion'));
    }

    public function update(Request $request, SeccionNoticia $seccion)
    {
        $request->validate([
            'titulo' => 'required|string|max:255|unique:seccion_noticias,titulo,' . $seccion->id
        ]);

        $seccion->update($request->all());

        return redirect()->route('admin.noticias.secciones.index')
            ->with('success', 'Sección actualizada exitosamente');
    }

    public function destroy(SeccionNoticia $seccion)
    {
        if ($seccion->noticias()->count() > 0) {
            return redirect()->route('admin.noticias.secciones.index')
                ->with('error', 'No se puede eliminar una sección que tiene noticias asociadas');
        }

        $seccion->delete();

        return redirect()->route('admin.noticias.secciones.index')
            ->with('success', 'Sección eliminada exitosamente');
    }
}