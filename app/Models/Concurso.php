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
        'reglas',
        'premios',
        'categoria_id',
        'tema_id',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    protected $casts = [
        'estado' => 'string',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
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
        return $this->morphMany(Convocatoria::class, 'evento');
    }
}