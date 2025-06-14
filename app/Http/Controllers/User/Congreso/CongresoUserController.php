<?php

namespace App\Http\Controllers\User\Congreso;

use App\Http\Controllers\Controller;
use App\Models\Congreso;
use App\Models\ConvocatoriaCongreso;
use Illuminate\Http\Request;

class CongresoUserController extends Controller
{
    public function index()
    {
        $congresos = Congreso::with(['convocatorias.fechasImportantes'])
            ->where('estado', 'activo')
            ->latest()
            ->get();

        return view('user.congresos.index', compact('congresos'));
    }

    public function show(Congreso $congreso)
    {
        if ($congreso->estado !== 'activo') {
            return redirect()->route('user.congresos.index')
                ->with('error', 'El congreso no está disponible.');
        }

        $convocatoria = $congreso->convocatorias->first();
        
        return view('user.congresos.show', compact('congreso', 'convocatoria'));
    }

    public function showConvocatoria(Congreso $congreso)
    {
        if ($congreso->estado !== 'activo') {
            return redirect()->route('user.congresos.index')
                ->with('error', 'El congreso no está disponible.');
        }

        $convocatoria = $congreso->convocatorias->first();
        if (!$convocatoria) {
            return redirect()->route('user.congresos.show', $congreso)
                ->with('error', 'La convocatoria no está disponible.');
        }

        return view('user.congresos.convocatoria', compact('congreso', 'convocatoria'));
    }

    public function filterByTematica(Request $request)
    {
        $tematica = $request->input('tematica');
        
        $congresos = Congreso::with(['convocatorias'])
            ->where('estado', 'activo')
            ->when($tematica, function($query) use ($tematica) {
                return $query->whereHas('convocatorias', function($q) use ($tematica) {
                    $q->whereJsonContains('tematicas', $tematica);
                });
            })
            ->get();

        return response()->json($congresos);
    }
} 