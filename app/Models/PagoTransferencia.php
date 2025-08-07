<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PagoTransferencia extends Model
{
    use HasFactory;

    protected $table = 'pagos_transferencia';

    protected $fillable = [
        'pago_unificado_id',
        'numero_transferencia',
        'banco_origen',
        'banco_destino',
        'cuenta_origen',
        'cuenta_destino',
        'rut_transferente',
        'nombre_transferente',
        'comprobante_archivo',
        'estado_verificacion',
        'observaciones',
        'fecha_transferencia'
    ];

    protected $casts = [
        'fecha_transferencia' => 'datetime'
    ];

    protected $dates = [
        'fecha_transferencia'
    ];

    /**
     * Relación con el pago unificado
     */
    public function pagoUnificado(): BelongsTo
    {
        return $this->belongsTo(PagoUnificado::class, 'pago_unificado_id');
    }

    /**
     * Scope para transferencias pendientes de verificación
     */
    public function scopePendientesVerificacion($query)
    {
        return $query->where('estado_verificacion', 'pendiente');
    }

    /**
     * Scope para transferencias verificadas
     */
    public function scopeVerificadas($query)
    {
        return $query->where('estado_verificacion', 'verificado');
    }

    /**
     * Scope para transferencias rechazadas
     */
    public function scopeRechazadas($query)
    {
        return $query->where('estado_verificacion', 'rechazado');
    }

    /**
     * Verificar si la transferencia está verificada
     */
    public function estaVerificada(): bool
    {
        return $this->estado_verificacion === 'verificado';
    }

    /**
     * Verificar si la transferencia está pendiente
     */
    public function estaPendiente(): bool
    {
        return $this->estado_verificacion === 'pendiente';
    }

    /**
     * Verificar si la transferencia fue rechazada
     */
    public function fueRechazada(): bool
    {
        return $this->estado_verificacion === 'rechazado';
    }

    /**
     * Verificar si tiene comprobante
     */
    public function tieneComprobante(): bool
    {
        return !empty($this->comprobante_archivo) && Storage::exists($this->comprobante_archivo);
    }

    /**
     * Obtener URL del comprobante
     */
    public function getUrlComprobanteAttribute(): ?string
    {
        if ($this->tieneComprobante()) {
            return Storage::url($this->comprobante_archivo);
        }
        return null;
    }

    /**
     * Marcar como verificada
     */
    public function marcarComoVerificada($observaciones = null)
    {
        $this->update([
            'estado_verificacion' => 'verificado',
            'observaciones' => $observaciones
        ]);

        // Actualizar el estado del pago unificado
        $this->pagoUnificado->cambiarEstado('completado', 'Transferencia verificada');

        return $this;
    }

    /**
     * Marcar como rechazada
     */
    public function marcarComoRechazada($observaciones)
    {
        $this->update([
            'estado_verificacion' => 'rechazado',
            'observaciones' => $observaciones
        ]);

        // Actualizar el estado del pago unificado
        $this->pagoUnificado->cambiarEstado('fallido', 'Transferencia rechazada: ' . $observaciones);

        return $this;
    }

    /**
     * Formatear RUT
     */
    public function getRutFormateadoAttribute(): string
    {
        if (empty($this->rut_transferente)) {
            return 'No especificado';
        }

        $rut = preg_replace('/[^0-9kK]/', '', $this->rut_transferente);
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, -1);
        
        return number_format($numero, 0, '', '.') . '-' . $dv;
    }

    /**
     * Obtener información completa de la transferencia
     */
    public function getResumenTransferenciaAttribute(): array
    {
        return [
            'numero' => $this->numero_transferencia,
            'banco_origen' => $this->banco_origen,
            'banco_destino' => $this->banco_destino,
            'transferente' => $this->nombre_transferente,
            'rut' => $this->rut_formateado,
            'fecha' => $this->fecha_transferencia?->format('d/m/Y H:i'),
            'estado' => $this->estado_verificacion,
            'tiene_comprobante' => $this->tieneComprobante()
        ];
    }
}