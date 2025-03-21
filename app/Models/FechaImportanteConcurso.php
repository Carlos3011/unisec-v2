<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FechaImportanteConcurso extends Model
{
    protected $table = 'fechas_importantes_concursos';

    protected $fillable = [
        'convocatoria_concurso_id',
        'titulo',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    public function convocatoriaConcurso(): BelongsTo
    {
        return $this->belongsTo(ConvocatoriaConcurso::class);
    }
}