<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Ponente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CursoController extends Controller
{
    private function calcularDuracion($fecha_inicio, $fecha_fin)
    {
        $inicio = Carbon::parse($fecha_inicio);
        $fin = Carbon::parse($fecha_fin);
        $dias = $inicio->diffInDays($fin) + 1;
        return $dias . ' días';
    }

    public function index()
    {
        $cursos = Curso::with(['categoria', 'inscripciones', 'ponente'])
            ->withCount('inscripciones as inscritos_count')
            ->get()
            ->map(function($curso) {
                return [
                    'id' => $curso->id,
                    'nombre' => $curso->titulo,
                    'descripcion' => $curso->descripcion,
                    'categoria' => $curso->categoria->nombre,
                    'ponente' => $curso->ponente->nombre,
                    'duracion' => $this->calcularDuracion($curso->fecha_inicio, $curso->fecha_fin),
                    'costo' => $curso->costo,
                    'estado' => $curso->estado,
                    'inscritos_count' => $curso->inscritos_count
                ];
            });
        $categorias = Categoria::all();
        return view('admin.cursos.index', compact('cursos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $ponentes = Ponente::all();
        return view('admin.cursos.create')->with([
            'categorias' => $categorias,
            'ponentes' => $ponentes
        ]);
    }

    public function edit(Curso $curso)
    {
        $categorias = Categoria::all();
        $ponentes = Ponente::all();
        return view('admin.cursos.edit', compact('curso', 'categorias', 'ponentes'));
    }
    

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'estado' => 'required|string|in:activo,inactivo,pendiente',
                'titulo' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'categoria_id' => 'required|exists:categorias,id',

                'ponente_id' => 'required|exists:ponentes,id',
                'costo' => 'required|numeric|min:0',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio'
            ]);

            $curso = Curso::create($validated);

            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso creado exitosamente');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear el curso: ' . $e->getMessage());
        }
    }

    public function show(Curso $curso)
    {
        return response()->json([
            'success' => true,
            'curso' => $curso->load('categoria', 'ponente')
        ]);
    }

    public function update(Request $request, Curso $curso)
    {
        try {
            $validated = $request->validate([
                'estado' => 'required|string|in:activo,inactivo,pendiente',
                'titulo' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'categoria_id' => 'required|exists:categorias,id',

                'ponente_id' => 'required|exists:ponentes,id',
                'costo' => 'required|numeric|min:0',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio'
            ]);

            $curso->update($validated);

            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso actualizado exitosamente');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el curso: ' . $e->getMessage());
        }
    }

    public function destroy(Curso $curso)
    {
        try {
            $curso->delete();
            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }
}