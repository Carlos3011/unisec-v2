<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class PagoUnificado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_unificados';

    protected $fillable = [
        'usuario_id',
        'tipo_producto_id',
        'metodo_pago_id',
        'inscripcion_type',
        'inscripcion_id',
        'monto',
        'moneda',
        'referencia_externa',
        'referencia_interna',
        'estado',
        'datos_pago',
        'fecha_pago',
        'fecha_vencimiento',
        'fecha_confirmacion',
        'notas',
        'ip_origen',
        'user_agent'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'datos_pago' => 'array',
        'fecha_pago' => 'datetime',
        'fecha_vencimiento' => 'datetime',
        'fecha_confirmacion' => 'datetime'
    ];

    protected $dates = [
        'deleted_at',
        'fecha_pago',
        'fecha_vencimiento',
        'fecha_confirmacion'
    ];

    /**
     * Boot del modelo para generar referencia interna automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pago) {
            if (empty($pago->referencia_interna)) {
                $pago->referencia_interna = 'PAY-' . strtoupper(Str::random(10)) . '-' . time();
            }
        });
    }

    /**
     * Relación con el usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el tipo de producto
     */
    public function tipoProducto(): BelongsTo
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id');
    }

    /**
     * Relación con el método de pago
     */
    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

    /**
     * Relación polimórfica con la inscripción
     */
    public function inscripcion(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relación con detalles de PayPal
     */
    public function pagoPaypal(): HasOne
    {
        return $this->hasOne(PagoPaypal::class, 'pago_unificado_id');
    }

    /**
     * Relación con detalles de transferencia
     */
    public function pagoTransferencia(): HasOne
    {
        return $this->hasOne(PagoTransferencia::class, 'pago_unificado_id');
    }

    /**
     * Relación con detalles de WebPay
     */
    public function pagoWebpay(): HasOne
    {
        return $this->hasOne(PagoWebpay::class, 'pago_unificado_id');
    }

    /**
     * Relación con historial de estados
     */
    public function historialEstados(): HasMany
    {
        return $this->hasMany(HistorialEstadoPago::class, 'pago_unificado_id');
    }

    /**
     * Scopes para filtrar por estado
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeFallidos($query)
    {
        return $query->where('estado', 'fallido');
    }

    /**
     * Scope para filtrar por método de pago
     */
    public function scopePorMetodo($query, $metodo)
    {
        return $query->whereHas('metodoPago', function ($q) use ($metodo) {
            $q->where('nombre', $metodo);
        });
    }

    /**
     * Scope para filtrar por tipo de producto
     */
    public function scopePorTipoProducto($query, $tipo)
    {
        return $query->whereHas('tipoProducto', function ($q) use ($tipo) {
            $q->where('nombre', $tipo);
        });
    }

    /**
     * Método para cambiar estado del pago
     */
    public function cambiarEstado($nuevoEstado, $motivo = null, $usuarioCambio = null)
    {
        $estadoAnterior = $this->estado;
        
        $this->update(['estado' => $nuevoEstado]);
        
        // Registrar en historial
        $this->historialEstados()->create([
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $nuevoEstado,
            'motivo' => $motivo,
            'usuario_cambio_id' => $usuarioCambio
        ]);
        
        return $this;
    }

    /**
     * Verificar si el pago está completado
     */
    public function estaCompletado(): bool
    {
        return $this->estado === 'completado';
    }

    /**
     * Verificar si el pago está pendiente
     */
    public function estaPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    /**
     * Verificar si el pago ha fallado
     */
    public function haFallado(): bool
    {
        return $this->estado === 'fallido';
    }

    /**
     * Obtener el nombre del método de pago
     */
    public function getNombreMetodoPagoAttribute(): string
    {
        return $this->metodoPago->nombre ?? 'No definido';
    }

    /**
     * Obtener el nombre del tipo de producto
     */
    public function getNombreTipoProductoAttribute(): string
    {
        return $this->tipoProducto->nombre ?? 'No definido';
    }

    /**
     * Formatear el monto con moneda
     */
    public function getMontoFormateadoAttribute(): string
    {
        return number_format($this->monto, 0, ',', '.') . ' ' . $this->moneda;
    }
}