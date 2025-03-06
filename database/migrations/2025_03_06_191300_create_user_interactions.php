<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->morphs('resenable');
            $table->integer('calificacion');
            $table->text('comentario');
            $table->string('estado');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->morphs('materialeable');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('tipo_archivo');
            $table->string('ruta_archivo');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('becas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->decimal('monto', 10, 2);
            $table->string('estado');
            $table->date('fecha_solicitud');
            $table->date('fecha_resolucion')->nullable();
            $table->text('justificacion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('becas');
        Schema::dropIfExists('materiales');
        Schema::dropIfExists('resenas');
    }
};