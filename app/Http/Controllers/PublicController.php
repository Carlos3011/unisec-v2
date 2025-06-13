<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConvocatoriaConcurso;
use App\Models\Concurso;
use App\Models\Noticia;
use App\Models\ConvocatoriaCongreso;
use App\Models\Congreso;

class PublicController extends Controller
{
    public function inicio() {
        $convocatorias = ConvocatoriaConcurso::with(['fechasImportantes', 'concurso'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $convocatoriasCongreso = ConvocatoriaCongreso::with(['fechasImportantes', 'congreso'])
            ->orderBy('created_at', 'desc')
            ->get();

        $noticias = Noticia::with(['seccionNoticia'])
            ->orderBy('fecha_publicacion', 'desc')
            ->take(3)
            ->get();

        return view('public.inicio', compact('convocatorias', 'noticias', 'convocatoriasCongreso'));
    }

    public function acerca() {
        return view('public.acerca');
    }

    public function espacio() {
        return view('public.espacio');
    }

    public function convocatorias() {
        $convocatorias = ConvocatoriaConcurso::with(['fechasImportantes', 'concurso'])
            ->orderBy('created_at', 'desc')
            ->get();

        $concursos = Concurso::all();

        return view('public.convocatorias.index', compact('convocatorias', 'concursos'));
    }

    public function show(ConvocatoriaConcurso $convocatoria) {
        $convocatoria->load(['fechasImportantes', 'concurso']);

        $concursos = Concurso::all();
        return view('public.convocatorias.show', compact('convocatoria', 'concursos'));
    }

    public function blog() {
        $noticias = Noticia::with(['seccionNoticia'])
            ->orderBy('fecha_publicacion', 'desc')
            ->get();

        return view('public.blog.noticias.index', compact('noticias'));
    }

    public function showNoticia(Noticia $noticia) {
        return view('public.blog.noticias.show', compact('noticia'));
    }

    public function contacto() {
        return view('public.contacto');
    }

    public function miembros() {
        return view('public.miembros');
    }

    public function convocatoriasCongreso() {
        $convocatorias = ConvocatoriaCongreso::with(['fechasImportantes', 'congreso'])
            ->orderBy('created_at', 'desc')
            ->get();

        $congresos = Congreso::all();

        return view('public.congresos.convocatorias.index', compact('convocatorias', 'congresos'));
    }

    public function showConvocatoriaCongreso(ConvocatoriaCongreso $convocatoria) {
        $convocatoria->load(['fechasImportantes', 'congreso']);

        $congresos = Congreso::all();
        return view('public.congresos.convocatorias.show', compact('convocatoria', 'congresos'));
    }
}

