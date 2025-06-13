<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoTerceroCongreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_terceros_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
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
        'codigo_validacion_unico',
        'fecha_pago'
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'fecha_pago' => 'datetime',
        'numero_pagos' => 'integer'
    ];

    // Tipos de terceros
    const TIPO_UNIVERSIDAD = 'universidad';
    const TIPO_EMPRESA = 'empresa';
    const TIPO_PERSONA_FISICA = 'persona_fisica';

    // Estados de pago
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_VALIDADO = 'validado';
    const ESTADO_RECHAZADO = 'rechazado';

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function congreso()
    {
        return $this->belongsTo(Congreso::class);
    }

    // Métodos de utilidad
    public function isValidado()
    {
        return $this->estado_pago === self::ESTADO_VALIDADO;
    }

    public function isPendiente()
    {
        return $this->estado_pago === self::ESTADO_PENDIENTE;
    }

    public function isRechazado()
    {
        return $this->estado_pago === self::ESTADO_RECHAZADO;
    }

    public function isUniversidad()
    {
        return $this->tipo_tercero === self::TIPO_UNIVERSIDAD;
    }

    public function isEmpresa()
    {
        return $this->tipo_tercero === self::TIPO_EMPRESA;
    }

    public function isPersonaFisica()
    {
        return $this->tipo_tercero === self::TIPO_PERSONA_FISICA;
    }
}