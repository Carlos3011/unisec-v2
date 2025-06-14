<?php

namespace App\Http\Controllers\User\Congreso;

use App\Http\Controllers\Controller;
use App\Models\ConvocatoriaCongreso;
use App\Models\Congreso;
use Illuminate\Http\Request;

class ConvocatoriaCongresoUserController extends Controller
{
    public function show(ConvocatoriaCongreso $convocatoria)
    {
        if (!$convocatoria->congreso || $convocatoria->congreso->estado !== 'activo') {
            return redirect()->route('user.congresos.index')
                ->with('error', 'La convocatoria no está disponible.');
        }

        return view('user.congresos.convocatorias.show', compact('convocatoria'));
    }

    public function downloadConvocatoria(ConvocatoriaCongreso $convocatoria)
    {
        if (!$convocatoria->archivo_convocatoria || !file_exists(public_path($convocatoria->archivo_convocatoria))) {
            return back()->with('error', 'El archivo de la convocatoria no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_convocatoria));
    }

    public function downloadArticulo(ConvocatoriaCongreso $convocatoria)
    {
        if (!$convocatoria->archivo_articulo || !file_exists(public_path($convocatoria->archivo_articulo))) {
            return back()->with('error', 'El archivo del artículo no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_articulo));
    }

    public function downloadFormatoExtenso(ConvocatoriaCongreso $convocatoria)
    {
        if (!$convocatoria->formato_extenso || !file_exists(public_path($convocatoria->formato_extenso))) {
            return back()->with('error', 'El formato extenso no está disponible.');
        }

        return response()->download(public_path($convocatoria->formato_extenso));
    }
} 