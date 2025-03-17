<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convocatoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'convocatorias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'archivo_pdf',
        'evento_id',
        'evento_type'
    ];

    public function evento()
    {
        return $this->morphTo();
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'evento_id')->where('tipo_evento', 'curso');
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'evento_id')->where('tipo_evento', 'taller');
    }

    public function congreso()
    {
        return $this->belongsTo(Congreso::class, 'evento_id')->where('tipo_evento', 'congreso');
    }

    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'evento_id')->where('tipo_evento', 'concurso');
    }
}