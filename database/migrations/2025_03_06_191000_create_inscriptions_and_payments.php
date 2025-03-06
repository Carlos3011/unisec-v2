<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->string('estado');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago');
            $table->string('estado');
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('historial_sesiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->dateTime('fecha_hora');
            $table->string('ip');
            $table->string('dispositivo');
            $table->string('estado_sesion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_sesiones');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('inscripciones');
    }
};