<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_concursos';

    protected $fillable = [
        'usuario_id',
        'concurso_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'concurso_id');
    }
}