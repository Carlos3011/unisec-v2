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
        'imagen_portada',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'tematicas' => 'array',
        'cuotas_inscripcion' => 'array',
        'costo_inscripcion' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'estado' => 'string'
    ];

    // Estados posibles de la convocatoria
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_INACTIVO = 'inactivo';
    const ESTADO_PENDIENTE = 'pendiente';

    // Métodos de utilidad para verificar estados
    public function estaActiva(): bool
    {
        return $this->estado === self::ESTADO_ACTIVO;
    }

    public function estaInactiva(): bool
    {
        return $this->estado === self::ESTADO_INACTIVO;
    }

    public function estaPendiente(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

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

    // Relación con las inscripciones
    public function inscripciones(): HasMany
    {
        return $this->hasMany(InscripcionCongreso::class, 'convocatoria_congreso_id');
    }
}