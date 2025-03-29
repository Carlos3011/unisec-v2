<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\PreRegistroConcurso;
use App\Models\Concurso;
use App\Models\ConvocatoriaConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreRegistroUserController extends Controller
{
    public function index()
    {
        $preRegistros = PreRegistroConcurso::with('concurso')
            ->where('usuario_id', Auth::id())
            ->latest()
            ->paginate(10);

        $convocatoria = ConvocatoriaConcurso::whereHas('concurso', function($query) {
            $query->where('estado', 'activo');
        })->first();
        
        return view('user.concursos.pre-registros.index', compact('preRegistros', 'convocatoria'));
    }

    public function create($convocatoria)
    {
        $convocatoria = ConvocatoriaConcurso::findOrFail($convocatoria);
        $concurso = $convocatoria->concurso;
        $concursos = collect([$concurso]);

        return view('user.concursos.pre-registros.create', compact('concursos', 'convocatoria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string'
        ]);

        // Verificar si el usuario ya tiene un pre-registro activo para este concurso
        $existingPreRegistro = PreRegistroConcurso::where('usuario_id', Auth::id())
            ->where('concurso_id', $request->concurso_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingPreRegistro) {
            return redirect()->route('user.concursos.pre-registros.index')
                ->with('error', 'Ya tienes un pre-registro para este concurso.');
        }

        $preRegistro = PreRegistroConcurso::create([
            'usuario_id' => Auth::id(),
            'concurso_id' => $request->concurso_id,
            
            'nombre_equipo' => $request->nombre_equipo,
            'integrantes' => $request->integrantes,
            'asesor' => $request->asesor,
            'institucion' => $request->institucion,
            'comentarios' => $request->comentarios,
            'estado' => 'pendiente'
        ]);

        return redirect()->route('user.concursos.pre-registros.index')
            ->with('success', 'Pre-registro creado exitosamente');
    }

    public function show(PreRegistroConcurso $preRegistro)
    {
        $this->authorize('view', $preRegistro);
        $preRegistro->load('concurso');
        
        return view('user.concursos.pre-registros.show', compact('preRegistro'));
    }

    public function update(Request $request, PreRegistroConcurso $preRegistro)
    {
        $this->authorize('update', $preRegistro);

        if ($preRegistro->estado !== 'pendiente') {
            return redirect()->route('user.concursos.pre-registros.show', $preRegistro)
                ->with('error', 'No se puede modificar un pre-registro que ya ha sido procesado');
        }

        $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string'
        ]);

        $preRegistro->update($request->only([
            'nombre_equipo',
            'integrantes',
            'asesor',
            'institucion',
            'comentarios'
        ]));

        return redirect()->route('user.concursos.pre-registros.show', $preRegistro)
            ->with('success', 'Pre-registro actualizado exitosamente');
    }
}