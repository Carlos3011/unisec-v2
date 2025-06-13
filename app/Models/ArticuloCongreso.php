<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticuloCongreso extends Model
{
    use SoftDeletes;

    protected $table = 'articulos_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'convocatoria_congreso_id',
        'titulo',
        'autores_data',
        'archivo_articulo',
        'archivo_extenso',
        'estado_articulo',
        'estado_extenso',
        'comentarios_articulo',
        'comentarios_extenso'
    ];

    protected $casts = [
        'autores_data' => 'array'
    ];

    // Estados posibles para artículos y extensos
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_EN_REVISION = 'en_revision';
    const ESTADO_ACEPTADO = 'aceptado';
    const ESTADO_RECHAZADO = 'rechazado';

    // Relación con el usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el congreso
    public function congreso(): BelongsTo
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    // Relación con la convocatoria
    public function convocatoria(): BelongsTo
    {
        return $this->belongsTo(ConvocatoriaCongreso::class, 'convocatoria_congreso_id');
    }

    // Relación con pagos de inscripción
    public function pagosInscripcion(): HasMany
    {
        return $this->hasMany(PagoInscripcionCongreso::class, 'articulo_id');
    }
}