<?php

namespace App\Http\Controllers\Admin\Concurso;

use App\Http\Controllers\Controller;
use App\Models\ConvocatoriaConcurso;
use App\Models\FechaImportanteConcurso;
use App\Models\ImagenConcurso;
use App\Models\Concurso;
use Illuminate\Http\Request;

class ConvocatoriaConcursoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $convocatorias = ConvocatoriaConcurso::with(['fechasImportantes', 'imagenes'])
            ->when($search, function ($query) use ($search) {
                return $query->where('nombre_evento', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();

        return view('admin.concursos.convocatorias.index', compact('convocatorias', 'search'));
    }

    public function create()
    {
        $concursos = Concurso::where('estado', 'activo')->get();
        return view('admin.concursos.convocatorias.create', compact('concursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
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
            'archivo_convocatoria' => 'nullable|mimes:pdf|max:20480',
            'imagen_portada' => 'nullable|image|max:2048',
            'archivo_pdr' => 'nullable|mimes:pdf|max:20480',
            'archivo_cdr' => 'nullable|mimes:pdf|max:20480',
            'archivo_pfr' => 'nullable|mimes:pdf|max:20480',
            'archivo_articulo' => 'nullable|mimes:pdf|max:20480',
            'fechas_importantes' => 'required|array',
            'fechas_importantes.*.titulo' => 'required|string',
            'fechas_importantes.*.fecha' => 'required|date',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|max:2048',
            'costo_pre_registro' => 'nullable|numeric|min:0',
            'costo_inscripcion' => 'nullable|numeric|min:0',
        ]);

        $convocatoria = new ConvocatoriaConcurso($request->except([
            'archivo_convocatoria',
            'imagen_portada',
            'archivo_pdr',
            'archivo_cdr',
            'archivo_pfr',
            'archivo_articulo',
            'fechas_importantes',
            'imagenes'
        ]));

        // Manejar archivos
        if ($request->hasFile('archivo_convocatoria')) {
            $dirConvocatoria = public_path('conv/convocatoria');
            if (!file_exists($dirConvocatoria)) {
                @mkdir($dirConvocatoria, 0755, true);
            }
            $file = $request->file('archivo_convocatoria');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('conv/convocatoria'), $fileName);
            $convocatoria->archivo_convocatoria = 'conv/convocatoria/' . $fileName;
        }
        if ($request->hasFile('imagen_portada')) {
            $dirPortada = public_path('conv/portada');
            if (!file_exists($dirPortada)) {
                @mkdir($dirPortada, 0755, true);
            }
            $image = $request->file('imagen_portada');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('conv/portada'), $imageName);
            $convocatoria->imagen_portada = 'conv/portada/' . $imageName;
        }
        if ($request->hasFile('archivo_pdr')) {
            $dirPdr = public_path('conv/pdr');
            if (!file_exists($dirPdr)) {
                @mkdir($dirPdr, 0755, true);
            }
            $filePdr = $request->file('archivo_pdr');
            $fileNamePdr = time() . '_' . $filePdr->getClientOriginalName();
            $filePdr->move(public_path('conv/pdr'), $fileNamePdr);
            $convocatoria->archivo_pdr = 'conv/pdr/' . $fileNamePdr;
        }
        if ($request->hasFile('archivo_cdr')) {
            $dirCdr = public_path('conv/cdr');
            if (!file_exists($dirCdr)) {
                @mkdir($dirCdr, 0755, true);
            }
            $fileCdr = $request->file('archivo_cdr');
            $fileNameCdr = time() . '_' . $fileCdr->getClientOriginalName();
            $fileCdr->move(public_path('conv/cdr'), $fileNameCdr);
            $convocatoria->archivo_cdr = 'conv/cdr/' . $fileNameCdr;
        }
        if ($request->hasFile('archivo_pfr')) {
            $dirPfr = public_path('conv/pfr');
            if (!file_exists($dirPfr)) {
                @mkdir($dirPfr, 0755, true);
            }
            $filePfr = $request->file('archivo_pfr');
            $fileNamePfr = time() . '_' . $filePfr->getClientOriginalName();
            $filePfr->move(public_path('conv/pfr'), $fileNamePfr);
            $convocatoria->archivo_pfr = 'conv/pfr/' . $fileNamePfr;
        }
        if ($request->hasFile('archivo_articulo')) {
            $dirArticulo = public_path('conv/articulo');
            if (!file_exists($dirArticulo)) {
                @mkdir($dirArticulo, 0755, true);
            }
            $fileArticulo = $request->file('archivo_articulo');
            $fileNameArticulo = time() . '_' . $fileArticulo->getClientOriginalName();
            $fileArticulo->move(public_path('conv/articulo'), $fileNameArticulo);
            $convocatoria->archivo_articulo = 'conv/articulo/' . $fileNameArticulo;
        }

        $convocatoria->save();

        // Guardar fechas importantes
        foreach ($request->fechas_importantes as $fecha) {
            FechaImportanteConcurso::create([
                'convocatorias_concursos_id' => $convocatoria->id,
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        // Guardar imágenes adicionales
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $directory = public_path('conv/imagenes');
                if (!file_exists($directory)) {
                    @mkdir($directory, 0755, true);
                }
                $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $imagen->getClientOriginalExtension();
                $imagen->move($directory, $randomName);
                $convocatoria->imagenes()->create([
                    'imagen' => 'conv/imagenes/' . $randomName,
                    'descripcion' => 'Imagen adicional de la convocatoria'
                ]);
            }
        }

        return redirect()->route('admin.concursos.convocatorias.index')
            ->with('success', 'Convocatoria creada exitosamente');
    }

    public function show(ConvocatoriaConcurso $convocatoria)
    {
        $concursos = Concurso::where('estado', 'activo')
            ->get();
        return view('admin.concursos.convocatorias.show', compact('convocatoria', 'concursos'));
    }

    public function edit(ConvocatoriaConcurso $convocatoria)
    {
        $concursos = Concurso::where('estado', 'activo')
            ->get();
        return view('admin.concursos.convocatorias.edit', compact('convocatoria', 'concursos'));
    }

    public function update(Request $request, ConvocatoriaConcurso $convocatoria)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
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
            'archivo_convocatoria' => 'nullable|mimes:pdf|max:20480',
            'imagen_portada' => 'nullable|image|max:5120',
            'archivo_pdr' => 'nullable|mimes:pdf|max:20480',
            'archivo_cdr' => 'nullable|mimes:pdf|max:20480',
            'archivo_pfr' => 'nullable|mimes:pdf|max:20480',
            'archivo_articulo' => 'nullable|mimes:pdf|max:20480',
            'fechas_importantes' => 'required|array',
            'fechas_importantes.*.titulo' => 'required|string',
            'fechas_importantes.*.fecha' => 'required|date',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|max:2048',
            'costo_pre_registro' => 'nullable|numeric|min:0',
            'costo_inscripcion' => 'nullable|numeric|min:0'
        ]);

        $convocatoria->update($request->except([
            'archivo_convocatoria',
            'imagen_portada',
            'archivo_pdr',
            'archivo_cdr',
            'archivo_pfr',
            'archivo_articulo',
            'fechas_importantes'
        ]));

        // Actualizar fechas importantes
        $convocatoria->fechasImportantes()->delete(); // Eliminar fechas existentes
        foreach ($request->fechas_importantes as $fecha) {
            $convocatoria->fechasImportantes()->create([
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        // Actualizar archivos si se proporcionan nuevos
        if ($request->hasFile('archivo_convocatoria')) {
            if ($convocatoria->archivo_convocatoria && file_exists(public_path($convocatoria->archivo_convocatoria))) {
                if (file_exists(public_path($convocatoria->archivo_convocatoria))) {
                    unlink(public_path($convocatoria->archivo_convocatoria));
                }
            }
            $directory = public_path('conv/pdf');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_convocatoria')->getClientOriginalExtension();
            $request->file('archivo_convocatoria')->move($directory, $randomName);
            $convocatoria->archivo_convocatoria = 'conv/pdf/' . $randomName;
        }
        if ($request->hasFile('imagen_portada')) {
            if ($convocatoria->imagen_portada && file_exists(public_path($convocatoria->imagen_portada))) {
                if (file_exists(public_path($convocatoria->imagen_portada))) {
                    unlink(public_path($convocatoria->imagen_portada));
                }
            }
            $directory = public_path('conv/portada');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('imagen_portada')->getClientOriginalExtension();
            $request->file('imagen_portada')->move($directory, $randomName);
            $convocatoria->imagen_portada = 'conv/portada/' . $randomName;
        }
        if ($request->hasFile('archivo_pdr')) {
            if ($convocatoria->archivo_pdr && file_exists(public_path($convocatoria->archivo_pdr))) {
                unlink(public_path($convocatoria->archivo_pdr));
            }
            $directory = public_path('conv/pdr');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_pdr')->getClientOriginalExtension();
            $request->file('archivo_pdr')->move($directory, $randomName);
            $convocatoria->archivo_pdr = 'conv/pdr/' . $randomName;
        }
        if ($request->hasFile('archivo_cdr')) {
            if ($convocatoria->archivo_cdr && file_exists(public_path($convocatoria->archivo_cdr))) {
                unlink(public_path($convocatoria->archivo_cdr));
            }
            $directory = public_path('conv/cdr');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_cdr')->getClientOriginalExtension();
            $request->file('archivo_cdr')->move($directory, $randomName);
            $convocatoria->archivo_cdr = 'conv/cdr/' . $randomName;
        }
        if ($request->hasFile('archivo_pfr')) {
            if ($convocatoria->archivo_pfr && file_exists(public_path($convocatoria->archivo_pfr))) {
                unlink(public_path($convocatoria->archivo_pfr));
            }
            $directory = public_path('conv/pfr');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_pfr')->getClientOriginalExtension();
            $request->file('archivo_pfr')->move($directory, $randomName);
            $convocatoria->archivo_pfr = 'conv/pfr/' . $randomName;
        }
        if ($request->hasFile('archivo_articulo')) {
            if ($convocatoria->archivo_articulo && file_exists(public_path($convocatoria->archivo_articulo))) {
                unlink(public_path($convocatoria->archivo_articulo));
            }
            $directory = public_path('conv/articulo');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_articulo')->getClientOriginalExtension();
            $request->file('archivo_articulo')->move($directory, $randomName);
            $convocatoria->archivo_articulo = 'conv/articulo/' . $randomName;
        }

        $convocatoria->save();

        return redirect()->route('admin.concursos.convocatorias.index')
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
                if ($archivo && file_exists(public_path($archivo))) {
                    unlink(public_path($archivo));
                }
            }

            // Eliminar imágenes adicionales
            foreach ($convocatoria->imagenes as $imagen) {
                if ($imagen->imagen && file_exists(public_path($imagen->imagen))) {
                    unlink(public_path($imagen->imagen));
                }
            }

            $convocatoria->delete();
            \DB::commit();

            return response()->json(['message' => 'Convocatoria eliminada exitosamente']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => 'Error al eliminar la convocatoria: ' . $e->getMessage()], 500);
        }
    }
}