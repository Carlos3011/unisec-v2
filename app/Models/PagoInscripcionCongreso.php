<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagoInscripcionCongreso extends Model
{
    use HasFactory;

    protected $table = 'pagos_inscripcion_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'articulo_id',
        'monto',
        'metodo_pago',
        'referencia_paypal',
        'paypal_order_id',
        'estado_pago',
        'fecha_pago',
        'detalles_transaccion',
        'comprobante_pago'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime',
        'detalles_transaccion' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Estados posibles del pago
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_RECHAZADO = 'rechazado';

    // Relación con el usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el congreso
    public function congreso(): BelongsTo
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    // Relación con el artículo
    public function articulo(): BelongsTo
    {
        return $this->belongsTo(ArticuloCongreso::class, 'articulo_id');
    }

    // Relación con la inscripción
    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(InscripcionCongreso::class, 'usuario_id', 'usuario_id')
            ->where('congreso_id', $this->congreso_id);
    }

    // Métodos de utilidad para verificar estados
    public function estaPagado(): bool
    {
        return $this->estado_pago === self::ESTADO_PAGADO;
    }

    public function estaRechazado(): bool
    {
        return $this->estado_pago === self::ESTADO_RECHAZADO;
    }

    public function estaPendiente(): bool
    {
        return $this->estado_pago === self::ESTADO_PENDIENTE;
    }

    // Métodos para actualizar estados
    public function marcarComoPagado(): bool
    {
        $this->estado_pago = self::ESTADO_PAGADO;
        $this->fecha_pago = now();
        return $this->save();
    }

    public function marcarComoRechazado(): bool
    {
        $this->estado_pago = self::ESTADO_RECHAZADO;
        return $this->save();
    }

    // Método para actualizar información de PayPal
    public function actualizarInfoPayPal(string $orderId, string $referencia): bool
    {
        $this->paypal_order_id = $orderId;
        $this->referencia_paypal = $referencia;
        return $this->save();
    }

    // Método para registrar detalles de la transacción
    public function registrarDetallesTransaccion(array $detalles): bool
    {
        $this->detalles_transaccion = $detalles;
        return $this->save();
    }
}