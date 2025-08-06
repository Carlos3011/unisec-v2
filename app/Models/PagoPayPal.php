<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PagoPaypal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_paypal';

    protected $fillable = [
        'usuario_id',
        'pagable_type',
        'pagable_id',
        'monto',
        'moneda',
        'paypal_payment_id',
        'paypal_payer_id',
        'paypal_payment_token',
        'paypal_order_id',
        'estado',
        'paypal_response',
        'email_pagador',
        'nombre_pagador',
        'fecha_pago',
        'fecha_vencimiento',
        'descripcion',
        'numero_factura',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'paypal_response' => 'array',
        'fecha_pago' => 'datetime',
        'fecha_vencimiento' => 'datetime',
    ];

    protected $dates = [
        'fecha_pago',
        'fecha_vencimiento',
        'deleted_at',
    ];

    /**
     * Estados disponibles para el pago
     */
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_COMPLETADO = 'completado';
    const ESTADO_CANCELADO = 'cancelado';
    const ESTADO_FALLIDO = 'fallido';
    const ESTADO_REEMBOLSADO = 'reembolsado';

    /**
     * Relación con el usuario que realizó el pago
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación polimórfica con el elemento pagable (curso, taller, concurso, etc.)
     */
    public function pagable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relación con el historial de estados
     */
    public function historialEstados(): MorphMany
    {
        return $this->morphMany(HistorialEstadoPago::class, 'pago');
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para pagos completados
     */
    public function scopeCompletados($query)
    {
        return $query->where('estado', self::ESTADO_COMPLETADO);
    }

    /**
     * Scope para pagos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
    }

    /**
     * Verifica si el pago está completado
     */
    public function estaCompletado(): bool
    {
        return $this->estado === self::ESTADO_COMPLETADO;
    }

    /**
     * Verifica si el pago está pendiente
     */
    public function estaPendiente(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

    /**
     * Verifica si el pago fue reembolsado
     */
    public function fueReembolsado(): bool
    {
        return $this->estado === self::ESTADO_REEMBOLSADO;
    }

    /**
     * Obtiene el monto formateado con la moneda
     */
    public function getMontoFormateadoAttribute(): string
    {
        return number_format($this->monto, 2) . ' ' . $this->moneda;
    }

    /**
     * Obtiene los últimos 4 dígitos del payment ID para mostrar
     */
    public function getPaymentIdCortoAttribute(): string
    {
        return '****' . substr($this->paypal_payment_id, -4);
    }

    /**
     * Cambia el estado del pago y registra en el historial
     */
    public function cambiarEstado(string $nuevoEstado, string $motivo = null, int $usuarioCambio = null): bool
    {
        $estadoAnterior = $this->estado;
        
        $this->estado = $nuevoEstado;
        
        if ($nuevoEstado === self::ESTADO_COMPLETADO && !$this->fecha_pago) {
            $this->fecha_pago = now();
        }
        
        $guardado = $this->save();
        
        if ($guardado) {
            // Registrar en el historial
            $this->historialEstados()->create([
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $nuevoEstado,
                'motivo' => $motivo,
                'usuario_cambio' => $usuarioCambio,
            ]);
        }
        
        return $guardado;
    }

    /**
     * Obtiene todos los estados disponibles
     */
    public static function getEstadosDisponibles(): array
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_COMPLETADO => 'Completado',
            self::ESTADO_CANCELADO => 'Cancelado',
            self::ESTADO_FALLIDO => 'Fallido',
            self::ESTADO_REEMBOLSADO => 'Reembolsado',
        ];
    }
}