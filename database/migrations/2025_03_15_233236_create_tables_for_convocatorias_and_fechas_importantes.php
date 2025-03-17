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
        // Tabla de Convocatorias (Con Relación Polimórfica)
        Schema::create('convocatorias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable(); // Ruta de la imagen
            $table->string('archivo_pdf')->nullable(); // Ruta del archivo PDF
            
            // Relación polimórfica con cursos, talleres, ponencias y concursos
            $table->unsignedBigInteger('evento_id'); // ID del evento asociado
            $table->string('evento_type'); // Tipo de evento (Curso, Taller, Ponencia, Concurso)

            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla de Fechas Importantes para cada Convocatoria
        Schema::create('fechas_importantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocatoria_id')->constrained('convocatorias')->onDelete('cascade');
            $table->string('titulo'); // Ejemplo: "Inicio de Inscripción"
            $table->date('fecha'); // Fecha específica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // Eliminar tablas en orden inverso para evitar conflictos
       Schema::dropIfExists('fechas_importantes');
       Schema::dropIfExists('convocatorias');
    }
};
