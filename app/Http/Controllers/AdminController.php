<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function usuarios()
    {
        return view('admin.usuarios');
    }

    public function categoriasTemas()
    {
        return view('admin.categorias-temas');
    }

    public function cursos()
    {
        return view('admin.cursos');
    }

    public function talleres()
    {
        return view('admin.talleres');
    }

    public function ponencias()
    {
        return view('admin.ponencias');
    }

    public function concursos()
    {
        return view('admin.concursos');
    }

    public function ponentes()
    {
        return view('admin.ponentes');
    }

    public function congresosEventos()
    {
        return view('admin.congresos-eventos');
    }

    public function becas()
    {
        return view('admin.becas');
    }

    public function pagosFacturacion()
    {
        return view('admin.pagos-facturacion');
    }

    public function reportesEstadisticas()
    {
        return view('admin.reportes-estadisticas');
    }
}


