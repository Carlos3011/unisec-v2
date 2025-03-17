<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionCurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_cursos';

    protected $fillable = [
        'usuario_id',
        'curso_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}