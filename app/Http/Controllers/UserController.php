<?php

namespace App\Http\Controllers;


use App\Models\Concurso;
use App\Models\Congreso;
use App\Models\Noticia;

class UserController extends Controller
{
    public function index()
    {
        // Obtener concursos activos con sus relaciones
        $concursos = Concurso::with(['categoria', 'convocatorias.fechasImportantes'])
            ->where('estado', 'activo')
            ->latest()
            ->get();

        // Obtener congresos activos con sus relaciones
        $congresos = Congreso::with(['convocatorias.fechasImportantes'])
            ->where('estado', 'activo')
            ->latest()
            ->get();

        // Obtener las últimas noticias
        $noticias = Noticia::with('seccionNoticia')
            ->latest('fecha_publicacion')
            ->take(2)
            ->get();

        return view('user.inicio', compact('concursos', 'noticias', 'congresos'));
    }

    public function espacio()
    {
        return view('user.espacio');
    }
    public function noticia()
    {
        $noticias = Noticia::with('seccionNoticia')
            ->orderBy('fecha_publicacion', 'desc')
            ->get();
        return view('user.noticias.index', compact('noticias'));
    }

    public function showNoticia(Noticia $noticia)
    {
        return view('user.noticias.show', compact('noticia'));
    }

    public function cursos()
    {
        return view('user.cursos');
    }

    public function talleres()
    {
        return view('user.talleres');
    }

    public function ponencias()
    {
        return view('user.ponencias');
    }

    public function concursos()
    {
        return redirect()->route('user.concursos.index');
    }

    public function inscripciones()
    {
        return view('user.inscripciones');
    }

    public function certificados()
    {
        return view('user.certificados');
    }

    public function pagos()
    {
        return view('user.pagos');
    }

    public function resenas()
    {
        return view('user.resenas');
    }

    public function eventos()
    {
        return view('user.eventos');
    }

    public function soporte()
    {
        return view('user.soporte');
    }
}

