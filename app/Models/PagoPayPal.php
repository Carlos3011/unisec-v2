<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PagoPaypal extends Model
{
    use HasFactory;

    protected $table = 'pagos_paypal';

    protected $fillable = [
        'pago_unificado_id',
        'paypal_order_id',
        'paypal_payment_id',
        'paypal_payer_id',
        'paypal_status',
        'paypal_response'
    ];

    protected $casts = [
        'paypal_response' => 'array'
    ];

    /**
     * Relación con el pago unificado
     */
    public function pagoUnificado(): BelongsTo
    {
        return $this->belongsTo(PagoUnificado::class, 'pago_unificado_id');
    }

    /**
     * Verificar si el pago está aprobado en PayPal
     */
    public function estaAprobado(): bool
    {
        return $this->paypal_status === 'APPROVED';
    }

    /**
     * Verificar si el pago está completado en PayPal
     */
    public function estaCompletado(): bool
    {
        return $this->paypal_status === 'COMPLETED';
    }

    /**
     * Obtener información del pagador desde la respuesta de PayPal
     */
    public function getInfoPagador()
    {
        return $this->paypal_response['payer'] ?? null;
    }

    /**
     * Obtener detalles de la transacción desde la respuesta de PayPal
     */
    public function getDetallesTransaccion()
    {
        return $this->paypal_response['purchase_units'][0] ?? null;
    }

    /**
     * Obtener el monto desde la respuesta de PayPal
     */
    public function getMontoPaypal()
    {
        $detalles = $this->getDetallesTransaccion();
        return $detalles['amount']['value'] ?? null;
    }

    /**
     * Obtener la moneda desde la respuesta de PayPal
     */
    public function getMonedaPaypal()
    {
        $detalles = $this->getDetallesTransaccion();
        return $detalles['amount']['currency_code'] ?? null;
    }
}