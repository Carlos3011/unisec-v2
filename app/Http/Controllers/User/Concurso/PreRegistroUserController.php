<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\PreRegistroConcurso;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreRegistroUserController extends Controller
{
    public function index()
    {
        $preRegistros = PreRegistroConcurso::with(['concurso'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('user.concursos.pre-registros.index', compact('preRegistros'));
    }

    public function create()
    {
        $concursos = Concurso::where('estado', 'activo')
            ->whereDoesntHave('preRegistros', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return view('user.concursos.pre-registros.create', compact('concursos'));
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

        $preRegistro = PreRegistroConcurso::create([
            'user_id' => Auth::id(),
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