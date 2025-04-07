<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\SeccionNoticia;
use Illuminate\Http\Request;


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
            'seccion_id' => 'required|exists:seccion_noticias,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'contenido' => 'required|string',
            'autor_noticia' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion_imagen' => 'required|string|max:255',
            'autor_imagen' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date_format:Y-m-d'
        ]);

        $data = $request->except(['imagen']);
        $data['seccion_noticias_id'] = $request->seccion_id;

        // En el método store
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $directory = public_path('images/noticias');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $image->getClientOriginalExtension();
            $image->move($directory, $randomName);
            $data['imagen'] = 'images/noticias/' . $randomName;
        }

        $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $image->getClientOriginalExtension();
        $image->move($directory, $randomName);
        $data['imagen'] = 'images/noticias/' . $randomName;

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
            'seccion_id' => 'required|exists:seccion_noticias,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'contenido' => 'required|string',
            'autor_noticia' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion_imagen' => 'required|string|max:255',
            'autor_imagen' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date_format:Y-m-d'
        ]);

        $data = $request->except(['imagen']);
        $data['seccion_noticias_id'] = $request->seccion_id;

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                if (file_exists(public_path($noticia->imagen))) {
                    unlink(public_path($noticia->imagen));
                }
            }
            // Directorio ya se crea automáticamente en el método de almacenamiento
            $image = $request->file('imagen');
            $directory = public_path('images/noticias');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $image->getClientOriginalExtension();
            $image->move($directory, $randomName);
            $data['imagen'] = 'images/noticias/' . $randomName;
        }

        $noticia->update($data);

        return redirect()->route('admin.noticias.noticia.index')
            ->with('success', 'Noticia actualizada exitosamente');
    }

    public function destroy(Noticia $noticia)
    {

        if ($noticia->imagen && file_exists(public_path($noticia->imagen))) {
    unlink(public_path($noticia->imagen));
}

$noticia->delete();

        return redirect()->route('admin.noticias.noticia.index')
            ->with('success', 'Noticia eliminada exitosamente');
    }
}