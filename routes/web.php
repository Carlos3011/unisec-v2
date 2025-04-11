<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\PonentesController;
use App\Http\Controllers\Admin\TemaController;
use App\Http\Controllers\Admin\TallerController;

use App\Http\Controllers\Admin\SeccionNoticiaController;
use App\Http\Controllers\Admin\NoticiaController;

/*----
| Controladores para la gestión de de concursos
----*/
use App\Http\Controllers\Admin\Concurso\ConcursoController;
use App\Http\Controllers\Admin\Concurso\ConvocatoriaConcursoController;
use App\Http\Controllers\Admin\Concurso\PreRegistroConcursoController;

use App\Http\Controllers\User\Concurso\ConcursoUserController;
use App\Http\Controllers\User\Concurso\ConvocatoriaUserController;
use App\Http\Controllers\User\Concurso\PreRegistroUserController;


use App\Http\Middleware\RoleMiddleware;

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'inicio')->name('inicio');
    Route::get('/acerca', 'acerca')->name('acerca');
    Route::get('/espacio', 'espacio')->name('espacio');

    Route::get('/convocatorias', 'convocatorias')->name('convocatorias.index');
    Route::get('/convocatorias/{convocatoria}', 'show')->name('convocatorias.show');

    Route::get('/miembros', 'miembros')->name('miembros');

    Route::get('/blog', 'blog')->name('blog');
    Route::get('/noticias/{noticia}', 'showNoticia')->name('noticias.show');

    Route::get('/contacto', 'contacto')->name('contacto');
});

