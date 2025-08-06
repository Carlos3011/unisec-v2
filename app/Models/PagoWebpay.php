<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PagoWebpay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_webpay';

    protected $fillable = [
        'usuario_id',
        'pagable_type',
        'pagable_id',
        'monto',
        'moneda',
        'webpay_token',
        'webpay_buy_order',
        'webpay_session_id',
        'webpay_authorization_code',
        'webpay_transaction_date',
        'webpay_card_type',
        'webpay_card_number',
        'webpay_installments_number',
        'webpay_installments_amount',
        'estado',
        'webpay_response',
        'fecha_pago',
        'fecha_vencimiento',
        'descripcion',
        'numero_factura',
        'ip_cliente',
        'observaciones',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'webpay_installments_amount' => 'decimal:2',
        'webpay_response' => 'array',
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
    const ESTADO_AUTORIZADO = 'autorizado';
    const ESTADO_COMPLETADO = 'completado';
    const ESTADO_ANULADO = 'anulado';
    const ESTADO_RECHAZADO = 'rechazado';
    const ESTADO_REEMBOLSADO = 'reembolsado';

    /**
     * Tipos de tarjetas soportadas
     */
    const TIPOS_TARJETA = [
        'VI' => 'Visa',
        'MC' => 'Mastercard',
        'AX' => 'American Express',
        'DC' => 'Diners Club',
        'DB' => 'Redcompra',
        'VP' => 'Visa Prepago',
        'MP' => 'Mastercard Prepago',
    ];

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
     * Scope para pagos autorizados
     */
    public function scopeAutorizados($query)
    {
        return $query->where('estado', self::ESTADO_AUTORIZADO);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope para filtrar por tipo de tarjeta
     */
    public function scopePorTipoTarjeta($query, $tipo)
    {
        return $query->where('webpay_card_type', $tipo);
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
     * Verifica si el pago está autorizado
     */
    public function estaAutorizado(): bool
    {
        return $this->estado === self::ESTADO_AUTORIZADO;
    }

    /**
     * Verifica si el pago fue rechazado
     */
    public function fueRechazado(): bool
    {
        return $this->estado === self::ESTADO_RECHAZADO;
    }

    /**
     * Verifica si el pago fue anulado
     */
    public function fueAnulado(): bool
    {
        return $this->estado === self::ESTADO_ANULADO;
    }

    /**
     * Verifica si el pago fue reembolsado
     */
    public function fueReembolsado(): bool
    {
        return $this->estado === self::ESTADO_REEMBOLSADO;
    }

    /**
     * Verifica si el pago se realizó en cuotas
     */
    public function esEnCuotas(): bool
    {
        return $this->webpay_installments_number > 1;
    }

    /**
     * Obtiene el monto formateado con la moneda
     */
    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 0, ',', '.') . ' ' . $this->moneda;
    }

    /**
     * Obtiene el número de tarjeta enmascarado
     */
    public function getTarjetaEnmascaradaAttribute(): string
    {
        if (!$this->webpay_card_number) {
            return 'No disponible';
        }
        
        return '****-****-****-' . $this->webpay_card_number;
    }

    /**
     * Obtiene el nombre del tipo de tarjeta
     */
    public function getNombreTipoTarjetaAttribute(): string
    {
        return self::TIPOS_TARJETA[$this->webpay_card_type] ?? $this->webpay_card_type ?? 'No especificado';
    }

    /**
     * Obtiene información de las cuotas formateada
     */
    public function getInfoCuotasAttribute(): string
    {
        if (!$this->esEnCuotas()) {
            return 'Pago al contado';
        }
        
        $montoCuota = $this->webpay_installments_amount ?? ($this->monto / $this->webpay_installments_number);
        
        return sprintf(
            '%d cuotas de $%s',
            $this->webpay_installments_number,
            number_format($montoCuota, 0, ',', '.')
        );
    }

    /**
     * Obtiene el token corto para mostrar
     */
    public function getTokenCortoAttribute(): string
    {
        if (!$this->webpay_token) {
            return 'No disponible';
        }
        
        return substr($this->webpay_token, 0, 8) . '...' . substr($this->webpay_token, -8);
    }

    /**
     * Cambia el estado del pago y registra en el historial
     */
    public function cambiarEstado(string $nuevoEstado, string $motivo = null, int $usuarioCambio = null, array $datosAdicionales = []): bool
    {
        $estadoAnterior = $this->estado;
        
        $this->estado = $nuevoEstado;
        
        if (in_array($nuevoEstado, [self::ESTADO_AUTORIZADO, self::ESTADO_COMPLETADO]) && !$this->fecha_pago) {
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
                'datos_adicionales' => $datosAdicionales,
            ]);
        }
        
        return $guardado;
    }

    /**
     * Procesa la respuesta de WebPay y actualiza el pago
     */
    public function procesarRespuestaWebpay(array $respuesta): bool
    {
        $this->webpay_response = $respuesta;
        
        // Extraer información relevante de la respuesta
        if (isset($respuesta['authorization_code'])) {
            $this->webpay_authorization_code = $respuesta['authorization_code'];
        }
        
        if (isset($respuesta['transaction_date'])) {
            $this->webpay_transaction_date = $respuesta['transaction_date'];
        }
        
        if (isset($respuesta['card_detail'])) {
            $cardDetail = $respuesta['card_detail'];
            $this->webpay_card_type = $cardDetail['card_type'] ?? null;
            $this->webpay_card_number = $cardDetail['card_number'] ?? null;
        }
        
        if (isset($respuesta['installments_number'])) {
            $this->webpay_installments_number = $respuesta['installments_number'];
        }
        
        if (isset($respuesta['installments_amount'])) {
            $this->webpay_installments_amount = $respuesta['installments_amount'];
        }
        
        // Determinar el estado basado en la respuesta
        $nuevoEstado = self::ESTADO_PENDIENTE;
        if (isset($respuesta['status'])) {
            switch ($respuesta['status']) {
                case 'AUTHORIZED':
                    $nuevoEstado = self::ESTADO_AUTORIZADO;
                    break;
                case 'COMPLETED':
                    $nuevoEstado = self::ESTADO_COMPLETADO;
                    break;
                case 'FAILED':
                case 'REJECTED':
                    $nuevoEstado = self::ESTADO_RECHAZADO;
                    break;
                case 'NULLIFIED':
                    $nuevoEstado = self::ESTADO_ANULADO;
                    break;
            }
        }
        
        return $this->cambiarEstado(
            $nuevoEstado,
            'Estado actualizado desde respuesta de WebPay',
            null,
            ['respuesta_webpay' => $respuesta]
        );
    }

    /**
     * Genera un número de orden único
     */
    public static function generarBuyOrder(): string
    {
        return 'WP' . time() . rand(1000, 9999);
    }

    /**
     * Obtiene todos los estados disponibles
     */
    public static function getEstadosDisponibles(): array
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_AUTORIZADO => 'Autorizado',
            self::ESTADO_COMPLETADO => 'Completado',
            self::ESTADO_ANULADO => 'Anulado',
            self::ESTADO_RECHAZADO => 'Rechazado',
            self::ESTADO_REEMBOLSADO => 'Reembolsado',
        ];
    }

    /**
     * Obtiene todos los tipos de tarjeta disponibles
     */
    public static function getTiposTarjetaDisponibles(): array
    {
        return self::TIPOS_TARJETA;
    }

    /**
     * Valida si un monto es válido para WebPay (mínimo $10 MXN)
     */
    public static function validarMonto(float $monto): bool
    {
        return $monto >= 10;
    }

    /**
     * Obtiene las opciones de cuotas disponibles según el monto
     */
    public static function getCuotasDisponibles(float $monto): array
    {
        $cuotas = [1 => 'Al contado'];
        
        // Solo permitir cuotas para montos mayores a $1,500 MXN
        if ($monto >= 1500) {
            $cuotas[3] = '3 cuotas';
            $cuotas[6] = '6 cuotas';
            $cuotas[9] = '9 cuotas';
            $cuotas[12] = '12 cuotas';
            
            // Para montos mayores, más opciones
            if ($monto >= 5000) {
                $cuotas[18] = '18 cuotas';
                $cuotas[24] = '24 cuotas';
            }
        }
        
        return $cuotas;
    }
}