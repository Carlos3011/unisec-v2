<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoTerceroTransferenciaConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_terceros_transferencia_concurso';

    protected $fillable = [
        'usuario_id',
        'concurso_id',
        'tipo_tercero',
        'nombre_tercero',
        'rfc_tercero',
        'contacto_tercero',
        'correo_tercero',
        'comprobante_pago',
        'monto_total',
        'estado_pago',
        'referencia_transferencia',
        'numero_pagos',
        'cubre_pre_registro',
        'cubre_inscripcion',
        'codigo_validacion_unico',
        'fecha_pago'
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'numero_pagos' => 'integer',
        'cubre_pre_registro' => 'boolean',
        'cubre_inscripcion' => 'boolean',
        'fecha_pago' => 'datetime',
        'tipo_tercero' => 'string',
        'estado_pago' => 'string'
    ];

    protected $attributes = [
        'tipo_tercero' => 'persona_fisica',
        'estado_pago' => 'pendiente',
        'numero_pagos' => 1,
        'cubre_pre_registro' => false,
        'cubre_inscripcion' => false
    ];

    public function concurso()
    {
        return $this->belongsTo(Concurso::class);
    }

    public function preRegistros()
    {
        return $this->hasMany(PreRegistroConcurso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    public function inscripciones()
    {
        return $this->hasMany(InscripcionConcurso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}