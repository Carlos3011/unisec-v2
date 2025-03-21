<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConvocatoriaConcurso extends Model
{
    protected $table = 'convocatoria_concursos';

    protected $fillable = [
        'nombre_evento',
        'sede',
        'dirigido_a',
        'max_integrantes',
        'asesor_requerido',
        'requisitos',
        'etapas_mision',
        'pruebas_requeridas',
        'documentacion_requerida',
        'criterios_evaluacion',
        'premiacion',
        'penalizaciones',
        'contacto_email',
        'archivo_pdf',
        'imagen_portada',
        'archivo_pdr',
        'archivo_cdr',
        'archivo_pfr',
        'articulos_requeridos'
    ];

    protected $casts = [
        'asesor_requerido' => 'boolean',
        'max_integrantes' => 'integer'
    ];

    public function fechasImportantes(): HasMany
    {
        return $this->hasMany(FechaImportanteConcurso::class);
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenConcurso::class);
    }
}