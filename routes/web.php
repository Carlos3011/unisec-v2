<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\PonentesController;
use App\Http\Controllers\Admin\TemaController;
use App\Http\Controllers\Admin\TallerController;
use App\Http\Controllers\Admin\ConcursoController;
use App\Http\Controllers\Admin\ConvocatoriaConcursoController;
use App\Http\Controllers\Admin\SeccionNoticiaController;
use App\Http\Controllers\Admin\NoticiaController;

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'inicio')->name('inicio');
    Route::get('/acerca', 'acerca')->name('acerca');
    Route::get('/ofertas', 'ofertas')->name('ofertas');

    Route::get('/convocatorias','convocatorias')->name('convocatorias');
    Route::get('/convocatorias/{convocatoria}', 'show')->name('convocatorias.show');
    
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
    
    // Rutas para la gestión de convocatorias
    Route::get('/admin/convocatorias', [ConvocatoriaConcursoController::class, 'index'])->name('admin.convocatorias.index');
    Route::get('/admin/convocatorias/create', [ConvocatoriaConcursoController::class, 'create'])->name('admin.convocatorias.create');
    Route::post('/admin/convocatorias', [ConvocatoriaConcursoController::class, 'store'])->name('admin.convocatorias.store');
    Route::get('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'show'])->name('admin.convocatorias.show');
    Route::get('/admin/convocatorias/{convocatoria}/edit', [ConvocatoriaConcursoController::class, 'edit'])->name('admin.convocatorias.edit');
    Route::put('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'update'])->name('admin.convocatorias.update');
    Route::delete('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'destroy'])->name('admin.convocatorias.destroy');
    
    // Rutas para la gestión de usuarios
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    
    Route::get('/admin/categorias-temas', [AdminController::class, 'categoriasTemas'])->name('admin.categorias-temas');

    // Rutas para la gestión de temas
    Route::get('/admin/temas', [TemaController::class, 'index'])->name('admin.temas.index');
    Route::get('/admin/temas/create', [TemaController::class, 'create'])->name('admin.temas.create');
    Route::post('/admin/temas', [TemaController::class, 'store'])->name('admin.temas.store');
    Route::get('/admin/temas/{tema}/edit', [TemaController::class, 'edit'])->name('admin.temas.edit');
    Route::put('/admin/temas/{tema}', [TemaController::class, 'update'])->name('admin.temas.update');
    Route::delete('/admin/temas/{tema}', [TemaController::class, 'destroy'])->name('admin.temas.destroy');

    // Rutas para la gestión de categorías
    Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index');
    Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
    Route::put('/admin/categorias/{categoria}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
    Route::delete('/admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

    // Rutas para la gestión de cursos
    Route::get('/admin/cursos', [CursoController::class, 'index'])->name('admin.cursos.index');
    Route::get('/admin/cursos/create', [CursoController::class, 'create'])->name('admin.cursos.create');
    Route::post('/admin/cursos', [CursoController::class, 'store'])->name('admin.cursos.store');
    Route::get('/admin/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('admin.cursos.edit');
    Route::put('/admin/cursos/{curso}', [CursoController::class, 'update'])->name('admin.cursos.update');
    Route::delete('/admin/cursos/{curso}', [CursoController::class, 'destroy'])->name('admin.cursos.destroy');    
    
   
    // Rutas para la gestión de ponentes
    Route::get('/admin/ponentes', [PonentesController::class, 'index'])->name('admin.ponentes.index');
    Route::get('/admin/ponentes/create', [PonentesController::class, 'create'])->name('admin.ponentes.create');
    Route::post('/admin/ponentes', [PonentesController::class, 'store'])->name('admin.ponentes.store');
    Route::get('/admin/ponentes/{ponente}/edit', [PonentesController::class, 'edit'])->name('admin.ponentes.edit');
    Route::put('/admin/ponentes/{ponente}', [PonentesController::class, 'update'])->name('admin.ponentes.update');
    Route::delete('/admin/ponentes/{ponente}', [PonentesController::class, 'destroy'])->name('admin.ponentes.destroy');

    // Rutas para la gestión de talleres
    Route::get('/admin/talleres', [TallerController::class, 'index'])->name('admin.talleres.index');
    Route::get('/admin/talleres/create', [TallerController::class, 'create'])->name('admin.talleres.create');
    Route::post('/admin/talleres', [TallerController::class, 'store'])->name('admin.talleres.store');
    Route::get('/admin/talleres/{taller}/edit', [TallerController::class, 'edit'])->name('admin.talleres.edit');
    Route::put('/admin/talleres/{taller}', [TallerController::class, 'update'])->name('admin.talleres.update');
    Route::delete('/admin/talleres/{taller}', [TallerController::class, 'destroy'])->name('admin.talleres.destroy');

    Route::get('/admin/concursos', [ConcursoController::class, 'index'])->name('admin.concursos.index');
    Route::get('/admin/concursos/create', [ConcursoController::class, 'create'])->name('admin.concursos.create');
    Route::post('/admin/concursos', [ConcursoController::class, 'store'])->name('admin.concursos.store');
    Route::get('/admin/concursos/{concurso}/edit', [ConcursoController::class, 'edit'])->name('admin.concursos.edit');
    Route::put('/admin/concursos/{concurso}', [ConcursoController::class, 'update'])->name('admin.concursos.update');
    Route::delete('/admin/concursos/{concurso}', [ConcursoController::class, 'destroy'])->name('admin.concursos.destroy');

    
    Route::get('/admin/congresos-eventos', [AdminController::class, 'congresosEventos'])->name('admin.congresos-eventos');
    Route::get('/admin/becas', [AdminController::class, 'becas'])->name('admin.becas');
    Route::get('/admin/pagos-facturacion', [AdminController::class, 'pagosFacturacion'])->name('admin.pagos-facturacion');
    Route::get('/admin/reportes-estadisticas', [AdminController::class, 'reportesEstadisticas'])->name('admin.reportes-estadisticas');


    // Rutas para la gestión de secciones de noticias
    Route::get('/admin/secciones', [SeccionNoticiaController::class, 'index'])->name('admin.noticias.secciones.index');
    Route::get('/admin/secciones/create', [SeccionNoticiaController::class, 'create'])->name('admin.noticias.secciones.create');
    Route::post('/admin/secciones', [SeccionNoticiaController::class, 'store'])->name('admin.noticias.secciones.store');
    Route::get('/admin/secciones/{seccion}/edit', [SeccionNoticiaController::class, 'edit'])->name('admin.noticias.secciones.edit');
    Route::put('/admin/secciones/{seccion}', [SeccionNoticiaController::class, 'update'])->name('admin.noticias.secciones.update');
    Route::delete('/admin/secciones/{seccion}', [SeccionNoticiaController::class, 'destroy'])->name('admin.noticias.secciones.destroy');
    Route::post('/admin/secciones/{id}/restore', [SeccionNoticiaController::class, 'restore'])->name('admin.noticias.secciones.restore');

    // Rutas para la gestión de noticias
    Route::get('/admin/noticias', [NoticiaController::class, 'index'])->name('admin.noticias.noticia.index');
    Route::get('/admin/noticias/create', [NoticiaController::class, 'create'])->name('admin.noticias.noticia.create');
    Route::post('/admin/noticias', [NoticiaController::class, 'store'])->name('admin.noticias.noticia.store');
    Route::get('/admin/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('admin.noticias.noticia.edit');
    Route::put('/admin/noticias/{noticia}', [NoticiaController::class, 'update'])->name('admin.noticias.noticia.update');
    Route::delete('/admin/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('admin.noticias.noticia.destroy');

    
});

// Grupo de rutas para Usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
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
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

