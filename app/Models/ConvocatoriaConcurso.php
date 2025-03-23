<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConvocatoriaConcurso extends Model
{
    use SoftDeletes;
    protected $table = 'convocatorias_concursos';

    protected $fillable = [
        'concurso_id',
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
        'archivo_convocatoria',
        'imagen_portada',
        'archivo_pdr',
        'archivo_cdr',
        'archivo_pfr',
        'archivo_articulo'
    ];

    public function concurso()
    {
        return $this->belongsTo(Concurso::class);
    }

    protected $casts = [
        'asesor_requerido' => 'boolean',
        'max_integrantes' => 'integer'
    ];

    public function fechasImportantes(): HasMany
    {
        return $this->hasMany(FechaImportanteConcurso::class, 'convocatorias_concursos_id');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenConcurso::class, 'convocatorias_concursos_id');
    }
}