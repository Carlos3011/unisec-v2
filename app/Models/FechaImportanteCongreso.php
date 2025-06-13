<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FechaImportanteCongreso extends Model
{
    use SoftDeletes;

    protected $table = 'fechas_importantes_congreso';

    protected $fillable = [
        'convocatoria_congreso_id',
        'titulo',
        'fecha',
        'descripcion'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    // Relación con la convocatoria
    public function convocatoria(): BelongsTo
    {
        return $this->belongsTo(ConvocatoriaCongreso::class, 'convocatoria_congreso_id');
    }
}