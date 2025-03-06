<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('congresos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('eventos_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('congreso_id')->constrained('congresos');
            $table->string('tipo');
            $table->string('titulo');
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('asistencias_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('evento_id')->constrained('eventos_congreso');
            $table->string('estado_asistencia');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias_eventos');
        Schema::dropIfExists('eventos_congreso');
        Schema::dropIfExists('congresos');
    }
};