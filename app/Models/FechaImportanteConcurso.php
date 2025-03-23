<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FechaImportanteConcurso extends Model
{
    use SoftDeletes;
    
    protected $table = 'fechas_importantes_concursos';

    protected $fillable = [
        'convocatorias_concursos_id',
        'titulo',
        'fecha'
    ];

    public function convocatoriaConcurso()
    {
        return $this->belongsTo(ConvocatoriaConcurso::class, 'convocatorias_concursos_id');
    }

    protected $casts = [
        'fecha' => 'date'
    ];

   
}