<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('fechas_importantes');
        Schema::dropIfExists('convocatorias');

        Schema::create('convocatoria_concursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_evento');
            $table->string('sede');
            $table->string('dirigido_a')->default('Estudiantes de nivel licenciatura');
            $table->integer('max_integrantes')->default(5);
            $table->boolean('asesor_requerido')->default(true);
            $table->text('requisitos');
            $table->text('etapas_mision');
            $table->text('pruebas_requeridas');
            $table->string('documentacion_requerida')->default('PDR, CDR, PFR');
            $table->text('criterios_evaluacion');
            $table->text('premiacion')->nullable();
            $table->text('penalizaciones')->nullable();
            $table->string('contacto_email')->nullable();
            $table->string('archivo_pdf')->nullable(); // Para el archivo PDF general
            $table->string('imagen_portada')->nullable();
            $table->string('archivo_pdr')->nullable();  // Campo para el archivo PDR
            $table->string('archivo_cdr')->nullable();  // Campo para el archivo CDR
            $table->string('archivo_pfr')->nullable();  // Campo para el archivo PFR
            $table->string('articulos_requeridos')->nullable(); // Campo para los artículos requeridos
            $table->timestamps();
        });

        Schema::create('fechas_importantes_concursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocatoria_concurso_id')->constrained('convocatoria_concursos')->onDelete('cascade');
            $table->string('titulo');
            $table->date('fecha');
            $table->timestamps();
        });

        Schema::create('imagenes_concurso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocatoria_concurso_id')->constrained('convocatoria_concursos')->onDelete('cascade');
            $table->string('imagen');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_concurso');
        Schema::dropIfExists('fechas_importantes_concursos');
        Schema::dropIfExists('convocatoria_concursos');
    }
};
