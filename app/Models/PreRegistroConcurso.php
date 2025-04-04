<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreRegistroConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pre_registro_concursos';

    protected $fillable = [
        'usuario_id',
        'concurso_id',
        'nombre_equipo',
        'integrantes',
        'asesor',
        'institucion',
        'estado',
        'archivo_pdr',
        'estado_pdr',
        'comentarios_pdr',
        'integrantes_data'
    ];

    protected $casts = [
        'integrantes' => 'integer',
        'estado' => 'string',
        'estado_pdr' => 'string',
        'integrantes_data' => 'array'
    ];

    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_VALIDADO = 'validado';
    const ESTADO_RECHAZADO = 'rechazado';

    const ESTADO_PDR_PENDIENTE = 'pendiente';
    const ESTADO_PDR_EN_REVISION = 'en revisión';
    const ESTADO_PDR_APROBADO = 'aprobado';
    const ESTADO_PDR_RECHAZADO = 'rechazado';

    /**
     * Obtiene el usuario asociado al pre-registro.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Obtiene el concurso asociado al pre-registro.
     */
    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'concurso_id');
    }

    /**
     * Obtiene los integrantes del equipo asociados al pre-registro.
     */
    public function integrantes()
    {
        return $this->hasMany(IntegranteEquipoConcurso::class, 'pre_registro_concurso_id');
    }



}