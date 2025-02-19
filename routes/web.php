<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'inicio')->name('inicio');
    Route::get('/acerca', 'acerca')->name('acerca');
    Route::get('/ofertas', 'ofertas')->name('ofertas');
    Route::get('/miembros', 'miembros')->name('miembros');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/contacto', 'contacto')->name('contacto');
});

// Redirigir al dashboard correcto según el rol del usuario autenticado
Route::get('/dashboard', function () {
    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas para Administradores
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/admin/categorias-temas', [AdminController::class, 'categoriasTemas'])->name('admin.categorias-temas');
    Route::get('/admin/cursos', [AdminController::class, 'cursos'])->name('admin.cursos');
    Route::get('/admin/talleres', [AdminController::class, 'talleres'])->name('admin.talleres');
    Route::get('/admin/ponencias', [AdminController::class, 'ponencias'])->name('admin.ponencias');
    Route::get('/admin/concursos', [AdminController::class, 'concursos'])->name('admin.concursos');
    Route::get('/admin/ponentes', [AdminController::class, 'ponentes'])->name('admin.ponentes');
    Route::get('/admin/congresos-eventos', [AdminController::class, 'congresosEventos'])->name('admin.congresos-eventos');
    Route::get('/admin/becas', [AdminController::class, 'becas'])->name('admin.becas');
    Route::get('/admin/pagos-facturacion', [AdminController::class, 'pagosFacturacion'])->name('admin.pagos-facturacion');
    Route::get('/admin/reportes-estadisticas', [AdminController::class, 'reportesEstadisticas'])->name('admin.reportes-estadisticas');
});

// Grupo de rutas para Usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    // Rutas del Navbar de Usuario
    Route::get('/user/cursos', [UserController::class, 'cursos'])->name('user.cursos');
    Route::get('/user/talleres', [UserController::class, 'talleres'])->name('user.talleres');
    Route::get('/user/ponencias', [UserController::class, 'ponencias'])->name('user.ponencias');
    Route::get('/user/concursos', [UserController::class, 'concursos'])->name('user.concursos');
    Route::get('/user/inscripciones', [UserController::class, 'inscripciones'])->name('user.inscripciones');
    Route::get('/user/certificados', [UserController::class, 'certificados'])->name('user.certificados');
    Route::get('/user/pagos', [UserController::class, 'pagos'])->name('user.pagos');
    Route::get('/user/resenas', [UserController::class, 'resenas'])->name('user.resenas');
    Route::get('/user/eventos', [UserController::class, 'eventos'])->name('user.eventos');
    Route::get('/user/soporte', [UserController::class, 'soporte'])->name('user.soporte');
});


// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

