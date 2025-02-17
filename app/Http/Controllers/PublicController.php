<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function blog() {
        return view('public.blog');
    }

    public function contacto() {
        return view('public.contacto');
    }
}

