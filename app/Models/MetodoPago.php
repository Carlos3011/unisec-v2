<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodoPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'metodos_pago';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'configuracion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relación con pagos unificados
     */
    public function pagosUnificados(): HasMany
    {
        return $this->hasMany(PagoUnificado::class, 'metodo_pago_id');
    }

    /**
     * Scope para métodos de pago activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para filtrar por nombre
     */
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', $nombre);
    }

    /**
     * Verificar si es PayPal
     */
    public function esPaypal(): bool
    {
        return $this->nombre === 'paypal';
    }

    /**
     * Verificar si es transferencia
     */
    public function esTransferencia(): bool
    {
        return $this->nombre === 'transferencia';
    }

    /**
     * Verificar si es WebPay
     */
    public function esWebpay(): bool
    {
        return $this->nombre === 'webpay';
    }

    /**
     * Obtener configuración específica
     */
    public function getConfiguracion($clave, $default = null)
    {
        return $this->configuracion[$clave] ?? $default;
    }

    /**
     * Establecer configuración específica
     */
    public function setConfiguracion($clave, $valor)
    {
        $configuracion = $this->configuracion ?? [];
        $configuracion[$clave] = $valor;
        $this->configuracion = $configuracion;
        return $this;
    }

    /**
     * Obtener métodos de pago disponibles para un tipo de producto
     */
    public static function disponiblesParaTipo($tipoProducto)
    {
        // Por defecto, todos los métodos activos están disponibles
        // Se puede personalizar según reglas de negocio
        return static::activos()->get();
    }

    /**
     * Obtener icono del método de pago
     */
    public function getIconoAttribute(): string
    {
        $iconos = [
            'paypal' => 'fab fa-paypal',
            'transferencia' => 'fas fa-university',
            'webpay' => 'fas fa-credit-card'
        ];

        return $iconos[$this->nombre] ?? 'fas fa-money-bill';
    }

    /**
     * Obtener color del método de pago
     */
    public function getColorAttribute(): string
    {
        $colores = [
            'paypal' => '#0070ba',
            'transferencia' => '#28a745',
            'webpay' => '#dc3545'
        ];

        return $colores[$this->nombre] ?? '#6c757d';
    }
}