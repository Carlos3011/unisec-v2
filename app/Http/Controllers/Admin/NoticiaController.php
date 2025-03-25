<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\SeccionNoticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::with('seccionNoticia')->latest('fecha_publicacion')->get();
        return view('admin.noticias.noticia.index', compact('noticias'));
    }

    public function create()
    {
        $secciones = SeccionNoticia::all();
        return view('admin.noticias.noticia.create', compact('secciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seccion_noticias_id' => 'required|exists:seccion_noticias,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'contenido' => 'required|string',
            'autor_noticia' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion_imagen' => 'required|string|max:255',
            'autor_imagen' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date'
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/noticias', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        Noticia::create($data);

        return redirect()->route('admin.noticias.noticia.index')
            ->with('success', 'Noticia creada exitosamente');
    }

    public function edit(Noticia $noticia)
    {
        $secciones = SeccionNoticia::all();
        return view('admin.noticias.noticia.edit', compact('noticia', 'secciones'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        $request->validate([
            'seccion_noticias_id' => 'required|exists:seccion_noticias,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'contenido' => 'required|string',
            'autor_noticia' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion_imagen' => 'required|string|max:255',
            'autor_imagen' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date'
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                Storage::delete('public/noticias/' . $noticia->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/noticias', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        $noticia->update($data);

        return redirect()->route('admin.noticias.noticia.index')
            ->with('success', 'Noticia actualizada exitosamente');
    }

    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagen) {
            Storage::delete('public/noticias/' . $noticia->imagen);
        }

        $noticia->delete();

        return redirect()->route('admin.noticias.noticia.index')
            ->with('success', 'Noticia eliminada exitosamente');
    }
}