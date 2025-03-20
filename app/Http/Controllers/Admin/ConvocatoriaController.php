<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use App\Models\FechaImportante;
use App\Models\Congreso;
use App\Models\Curso;
use App\Models\Taller;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvocatoriaController extends Controller
{
    public function index()
    {
        $convocatorias = Convocatoria::with('fechasImportantes')->latest()->get();
        return view('admin.convocatorias.index', compact('convocatorias'));
    }

    public function create()
    {
        $cursos = Curso::all();
        $talleres = Taller::all();
        $congresos = Congreso::all();
        $concursos = Concurso::all();

        return view('admin.convocatorias.create', compact('cursos', 'talleres', 'congresos', 'concursos'));
    }

    private function validateEvento($eventoType, $eventoId)
    {
        switch ($eventoType) {
            case 'curso':
                return Curso::where('id', $eventoId) ->exists();
            case 'taller':
                return Taller::where('id', $eventoId)->exists();
            case 'congreso':
                return Congreso::where('id', $eventoId)->exists();
            case 'concurso':
                return Concurso::where('id', $eventoId)->exists();
            default:
                return false;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'archivo_pdf' => 'nullable|mimes:pdf|max:5120',
            'evento_type' => 'required|in:congreso,curso,concurso,taller',
            'evento_id' => 'required|integer',
            'fechas_importantes' => 'required|array|min:1',
            'fechas_importantes.*.titulo' => 'required|string|max:255',
            'fechas_importantes.*.fecha' => 'required|date'
        ]);

        if (!$this->validateEvento($request->evento_type, $request->evento_id)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['evento_id' => 'El evento seleccionado no está disponible o no existe.']);
        }

        $data = $request->except(['imagen', 'archivo_pdf', 'fechas_importantes']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('convocatorias/imagenes', 'public');
        }

        if ($request->hasFile('archivo_pdf')) {
            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('convocatorias/pdfs', 'public');
        }

        $convocatoria = Convocatoria::create($data);

        foreach ($request->fechas_importantes as $fecha) {
            $convocatoria->fechasImportantes()->create([
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        return redirect()->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria creada exitosamente.');
    }

    public function show(Convocatoria $convocatoria)
    {
        $convocatoria->load('fechasImportantes');
        return view('admin.convocatorias.show', compact('convocatoria'));
    }

    public function edit(Convocatoria $convocatoria)
    {
        $convocatoria->load('fechasImportantes');
        $cursos = Curso::all();
        $talleres = Taller::all();
        $congresos = Congreso::all();
        $concursos = Concurso::all();

        return view('admin.convocatorias.edit', compact('convocatoria', 'cursos', 'talleres', 'congresos', 'concursos'));
    }

    public function update(Request $request, Convocatoria $convocatoria)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'archivo_pdf' => 'nullable|mimes:pdf|max:5120',
            'evento_type' => 'required|in:congreso,curso,concurso,taller',
            'evento_id' => 'required|integer',
            'fechas_importantes' => 'required|array|min:1',
            'fechas_importantes.*.titulo' => 'required|string|max:255',
            'fechas_importantes.*.fecha' => 'required|date'
        ]);

        if (!$this->validateEvento($request->evento_type, $request->evento_id)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['evento_id' => 'El evento seleccionado no está disponible o no existe.']);
        }

        $data = $request->except(['imagen', 'archivo_pdf', 'fechas_importantes']);

        if ($request->hasFile('imagen')) {
            if ($convocatoria->imagen) {
                Storage::disk('public')->delete($convocatoria->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('convocatorias/imagenes', 'public');
        }

        if ($request->hasFile('archivo_pdf')) {
            if ($convocatoria->archivo_pdf) {
                Storage::disk('public')->delete($convocatoria->archivo_pdf);
            }
            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('convocatorias/pdfs', 'public');
        }

        $convocatoria->update($data);

        // Actualizar fechas importantes
        $convocatoria->fechasImportantes()->delete();
        foreach ($request->fechas_importantes as $fecha) {
            $convocatoria->fechasImportantes()->create([
                'titulo' => $fecha['titulo'],
                'fecha' => $fecha['fecha']
            ]);
        }

        return redirect()->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria actualizada exitosamente.');
    }

    public function destroy(Convocatoria $convocatoria)
    {
        try {
            if ($convocatoria->imagen) {
                Storage::disk('public')->delete($convocatoria->imagen);
            }

            if ($convocatoria->archivo_pdf) {
                Storage::disk('public')->delete($convocatoria->archivo_pdf);
            }

            $convocatoria->fechasImportantes()->delete();
            $convocatoria->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
