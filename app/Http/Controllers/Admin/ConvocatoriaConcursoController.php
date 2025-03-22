<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConvocatoriaConcurso;
use App\Models\FechaImportanteConcurso;
use App\Models\ImagenConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvocatoriaConcursoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $convocatorias = ConvocatoriaConcurso::with(['fechasImportantes', 'imagenes'])
            ->when($search, function($query) use ($search) {
                return $query->where('nombre_evento', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();
        
        return view('admin.convocatorias.index', compact('convocatorias', 'search'));
    }

    public function create()
    {
        return view('admin.convocatorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_evento' => 'required|string|max:255',
            'sede' => 'required|string|max:255',
            'dirigido_a' => 'required|string|max:255',
            'max_integrantes' => 'required|integer|min:1',
            'asesor_requerido' => 'required|boolean',
            'requisitos' => 'required|string',
            'etapas_mision' => 'required|string',
            'pruebas_requeridas' => 'required|string',
            'documentacion_requerida' => 'required|string',
            'criterios_evaluacion' => 'required|string',
            'premiacion' => 'nullable|string',
            'penalizaciones' => 'nullable|string',
            'contacto_email' => 'nullable|email',
            'archivo_convocatoria' => 'nullable|mimes:pdf|max:10240',
            'imagen_portada' => 'nullable|image|max:2048',
            'archivo_pdr' => 'nullable|mimes:pdf|max:10240',
            'archivo_cdr' => 'nullable|mimes:pdf|max:10240',
            'archivo_pfr' => 'nullable|mimes:pdf|max:10240',
            'archivo_articulo' => 'nullable|mimes:pdf|max:10240',
            'fechas_importantes' => 'required|array',
            'fechas_importantes.*.titulo' => 'required|string',
            'fechas_importantes.*.fecha' => 'required|date',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|max:2048'
        ]);

        $convocatoria = new ConvocatoriaConcurso($request->except([
            'archivo_convocatoria', 'imagen_portada', 'archivo_pdr', 'archivo_cdr', 'archivo_pfr',
            'archivo_articulo','fechas_importantes', 'imagenes'
        ]));

        // Manejar archivos
        if ($request->hasFile('archivo_convocatoria')) {
            Storage::disk('public')->makeDirectory('convocatorias/convocatoria');
            $convocatoria->archivo_convocatoria = $request->file('archivo_convocatoria')->store('convocatorias/convocatoria', 'public');
        }
        if ($request->hasFile('imagen_portada')) {
            Storage::disk('public')->makeDirectory('convocatorias/portada');
            $path = $request->file('imagen_portada')->store('convocatorias/portada', 'public');
            if ($path) {
                $convocatoria->imagen_portada = $path;
            }
        }
        if ($request->hasFile('archivo_pdr')) {
            Storage::disk('public')->makeDirectory('convocatorias/pdr');
            $convocatoria->archivo_pdr = $request->file('archivo_pdr')->store('convocatorias/pdr', 'public');
        }
        if ($request->hasFile('archivo_cdr')) {
            Storage::disk('public')->makeDirectory('convocatorias/cdr');
            $convocatoria->archivo_cdr = $request->file('archivo_cdr')->store('convocatorias/cdr', 'public');
        }
        if ($request->hasFile('archivo_pfr')) {
            Storage::disk('public')->makeDirectory('convocatorias/pfr');
            $convocatoria->archivo_pfr = $request->file('archivo_pfr')->store('convocatorias/pfr', 'public');
        }
        if ($request->hasFile('archivo_articulo')) {
            Storage::disk('public')->makeDirectory('convocatorias/articulo');
            $convocatoria->archivo_articulo = $request->file('archivo_articulo')->store('convocatorias/articulo', 'public');
        }

        $convocatoria->save();

        // Guardar fechas importantes
        foreach ($request->fechas_importantes as $fecha) {
            $convocatoria->fechasImportantes()->create([
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        // Guardar imágenes adicionales
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('convocatorias/imagenes', 'public');
                $convocatoria->imagenes()->create([
                    'imagen' => $path,
                    'descripcion' => 'Imagen adicional de la convocatoria'
                ]);
            }
        }

        return redirect()->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria creada exitosamente');
    }

    public function show(ConvocatoriaConcurso $convocatoria)
    {
        return view('admin.convocatorias.show', compact('convocatoria'));
    }

    public function edit(ConvocatoriaConcurso $convocatoria)
    {
        return view('admin.convocatorias.edit', compact('convocatoria'));
    }

    public function update(Request $request, ConvocatoriaConcurso $convocatoria)
    {
        $request->validate([
            'nombre_evento' => 'required|string|max:255',
            'sede' => 'required|string|max:255',
            'dirigido_a' => 'required|string|max:255',
            'max_integrantes' => 'required|integer|min:1',
            'asesor_requerido' => 'required|boolean',
            'requisitos' => 'required|string',
            'etapas_mision' => 'required|string',
            'pruebas_requeridas' => 'required|string',
            'documentacion_requerida' => 'required|string',
            'criterios_evaluacion' => 'required|string',
            'premiacion' => 'nullable|string',
            'penalizaciones' => 'nullable|string',
            'contacto_email' => 'nullable|email',
            'fechas_importantes' => 'required|array',
            'fechas_importantes.*.titulo' => 'required|string',
            'fechas_importantes.*.fecha' => 'required|date'
        ]);

        $convocatoria->update($request->except([
            'archivo_convocatoria', 'imagen_portada', 'archivo_pdr', 'archivo_cdr', 'archivo_pfr','archivo_articulo'
        ]));

        // Actualizar archivos si se proporcionan nuevos
        if ($request->hasFile('archivo_convocatoria')) {
            if ($convocatoria->archivo_convocatoria && Storage::disk('public')->exists($convocatoria->archivo_convocatoria)) {
                Storage::disk('public')->delete($convocatoria->archivo_convocatoria);
            }
            $convocatoria->archivo_convocatoria = $request->file('archivo_convocatoria')->store('convocatorias/pdf', 'public');
        }
        if ($request->hasFile('imagen_portada')) {
            if ($convocatoria->imagen_portada && Storage::disk('public')->exists($convocatoria->imagen_portada)) {
                Storage::disk('public')->delete($convocatoria->imagen_portada);
            }
            Storage::disk('public')->makeDirectory('convocatorias/portada');
            $convocatoria->imagen_portada = $request->file('imagen_portada')->store('convocatorias/portada', 'public');
        }
        if ($request->hasFile('archivo_pdr')) {
            if ($convocatoria->archivo_pdr && Storage::disk('public')->exists($convocatoria->archivo_pdr)) {
                Storage::disk('public')->delete($convocatoria->archivo_pdr);
            }
            $convocatoria->archivo_pdr = $request->file('archivo_pdr')->store('convocatorias/pdr', 'public');
        }
        if ($request->hasFile('archivo_cdr')) {
            if ($convocatoria->archivo_cdr && Storage::disk('public')->exists($convocatoria->archivo_cdr)) {
                Storage::disk('public')->delete($convocatoria->archivo_cdr);
            }
            $convocatoria->archivo_cdr = $request->file('archivo_cdr')->store('convocatorias/cdr', 'public');
        }
        if ($request->hasFile('archivo_pfr')) {
            if ($convocatoria->archivo_pfr && Storage::disk('public')->exists($convocatoria->archivo_pfr)) {
                Storage::disk('public')->delete($convocatoria->archivo_pfr);
            }
            $convocatoria->archivo_pfr = $request->file('archivo_pfr')->store('convocatorias/pfr', 'public');
        }
        if ($request->hasFile('archivo_articulo')) {
            if ($convocatoria->archivo_articulo && Storage::disk('public')->exists($convocatoria->archivo_articulo)) {
                Storage::disk('public')->delete($convocatoria->archivo_articulo);
            }
            $convocatoria->archivo_articulo = $request->file('archivo_articulo')->store('convocatorias/articulo', 'public');
        }

        $convocatoria->save();

        return redirect()->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria actualizada exitosamente');
    }

    public function destroy(ConvocatoriaConcurso $convocatoria)
    {
        try {
            \DB::beginTransaction();
            
            // Eliminar archivos asociados si existen
            $archivos = [
                $convocatoria->archivo_convocatoria,
                $convocatoria->imagen_portada,
                $convocatoria->archivo_pdr,
                $convocatoria->archivo_cdr,
                $convocatoria->archivo_pfr,
                $convocatoria->archivo_articulo
            ];
            
            foreach ($archivos as $archivo) {
                if ($archivo) {
                    Storage::disk('public')->delete($archivo);
                }
            }

            // Eliminar imágenes adicionales
            foreach ($convocatoria->imagenes as $imagen) {
                if ($imagen->imagen) {
                    Storage::disk('public')->delete($imagen->imagen);
                }
            }

            $convocatoria->delete();
            \DB::commit();

            return response()->json(['message' => 'Convocatoria eliminada exitosamente']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => 'Error al eliminar la convocatoria'], 500);
        }
    }
}