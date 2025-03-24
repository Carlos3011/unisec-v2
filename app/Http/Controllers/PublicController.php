<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConvocatoriaConcurso;
use App\Models\Concurso;

class PublicController extends Controller
{
    public function inicio() {
        return view('public.inicio');
    }

    public function acerca() {
        return view('public.acerca');
    }

    public function ofertas() {
        return view('public.ofertas');
    }

    public function convocatorias() {
        $convocatorias = ConvocatoriaConcurso::with(['fechasImportantes'])
            ->orderBy('created_at', 'desc')
            ->get();

        $concursos = Concurso::all();

        return view('public.convocatorias.index', compact('convocatorias', 'concursos'));
    }

    public function show(ConvocatoriaConcurso $convocatoria) {
        $convocatoria->load(['fechasImportantes']);

        $concursos = Concurso::all();
        return view('public.convocatorias.show', compact('convocatoria', 'concursos'));
    }

    public function blog() {
        return view('public.blog');
    }

    public function contacto() {
        return view('public.contacto');
    }

    public function miembros() {
        return view('public.miembros');
    }
}

