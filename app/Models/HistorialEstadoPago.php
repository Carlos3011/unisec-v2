<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class HistorialEstadoPago extends Model
{
    use HasFactory;

    protected $table = 'historial_estados_pagos';

    protected $fillable = [
        'pago_type',
        'pago_id',
        'estado_anterior',
        'estado_nuevo',
        'motivo',
        'usuario_cambio',
        'datos_adicionales',
    ];

    protected $casts = [
        'datos_adicionales' => 'array',
    ];

    /**
     * Relación polimórfica con el pago
     */
    public function pago(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relación con el usuario que realizó el cambio
     */
    public function usuarioCambio(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_cambio');
    }

    /**
     * Scope para filtrar por tipo de pago
     */
    public function scopePorTipoPago($query, $tipo)
    {
        return $query->where('pago_type', $tipo);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado_nuevo', $estado);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope para obtener cambios recientes
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    /**
     * Obtiene el nombre del usuario que realizó el cambio
     */
    public function getNombreUsuarioCambioAttribute(): string
    {
        if (!$this->usuario_cambio) {
            return 'Sistema';
        }
        
        return $this->usuarioCambio->name ?? 'Usuario desconocido';
    }

    /**
     * Obtiene una descripción legible del cambio
     */
    public function getDescripcionCambioAttribute(): string
    {
        $descripcion = "Estado cambiado";
        
        if ($this->estado_anterior) {
            $descripcion .= " de '{$this->estado_anterior}'";
        }
        
        $descripcion .= " a '{$this->estado_nuevo}'";
        
        if ($this->motivo) {
            $descripcion .= ". Motivo: {$this->motivo}";
        }
        
        return $descripcion;
    }

    /**
     * Verifica si el cambio fue realizado por el sistema
     */
    public function esCambioDelSistema(): bool
    {
        return is_null($this->usuario_cambio);
    }

    /**
     * Obtiene estadísticas de cambios de estado
     */
    public static function getEstadisticasCambios(array $filtros = []): array
    {
        $query = self::query();
        
        if (isset($filtros['fecha_inicio']) && isset($filtros['fecha_fin'])) {
            $query->entreFechas($filtros['fecha_inicio'], $filtros['fecha_fin']);
        }
        
        if (isset($filtros['tipo_pago'])) {
            $query->porTipoPago($filtros['tipo_pago']);
        }
        
        $cambios = $query->get();
        
        return [
            'total_cambios' => $cambios->count(),
            'cambios_por_estado' => $cambios->groupBy('estado_nuevo')->map->count(),
            'cambios_por_usuario' => $cambios->groupBy('usuario_cambio')->map->count(),
            'cambios_del_sistema' => $cambios->whereNull('usuario_cambio')->count(),
            'cambios_manuales' => $cambios->whereNotNull('usuario_cambio')->count(),
        ];
    }
}