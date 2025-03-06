<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ponentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('bio');
            $table->string('especialidad');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('tema_id')->constrained('temas');
            $table->foreignId('ponente_id')->constrained('ponentes');
            $table->decimal('costo', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('talleres', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('tema_id')->constrained('temas');
            $table->foreignId('ponente_id')->constrained('ponentes');
            $table->decimal('costo', 10, 2);
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ponencias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('tema_id')->constrained('temas');
            $table->foreignId('ponente_id')->constrained('ponentes');
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('concursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('reglas');
            $table->text('premios');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('tema_id')->constrained('temas');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('concursos');
        Schema::dropIfExists('ponencias');
        Schema::dropIfExists('talleres');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('ponentes');
    }
};