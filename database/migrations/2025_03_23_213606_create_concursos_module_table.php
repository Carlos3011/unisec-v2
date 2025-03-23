<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Creación de la tabla 'concursos' para almacenar información sobre los concursos.
        Schema::create('concursos', function (Blueprint $table) {
            $table->id();  // Creación de la columna 'id' como clave primaria.
            $table->string('titulo');  // Título del concurso.
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');  // Relación con la tabla 'categorias', eliminando concursos si se elimina la categoría.
            $table->foreignId('tema_id')->constrained('temas')->onDelete('cascade');  // Relación con la tabla 'temas', eliminando concursos si se elimina el tema.
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');  // Estado del concurso, con valor por defecto 'pendiente'.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave (no físico) de registros.
        });

        // Creación de la tabla 'convocatorias_concursos' para almacenar convocatorias relacionadas a concursos.
        Schema::create('convocatorias_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con la tabla 'concursos', eliminando convocatorias si se elimina el concurso.
            $table->string('sede');  // Ubicación de la convocatoria.
            $table->string('dirigido_a')->default('Estudiantes de nivel licenciatura');  // Público al que está dirigida la convocatoria.
            $table->integer('max_integrantes')->default(5);  // Número máximo de integrantes por equipo.
            $table->boolean('asesor_requerido')->default(true);  // Indica si se requiere asesor para el equipo.
            $table->text('requisitos');  // Requisitos para participar en la convocatoria.
            $table->text('etapas_mision');  // Descripción de las etapas o misión del concurso.
            $table->text('pruebas_requeridas');  // Pruebas necesarias para participar.
            $table->string('documentacion_requerida')->default('PDR, CDR, PFR');  // Documentos requeridos (PDR, CDR, PFR).
            $table->text('criterios_evaluacion');  // Criterios que se utilizarán para evaluar a los participantes.
            $table->text('premiacion')->nullable();  // Información sobre los premios del concurso (opcional).
            $table->text('penalizaciones')->nullable();  // Penalizaciones por incumplimiento de reglas (opcional).
            $table->string('contacto_email')->nullable();  // Correo electrónico de contacto.
            $table->string('archivo_convocatoria')->nullable();  // PDF con la convocatoria general.
            $table->string('imagen_portada')->nullable();  // Imagen que representa la convocatoria.
            $table->string('archivo_pdr')->nullable();  // Archivo con el PDR.
            $table->string('archivo_cdr')->nullable();  // Archivo con el CDR.
            $table->string('archivo_pfr')->nullable();  // Archivo con el PFR.
            $table->string('archivo_articulo')->nullable();  // Archivo con los artículos requeridos.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las convocatorias.
        });

        // Creación de la tabla 'fechas_importantes_concursos' para registrar fechas clave de las convocatorias.
        Schema::create('fechas_importantes_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('convocatorias_concursos_id')->constrained('convocatorias_concursos')->onDelete('cascade');  // Relación con la tabla 'convocatorias_concursos', eliminando fechas si se elimina la convocatoria.
            $table->string('titulo');  // Título o nombre de la fecha importante.
            $table->date('fecha');  // Fecha importante.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las fechas importantes.
        });

        // Creación de la tabla 'imagenes_concursos' para almacenar imágenes relacionadas con las convocatorias.
        Schema::create('imagenes_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('convocatorias_concursos_id')->constrained('convocatorias_concursos')->onDelete('cascade');  // Relación con la tabla 'convocatorias_concursos', eliminando imágenes si se elimina la convocatoria.
            $table->string('imagen');  // URL o nombre de la imagen.
            $table->string('descripcion')->nullable();  // Descripción opcional de la imagen.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las imágenes.
        });

        // Creación de la tabla 'inscripciones_concursos' para registrar las inscripciones de los usuarios a los concursos.
        Schema::create('inscripciones_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con la tabla 'users', eliminando inscripciones si se elimina el usuario.
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con la tabla 'concursos', eliminando inscripciones si se elimina el concurso.
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');  // Estado de la inscripción.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las inscripciones.
        });

        // Creación de la tabla 'pre_registro_concursos' para almacenar los pre-registros de los equipos en los concursos.
        Schema::create('pre_registro_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con la tabla 'users', eliminando pre-registros si se elimina el usuario.
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con la tabla 'concursos', eliminando pre-registros si se elimina el concurso.
            $table->string('nombre_equipo');  // Nombre del equipo.
            $table->integer('integrantes')->default(1);  // Número de integrantes en el equipo.
            $table->string('asesor')->nullable();  // Asesor del equipo (opcional).
            $table->string('institucion')->nullable();  // Institución a la que pertenece el equipo (opcional).
            $table->text('comentarios')->nullable();  // Comentarios adicionales (opcional).
            $table->enum('estado', ['pendiente', 'validado', 'rechazado'])->default('pendiente');  // Estado del pre-registro.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de los pre-registros.
        });

        // Creación de la tabla 'pagos_concursos' para registrar los pagos realizados por los participantes en los concursos.
        Schema::create('pagos_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('inscripcion_concurso_id')->constrained('inscripciones_concursos')->onDelete('cascade');  // Relación con la tabla 'inscripciones_concursos', eliminando pagos si se elimina la inscripción.
            $table->decimal('monto', 10, 2);  // Monto del pago.
            $table->string('metodo_pago');  // Método de pago (Ejemplo: 'paypal', 'transferencia', 'tarjeta').
            $table->string('referencia')->nullable();  // Referencia del pago (opcional).
            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');  // Estado del pago.
            $table->timestamp('fecha_pago')->nullable();  // Fecha en que se realizó el pago (opcional).
            $table->timestamps();  // Registra las fechas de creación y actualización.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminación de las tablas creadas en caso de revertir la migración.
        Schema::dropIfExists('pagos_concursos');
        Schema::dropIfExists('pre_registro_concursos');
        Schema::dropIfExists('inscripciones_concursos');
        Schema::dropIfExists('imagenes_concursos');
        Schema::dropIfExists('fechas_importantes_concursos');
        Schema::dropIfExists('convocatorias_concursos');
        Schema::dropIfExists('concursos');
    }
};
