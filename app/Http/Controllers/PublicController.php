<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConvocatoriaConcurso;

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
        return view('public.convocatorias.index', compact('convocatorias'));
    }

    public function show(ConvocatoriaConcurso $convocatoria) {
        $convocatoria->load(['fechasImportantes']);
        return view('public.convocatorias.show', compact('convocatoria'));
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

