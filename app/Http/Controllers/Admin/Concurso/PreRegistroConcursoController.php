<?php

namespace App\Http\Controllers\Admin\Concurso;

use App\Http\Controllers\Controller;
use App\Models\PreRegistroConcurso;
use App\Models\User;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PreRegistroConcursoController extends Controller
{   
    use AuthorizesRequests;
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
        $this->authorize('update', $preRegistro);

        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'comentarios_evaluacion' => 'nullable|string',
            'estado' => 'required|in:pendiente,validado,rechazado',
            'estado_pdr' => 'required|in:pendiente,aprobado,rechazado'
        ]);

        $updateData = $request->all();
        
        // Si el estado cambia a validado, actualizar automáticamente el estado_pdr a aprobado
        if ($request->estado === 'validado') {
            $updateData['estado_pdr'] = 'aprobado';
        }

        $preRegistro->update($updateData);

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
        $this->authorize('update', $preRegistro);

        $request->validate([
            'estado' => 'required|in:pendiente,validado,rechazado',
            'comentarios_evaluacion' => 'nullable|string'
        ]);

        $updateData = [
            'estado' => $request->estado,
            'comentarios_evaluacion' => $request->comentarios_evaluacion
        ];

        // Si el estado cambia a validado, actualizar automáticamente el estado_pdr
        if ($request->estado === 'validado') {
            $updateData['estado_pdr'] = 'aprobado';
        }

        $preRegistro->update($updateData);

        return response()->json([
            'message' => 'Estado actualizado exitosamente',
            'estado' => $preRegistro->estado,
            'estado_pdr' => $preRegistro->estado_pdr
        ]);
    }

    /**
     * Descarga el archivo PDR del pre-registro.
     *
     * @param PreRegistroConcurso $preRegistro
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadPDR(PreRegistroConcurso $preRegistro)
    {
        $this->authorize('view', $preRegistro);

        if (!$preRegistro->archivo_pdr) {
            return back()->with('error', 'No hay archivo PDR disponible.');
        }

        return Storage::disk('public')->download($preRegistro->archivo_pdr);
    }
}