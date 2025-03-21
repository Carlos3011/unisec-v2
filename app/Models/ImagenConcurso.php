<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenConcurso extends Model
{
    protected $table = 'imagenes_concurso';

    protected $fillable = [
        'convocatoria_concurso_id',
        'imagen',
        'descripcion'
    ];

    public function convocatoriaConcurso(): BelongsTo
    {
        return $this->belongsTo(ConvocatoriaConcurso::class);
    }
}