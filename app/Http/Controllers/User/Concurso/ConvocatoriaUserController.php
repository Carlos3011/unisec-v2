<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\ConvocatoriaConcurso;
use App\Models\Concurso;
use Illuminate\Http\Request;

class ConvocatoriaUserController extends Controller
{
    public function show(ConvocatoriaConcurso $convocatoria)
    {
        if (!$convocatoria->concurso || $convocatoria->concurso->estado !== 'activo') {
            return redirect()->route('user.concursos.index')
                ->with('error', 'La convocatoria no está disponible.');
        }

        return view('user.concursos.convocatorias.show', compact('convocatoria'));
    }

    public function downloadConvocatoria(ConvocatoriaConcurso $convocatoria)
    {
        if (!$convocatoria->archivo_convocatoria || !file_exists(public_path($convocatoria->archivo_convocatoria))) {
            return back()->with('error', 'El archivo de la convocatoria no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_convocatoria));
    }

    public function downloadPDR(ConvocatoriaConcurso $convocatoria)
    {
        if (!$convocatoria->archivo_pdr || !file_exists(public_path($convocatoria->archivo_pdr))) {
            return back()->with('error', 'El archivo PDR no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_pdr));
    }

    public function downloadCDR(ConvocatoriaConcurso $convocatoria)
    {
        if (!$convocatoria->archivo_cdr || !file_exists(public_path($convocatoria->archivo_cdr))) {
            return back()->with('error', 'El archivo CDR no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_cdr));
    }

    public function downloadPFR(ConvocatoriaConcurso $convocatoria)
    {
        if (!$convocatoria->archivo_pfr || !file_exists(public_path($convocatoria->archivo_pfr))) {
            return back()->with('error', 'El archivo PFR no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_pfr));
    }

    public function downloadArticulo(ConvocatoriaConcurso $convocatoria)
    {
        if (!$convocatoria->archivo_articulo || !file_exists(public_path($convocatoria->archivo_articulo))) {
            return back()->with('error', 'El archivo del artículo no está disponible.');
        }

        return response()->download(public_path($convocatoria->archivo_articulo));
    }
}