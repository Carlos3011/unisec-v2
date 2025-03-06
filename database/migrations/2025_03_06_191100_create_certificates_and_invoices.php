<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->string('codigo_validacion')->unique();
            $table->date('fecha_emision');
            $table->string('estado');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('pago_id')->constrained('pagos');
            $table->decimal('total', 10, 2);
            $table->string('estado');
            $table->date('fecha_emision');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('certificados');
    }
};