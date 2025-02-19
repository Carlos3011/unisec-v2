<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('user.dashboard');
    }

    public function cursos() {
        return view('user.cursos');
    }

    public function talleres() {
        return view('user.talleres');
    }

    public function ponencias() {
        return view('user.ponencias');
    }

    public function concursos() {
        return view('user.concursos');
    }

    public function inscripciones() {
        return view('user.inscripciones');
    }

    public function certificados() {
        return view('user.certificados');
    }

    public function pagos() {
        return view('user.pagos');
    }

    public function resenas() {
        return view('user.resenas');
    }

    public function eventos() {
        return view('user.eventos');
    }

    public function soporte() {
        return view('user.soporte');
    }
}

