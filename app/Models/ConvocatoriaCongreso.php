<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConvocatoriaCongreso extends Model
{
    use SoftDeletes;

    protected $table = 'convocatorias_congreso';

    protected $fillable = [
        'congreso_id',
        'descripcion',
        'sede',
        'dirigido_a',
        'requisitos',
        'tematicas',
        'criterios_evaluacion',
        'formato_articulo',
        'formato_extenso',
        'costo_inscripcion',
        'cuotas_inscripcion',
        'contacto_email',
        'archivo_convocatoria',
        'archivo_articulo',
        'imagen_portada'
    ];

    protected $casts = [
        'tematicas' => 'array',
        'cuotas_inscripcion' => 'array',
        'costo_inscripcion' => 'decimal:2'
    ];

    // Relación con el congreso
    public function congreso(): BelongsTo
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    // Relación con fechas importantes
    public function fechasImportantes(): HasMany
    {
        return $this->hasMany(FechaImportanteCongreso::class, 'convocatoria_congreso_id');
    }

    // Relación con artículos
    public function articulos(): HasMany
    {
        return $this->hasMany(ArticuloCongreso::class, 'convocatoria_congreso_id');
    }
}