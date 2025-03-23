<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImagenConcurso extends Model
{
    use SoftDeletes;

    protected $table = 'imagenes_concursos';

    protected $fillable = [
        'convocatorias_concursos_id',
        'imagen',
        'descripcion'
    ];

    public function convocatoriaConcurso(): BelongsTo
    {
        return $this->belongsTo(ConvocatoriaConcurso::class, 'convocatorias_concursos_id');
    }
}