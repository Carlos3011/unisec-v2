<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('congresos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');  // Estado del concurso, con valor por defecto 'pendiente'.
            $table->timestamps();
            $table->softDeletes();
        });


        // Tabla para almacenar las convocatorias del congreso
        Schema::create('convocatorias_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('congreso_id')
                ->constrained('congresos')
                ->onDelete('cascade');
            $table->text('descripcion');
            $table->string('sede');
            $table->string('dirigido_a')
                ->default('Docentes/Investigadores y Estudiantes');
            $table->text('requisitos');
            $table->json('tematicas');
            $table->text('criterios_evaluacion');
            $table->text('formato_articulo');
            $table->text('formato_extenso')->nullable();
            $table->json('cuotas_inscripcion')->nullable();
            $table->string('contacto_email')->nullable();
            $table->string('archivo_convocatoria')->nullable();
            $table->string('archivo_articulo')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para pagos de inscripción al congreso
        Schema::create('pagos_inscripcion_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago')->default('paypal');
            $table->string('referencia_paypal')->nullable();
            $table->string('paypal_order_id')->nullable();

            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');
            $table->timestamp('fecha_pago')->nullable();
            $table->text('detalles_transaccion')->nullable();
            $table->string('comprobante_pago')->nullable();
            $table->timestamps();
        });

        // Tabla para fechas importantes del congreso
        Schema::create('fechas_importantes_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocatoria_congreso_id')->constrained('convocatorias_congreso')->onDelete('cascade');
            $table->string('titulo');
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para almacenar los artículos del congreso
        Schema::create('articulos_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->foreignId('convocatoria_congreso_id')->constrained('convocatorias_congreso')->onDelete('cascade');
            $table->string('titulo');
            $table->json('autores_data'); // Almacena información de los autores;
            $table->string('archivo_articulo')->nullable(); // Archivo del artículo
            $table->string('archivo_extenso')->nullable(); // Documento en extenso
            $table->enum('estado_articulo', ['pendiente', 'en_revision', 'aceptado', 'rechazado'])->default('pendiente');
            $table->enum('estado_extenso', ['pendiente', 'en_revision', 'aceptado', 'rechazado'])->default('pendiente');
            $table->text('comentarios_articulo')->nullable();
            $table->text('comentarios_extenso')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para inscripciones al congreso
        Schema::create('inscripciones_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->foreignId('articulo_id')->nullable()->constrained('articulos_congreso')->onDelete('cascade');
            $table->foreignId('convocatoria_congreso_id')->constrained('convocatorias_congreso')->onDelete('cascade');
            $table->enum('tipo_participante', ['estudiante', 'docente', 'investigador', 'profesional'])->default('estudiante');
            $table->string('institucion');
            $table->string('comprobante_estudiante')->nullable(); // Para estudiantes que requieran validar su estatus
            $table->foreignId('pago_inscripcion_id')->constrained('pagos_inscripcion_congreso')->onDelete('cascade');  // Relación con el pago previo
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos_inscripcion_congreso');
        Schema::dropIfExists('inscripciones_congreso');
        Schema::dropIfExists('articulos_congreso');
        Schema::dropIfExists('fechas_importantes_congreso');
        Schema::dropIfExists('convocatorias_congreso');
        Schema::dropIfExists('congresos');
    }
};