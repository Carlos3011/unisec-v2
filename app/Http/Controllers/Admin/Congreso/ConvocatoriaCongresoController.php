<?php

namespace App\Http\Controllers\Admin\Congreso;

use App\Http\Controllers\Controller;
use App\Models\ConvocatoriaCongreso;
use App\Models\FechaImportanteCongreso;
use App\Models\Congreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConvocatoriaCongresoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $convocatorias = ConvocatoriaCongreso::with(['fechasImportantes', 'congreso'])
            ->when($search, function ($query) use ($search) {
                return $query->where('titulo', 'like', '%' . $search . '%')
                           ->orWhere('descripcion', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();

        return view('admin.congresos.convocatorias.index', compact('convocatorias', 'search'));
    }

    public function create()
    {
        $congresos = Congreso::where('estado', 'activo')->get();
        return view('admin.congresos.convocatorias.create', compact('congresos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'congreso_id' => 'required|exists:congresos,id',
            'descripcion' => 'required|string',
            'sede' => 'required|string|max:255',
            'dirigido_a' => 'required|string|max:255',
            'requisitos' => 'required|string',
            'tematicas' => 'required|array|min:1',
            'tematicas.*.titulo' => 'required|string|max:255',
            'tematicas.*.descripcion' => 'required|string|max:255',
            'criterios_evaluacion' => 'required|string',
            'formato_articulo' => 'required|string',
            'formato_extenso' => 'required|string',
            'cuotas_inscripcion' => 'nullable|array',
            'cuotas_inscripcion.*.rol' => 'required_with:cuotas_inscripcion|string|max:255',
            'cuotas_inscripcion.*.monto' => 'required_with:cuotas_inscripcion|numeric|min:0',
            'contacto_email' => 'nullable|email',
            'archivo_convocatoria' => 'nullable|mimes:pdf|max:20480',
            'archivo_articulo' => 'nullable|mimes:pdf|max:20480',
            'imagen_portada' => 'nullable|image|max:5120',
            'fechas_importantes' => 'required|array|min:1',
            'fechas_importantes.*.titulo' => 'required|string|max:255',
            'fechas_importantes.*.fecha' => 'required|date',
        ]);

        $convocatoria = new ConvocatoriaCongreso($request->except([
            'archivo_convocatoria',
            'archivo_articulo',
            'imagen_portada',
            'fechas_importantes'
        ]));

        // Manejar archivo de convocatoria
        if ($request->hasFile('archivo_convocatoria')) {
            $dirConvocatoria = public_path('congreso/convocatoria');
            if (!file_exists($dirConvocatoria)) {
                @mkdir($dirConvocatoria, 0755, true);
            }
            $file = $request->file('archivo_convocatoria');
            $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file->getClientOriginalExtension();
            $file->move($dirConvocatoria, $fileName);
            $convocatoria->archivo_convocatoria = 'congreso/convocatoria/' . $fileName;
        }

        // Manejar archivo de artículo
        if ($request->hasFile('archivo_articulo')) {
            $dirArticulo = public_path('congreso/articulo');
            if (!file_exists($dirArticulo)) {
                @mkdir($dirArticulo, 0755, true);
            }
            $file = $request->file('archivo_articulo');
            $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file->getClientOriginalExtension();
            $file->move($dirArticulo, $fileName);
            $convocatoria->archivo_articulo = 'congreso/articulo/' . $fileName;
        }

        // Manejar imagen de portada
        if ($request->hasFile('imagen_portada')) {
            $dirPortada = public_path('congreso/portada');
            if (!file_exists($dirPortada)) {
                @mkdir($dirPortada, 0755, true);
            }
            $image = $request->file('imagen_portada');
            $imageName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $image->getClientOriginalExtension();
            $image->move($dirPortada, $imageName);
            $convocatoria->imagen_portada = 'congreso/portada/' . $imageName;
        }

        $convocatoria->save();

        // Guardar fechas importantes
        foreach ($request->fechas_importantes as $fecha) {
            FechaImportanteCongreso::create([
                'convocatoria_congreso_id' => $convocatoria->id,
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        return redirect()->route('admin.congresos.convocatorias.index')
            ->with('success', 'Convocatoria de congreso creada exitosamente');
    }

    public function show(ConvocatoriaCongreso $convocatoria)
    {
        $convocatoria->load(['congreso', 'fechasImportantes', 'articulos']);
        return view('admin.congresos.convocatorias.show', compact('convocatoria'));
    }

    public function edit(ConvocatoriaCongreso $convocatoria)
    {
        $congresos = Congreso::where('estado', 'activo')->get();
        $convocatoria->load(['fechasImportantes']);
        return view('admin.congresos.convocatorias.edit', compact('convocatoria', 'congresos'));
    }

    public function update(Request $request, ConvocatoriaCongreso $convocatoria)
    {
        $request->validate([
            'congreso_id' => 'required|exists:congresos,id',
            'descripcion' => 'required|string',
            'sede' => 'required|string|max:255',
            'dirigido_a' => 'required|string|max:255',
            'requisitos' => 'required|string',
            'tematicas' => 'required|array|min:1',
            'tematicas.*.titulo' => 'required|string|max:255',
            'tematicas.*.descripcion' => 'required|string|max:255',
            'criterios_evaluacion' => 'required|string',
            'formato_articulo' => 'required|string',
            'formato_extenso' => 'required|string',
            'cuotas_inscripcion' => 'nullable|array',
            'cuotas_inscripcion.*.rol' => 'required_with:cuotas_inscripcion|string|max:255',
            'cuotas_inscripcion.*.monto' => 'required_with:cuotas_inscripcion|numeric|min:0',
            'contacto_email' => 'nullable|email',
            'archivo_convocatoria' => 'nullable|mimes:pdf|max:20480',
            'archivo_articulo' => 'nullable|mimes:pdf|max:20480',
            'imagen_portada' => 'nullable|image|max:5120',
            'fechas_importantes' => 'required|array|min:1',
            'fechas_importantes.*.titulo' => 'required|string|max:255',
            'fechas_importantes.*.fecha' => 'required|date',
        ]);

        $convocatoria->update($request->except([
            'archivo_convocatoria',
            'archivo_articulo',
            'imagen_portada',
            'fechas_importantes'
        ]));

        // Actualizar fechas importantes
        $convocatoria->fechasImportantes()->delete();
        foreach ($request->fechas_importantes as $fecha) {
            $convocatoria->fechasImportantes()->create([
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        // Actualizar archivo de convocatoria si se proporciona uno nuevo
        if ($request->hasFile('archivo_convocatoria')) {
            // Eliminar archivo anterior
            if ($convocatoria->archivo_convocatoria && file_exists(public_path($convocatoria->archivo_convocatoria))) {
                unlink(public_path($convocatoria->archivo_convocatoria));
            }
            
            $directory = public_path('congreso/convocatoria');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_convocatoria')->getClientOriginalExtension();
            $request->file('archivo_convocatoria')->move($directory, $randomName);
            $convocatoria->archivo_convocatoria = 'congreso/convocatoria/' . $randomName;
        }

        // Actualizar archivo de artículo si se proporciona uno nuevo
        if ($request->hasFile('archivo_articulo')) {
            // Eliminar archivo anterior
            if ($convocatoria->archivo_articulo && file_exists(public_path($convocatoria->archivo_articulo))) {
                unlink(public_path($convocatoria->archivo_articulo));
            }
            
            $directory = public_path('congreso/articulo');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('archivo_articulo')->getClientOriginalExtension();
            $request->file('archivo_articulo')->move($directory, $randomName);
            $convocatoria->archivo_articulo = 'congreso/articulo/' . $randomName;
        }

        // Actualizar imagen de portada si se proporciona una nueva
        if ($request->hasFile('imagen_portada')) {
            // Eliminar imagen anterior
            if ($convocatoria->imagen_portada && file_exists(public_path($convocatoria->imagen_portada))) {
                unlink(public_path($convocatoria->imagen_portada));
            }
            
            $directory = public_path('congreso/portada');
            if (!file_exists($directory)) {
                @mkdir($directory, 0755, true);
            }
            $randomName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $request->file('imagen_portada')->getClientOriginalExtension();
            $request->file('imagen_portada')->move($directory, $randomName);
            $convocatoria->imagen_portada = 'congreso/portada/' . $randomName;
        }

        $convocatoria->save();

        return redirect()->route('admin.congresos.convocatorias.index')
            ->with('success', 'Convocatoria de congreso actualizada exitosamente');
    }

    public function destroy(ConvocatoriaCongreso $convocatoria)
    {
        try {
            DB::beginTransaction();

            // Eliminar archivos asociados si existen
            $archivos = [
                $convocatoria->archivo_convocatoria,
                $convocatoria->archivo_articulo,
                $convocatoria->imagen_portada
            ];

            foreach ($archivos as $archivo) {
                if ($archivo && file_exists(public_path($archivo))) {
                    unlink(public_path($archivo));
                }
            }

            $convocatoria->delete();
            DB::commit();

            return response()->json(['message' => 'Convocatoria de congreso eliminada exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al eliminar la convocatoria: ' . $e->getMessage()], 500);
        }
    }
}