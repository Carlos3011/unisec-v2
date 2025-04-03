<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegranteEquipoConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'integrantes_equipo_concurso';

    protected $fillable = [
        'pre_registro_concurso_id',
        'nombre_integrante',
        'matricula',
        'carrera',
        'institucion',
        'correo_institucional',
        'documento_institucional',
        'periodo_academico',
        'tipo_periodo'
    ];

    protected $casts = [
        'periodo_academico' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function preRegistroConcurso()
    {
        return $this->belongsTo(PreRegistroConcurso::class, 'pre_registro_concurso_id');
    }
}