// Redirigir al dashboard correcto según el rol del usuario autenticado
Route::get('/dashboard', function () {
    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.inicio');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para PayPal
Route::post('/payment/create-order', [App\Http\Controllers\PaymentController::class, 'createOrder'])->name('payment.create-order');
Route::post('/payment/capture-order', [App\Http\Controllers\PaymentController::class, 'captureOrder'])->name('payment.capture-order');
Route::post('/payment/cancel-order', [App\Http\Controllers\PaymentController::class, 'cancelOrder'])->name('payment.cancel-order');

// Grupo de rutas para Administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rutas para la gestión de todo lo relaciona con concursos
    Route::get('/admin/concursos', [ConcursoController::class, 'index'])->name('admin.concursos.index');
    Route::get('/admin/concursos/create', [ConcursoController::class, 'create'])->name('admin.concursos.create');
    Route::post('/admin/concursos', [ConcursoController::class, 'store'])->name('admin.concursos.store');
    Route::get('/admin/concursos/{concurso}/edit', [ConcursoController::class, 'edit'])->name('admin.concursos.edit');
    Route::put('/admin/concursos/{concurso}', [ConcursoController::class, 'update'])->name('admin.concursos.update');
    Route::delete('/admin/concursos/{concurso}', [ConcursoController::class, 'destroy'])->name('admin.concursos.destroy');

    Route::get('/admin/convocatorias', [ConvocatoriaConcursoController::class, 'index'])->name('admin.concursos.convocatorias.index');
    Route::get('/admin/convocatorias/create', [ConvocatoriaConcursoController::class, 'create'])->name('admin.concursos.convocatorias.create');
    Route::post('/admin/convocatorias', [ConvocatoriaConcursoController::class, 'store'])->name('admin.concursos.convocatorias.store');
    Route::get('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'show'])->name('admin.concursos.convocatorias.show');
    Route::get('/admin/convocatorias/{convocatoria}/edit', [ConvocatoriaConcursoController::class, 'edit'])->name('admin.concursos.convocatorias.edit');
    Route::put('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'update'])->name('admin.concursos.convocatorias.update');
    Route::delete('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'destroy'])->name('admin.concursos.convocatorias.destroy');

    Route::get('/admin/pre-registros', [PreRegistroConcursoController::class, 'index'])->name('admin.concursos.pre-registros.index');
    Route::get('/admin/pre-registros/{preRegistro}', [PreRegistroConcursoController::class, 'show'])->name('admin.concursos.pre-registros.show');
    Route::get('/admin/pre-registros/{preRegistro}/edit', [PreRegistroConcursoController::class, 'edit'])->name('admin.concursos.pre-registros.edit');
    Route::put('/admin/pre-registros/{preRegistro}', [PreRegistroConcursoController::class, 'update'])->name('admin.concursos.pre-registros.update');
    Route::delete('/admin/pre-registros/{preRegistro}', [PreRegistroConcursoController::class, 'destroy'])->name('admin.concursos.pre-registros.destroy');
    Route::put('/admin/pre-registros/{preRegistro}/estado', [PreRegistroConcursoController::class, 'updateEstado'])->name('admin.concursos.pre-registros.update-estado');
    Route::get('/admin/pre-registros/{preRegistro}/download-pdr', [PreRegistroConcursoController::class, 'downloadPdr'])->name('admin.concursos.pre-registros.download-pdr');


    // Rutas para la gestión de usuarios
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

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



    Route::get('/admin/congresos-eventos', [AdminController::class, 'congresosEventos'])->name('admin.congresos-eventos');
    Route::get('/admin/becas', [AdminController::class, 'becas'])->name('admin.becas');
    Route::get('/admin/pagos-facturacion', [App\Http\Controllers\Admin\AdminPayPalController::class, 'showTransactions'])->name('admin.pagos-facturacion');
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

// Rutas administrativas para PayPal
Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function() {
    Route::get('/pagos', [\App\Http\Controllers\Admin\AdminPayPalController::class, 'showTransactions'])->name('admin.pagos.index');
    Route::post('/pagos/webhook', [\App\Http\Controllers\Admin\AdminPayPalController::class, 'handleWebhook']);
});

// Grupo de rutas para Usuarios
Route::middleware(['auth', 'role:usuario'])->group(function () {
    // Rutas de pago con PayPal
    Route::post('/payment/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/payment/capture-order', [PaymentController::class, 'captureOrder']);
    Route::post('/payment/cancel-order', [PaymentController::class, 'cancelOrder']);

    Route::get('/user/inicio', [UserController::class, 'index'])->name('user.inicio');

    //Ruta para la pagina del sistema solar
    Route::get('/user/espacio', [UserController::class, 'espacio'])->name('user.espacio');

    //Ruta para la pagina de noticias
    Route::get('/user/noticias', [UserController::class, 'noticia'])->name('user.noticias');
    Route::get('/user/noticias/{noticia}', [UserController::class, 'showNoticia'])->name('user.noticias.show');

    Route::get('/user/cursos', [UserController::class, 'cursos'])->name('user.cursos');
    Route::get('/user/talleres', [UserController::class, 'talleres'])->name('user.talleres');
    Route::get('/user/ponencias', [UserController::class, 'ponencias'])->name('user.ponencias');

    // Rutas para la gestión de concursos del usuario
    Route::get('/user/concursos', [ConcursoUserController::class, 'index'])->name('user.concursos.index');
    Route::get('/user/concursos/{concurso}', [ConcursoUserController::class, 'show'])->name('user.concursos.show');
    // Rutas para la gestión de convocatorias del usuario
    Route::get('/user/convocatorias', [ConvocatoriaUserController::class, 'index'])->name('user.concursos.convocatorias.index');
    Route::get('/user/convocatorias/{convocatoria}', [ConvocatoriaUserController::class, 'show'])->name('user.concursos.convocatorias.show');

    // Rutas para la gestión de pre-registros del usuario
    Route::get('/user/pre-registros', [PreRegistroUserController::class, 'index'])->name('user.concursos.pre-registros.index');
    Route::get('/user/pre-registros/create/{convocatoria}', [PreRegistroUserController::class, 'create'])->name('user.concursos.pre-registros.create');


    Route::post('/user/pre-registros', [PreRegistroUserController::class, 'store'])->name('user.concursos.pre-registros.store');
    Route::get('/user/pre-registros/{preRegistro}', [PreRegistroUserController::class, 'show'])->name('user.concursos.pre-registros.show');
    Route::get('/user/pre-registros/{preRegistro}/edit', [PreRegistroUserController::class, 'edit'])->name('user.concursos.pre-registros.edit');
    Route::get('/user/pre-registros/{preRegistro}/download-pdr', [PreRegistroUserController::class, 'downloadPdr'])->name('user.concursos.pre-registros.download-pdr');
    Route::put('/user/pre-registros/{preRegistro}', [PreRegistroUserController::class, 'update'])->name('user.concursos.pre-registros.update');
    Route::delete('/user/pre-registros/{preRegistro}', [PreRegistroUserController::class, 'destroy'])->name('user.concursos.pre-registros.destroy');


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

require __DIR__ . '/auth.php';

