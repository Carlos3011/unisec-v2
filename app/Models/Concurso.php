<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'concursos';

    protected $fillable = [
        'titulo',
        'categoria_id',
        'tema_id',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(InscripcionConcurso::class);
    }

    public function convocatorias()
    {
        return $this->hasMany(ConvocatoriaConcurso::class);
    }

    public function preRegistros()
    {
        return $this->hasMany(PreRegistroConcurso::class);
    }

    public function pagos()
    {
        return $this->hasManyThrough(PagoConcurso::class, InscripcionConcurso::class);
    }
}