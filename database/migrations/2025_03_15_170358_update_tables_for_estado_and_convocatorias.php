<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Crear la tabla de inscripciones para cursos
        Schema::create('inscripciones_cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla 'users'
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade'); // Relación con la tabla 'cursos'
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente'); // Estado de la inscripción
            $table->timestamps();
            $table->softDeletes(); // Para eliminar registros sin borrarlos permanentemente
        });

        // Crear la tabla de inscripciones para talleres
        Schema::create('inscripciones_talleres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla 'users'
            $table->foreignId('taller_id')->constrained('talleres')->onDelete('cascade'); // Relación con la tabla 'talleres'
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente'); // Estado de la inscripción
            $table->timestamps();
            $table->softDeletes();
        });

        // Crear la tabla de inscripciones para ponencias
        Schema::create('inscripciones_ponencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla 'users'
            $table->foreignId('ponencia_id')->constrained('ponencias')->onDelete('cascade'); // Relación con la tabla 'ponencias'
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente'); // Estado de la inscripción
            $table->timestamps();
            $table->softDeletes();
        });


        // Crear la tabla de inscripciones para congresos
        Schema::create('inscripciones_congresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla 'users'
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade'); // Relación con la tabla 'congresos'
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente'); // Estado de la inscripción
            $table->timestamps();
            $table->softDeletes();
        });

        // Agregar la columna "estado" a las tablas existentes
        Schema::table('cursos', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');
        });

        Schema::table('talleres', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');
        });

        Schema::table('ponencias', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');
        });

      
    }

    public function down()
    {
        // Eliminar las columnas "estado"
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('talleres', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('ponencias', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('concursos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        // Eliminar las tablas de inscripciones
        Schema::dropIfExists('inscripciones_cursos');
        Schema::dropIfExists('inscripciones_talleres');
        Schema::dropIfExists('inscripciones_ponencias');
        Schema::dropIfExists('inscripciones_congresos');

        
    }
};
