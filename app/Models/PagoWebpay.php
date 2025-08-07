<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PagoWebpay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_webpay';

    protected $fillable = [
        'usuario_id',
        'curso_id',
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

    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_AUTORIZADO = 'autorizado';
    const ESTADO_COMPLETADO = 'completado';
    const ESTADO_ANULADO = 'anulado';
    const ESTADO_RECHAZADO = 'rechazado';
    const ESTADO_REEMBOLSADO = 'reembolsado';

    const TIPOS_TARJETA = [
        'VI' => 'Visa',
        'MC' => 'Mastercard',
        'AX' => 'American Express',
        'DC' => 'Diners Club',
        'DB' => 'Redcompra',
        'VP' => 'Visa Prepago',
        'MP' => 'Mastercard Prepago',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación directa con Curso (ya no es polimórfica)
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function historialEstados(): MorphMany
    {
        return $this->morphMany(HistorialEstadoPago::class, 'pago');
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', self::ESTADO_COMPLETADO);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    public function scopeAutorizados($query)
    {
        return $query->where('estado', self::ESTADO_AUTORIZADO);
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
    }

    public function scopePorTipoTarjeta($query, $tipo)
    {
        return $query->where('webpay_card_type', $tipo);
    }

    public function estaCompletado(): bool
    {
        return $this->estado === self::ESTADO_COMPLETADO;
    }

    public function estaPendiente(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

    public function estaAutorizado(): bool
    {
        return $this->estado === self::ESTADO_AUTORIZADO;
    }

    public function fueRechazado(): bool
    {
        return $this->estado === self::ESTADO_RECHAZADO;
    }

    public function fueAnulado(): bool
    {
        return $this->estado === self::ESTADO_ANULADO;
    }

    public function fueReembolsado(): bool
    {
        return $this->estado === self::ESTADO_REEMBOLSADO;
    }

    public function esEnCuotas(): bool
    {
        return $this->webpay_installments_number > 1;
    }

    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 0, ',', '.') . ' ' . $this->moneda;
    }

    public function getTarjetaEnmascaradaAttribute(): string
    {
        if (!$this->webpay_card_number) {
            return 'No disponible';
        }

        return '****-****-****-' . $this->webpay_card_number;
    }

    public function getNombreTipoTarjetaAttribute(): string
    {
        return self::TIPOS_TARJETA[$this->webpay_card_type] ?? 'No especificado';
    }

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

    public function getTokenCortoAttribute(): string
    {
        if (!$this->webpay_token) {
            return 'No disponible';
        }

        return substr($this->webpay_token, 0, 8) . '...' . substr($this->webpay_token, -8);
    }

    public function cambiarEstado(string $nuevoEstado, string $motivo = null, int $usuarioCambio = null, array $datosAdicionales = []): bool
    {
        $estadoAnterior = $this->estado;

        $this->estado = $nuevoEstado;

        if (in_array($nuevoEstado, [self::ESTADO_AUTORIZADO, self::ESTADO_COMPLETADO]) && !$this->fecha_pago) {
            $this->fecha_pago = now();
        }

        $guardado = $this->save();

        if ($guardado) {
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

    public function procesarRespuestaWebpay(array $respuesta): bool
    {
        $this->webpay_response = $respuesta;

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

    public static function generarBuyOrder(): string
    {
        return 'WP' . time() . rand(1000, 9999);
    }

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

    public static function getTiposTarjetaDisponibles(): array
    {
        return self::TIPOS_TARJETA;
    }

    public static function validarMonto(float $monto): bool
    {
        return $monto >= 10;
    }

    public static function getCuotasDisponibles(float $monto): array
    {
        $cuotas = [1 => 'Al contado'];

        if ($monto >= 1500) {
            $cuotas[3] = '3 cuotas';
            $cuotas[6] = '6 cuotas';
            $cuotas[9] = '9 cuotas';
            $cuotas[12] = '12 cuotas';

            if ($monto >= 5000) {
                $cuotas[18] = '18 cuotas';
                $cuotas[24] = '24 cuotas';
            }
        }

        return $cuotas;
    }
}
