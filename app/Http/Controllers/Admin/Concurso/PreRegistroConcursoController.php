<?php

namespace App\Http\Controllers\Admin\Concurso;

use App\Http\Controllers\Controller;
use App\Models\PreRegistroConcurso;
use App\Models\User;
use App\Models\Concurso;
use Illuminate\Http\Request;

class PreRegistroConcursoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estado = $request->input('estado');
        
        $preRegistros = PreRegistroConcurso::with(['usuario', 'concurso'])
            ->when($search, function($query) use ($search) {
                return $query->where('nombre_equipo', 'like', '%' . $search . '%')
                    ->orWhereHas('usuario', function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->when($estado, function($query) use ($estado) {
                return $query->where('estado', $estado);
            })
            ->latest()
            ->paginate(10);
        
        return view('admin.concursos.pre-registros.index', compact('preRegistros', 'search', 'estado'));
    }

    public function show(PreRegistroConcurso $preRegistro)
    {
        $preRegistro->load(['usuario', 'concurso']);
        return view('admin.concursos.pre-registros.show', compact('preRegistro'));
    }

    public function edit(PreRegistroConcurso $preRegistro)
    {
        $preRegistro->load(['usuario', 'concurso']);
        $concursos = Concurso::where('estado', 'activo')->get();
        return view('admin.concursos.pre-registros.edit', compact('preRegistro', 'concursos'));
    }

    public function update(Request $request, PreRegistroConcurso $preRegistro)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string',
            'estado' => 'required|in:pendiente,validado,rechazado'
        ]);

        $preRegistro->update($request->all());

        return redirect()->route('admin.concursos.pre-registros.index')
            ->with('success', 'Pre-registro actualizado exitosamente');
    }

    public function destroy(PreRegistroConcurso $preRegistro)
    {
        try {
            $preRegistro->delete();
            return response()->json(['message' => 'Pre-registro eliminado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el pre-registro'], 500);
        }
    }

    public function updateEstado(Request $request, PreRegistroConcurso $preRegistro)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,validado,rechazado'
        ]);

        $preRegistro->update([
            'estado' => $request->estado
        ]);

        return response()->json([
            'message' => 'Estado actualizado exitosamente',
            'estado' => $preRegistro->estado
        ]);
    }
}