<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ConfiguracionPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion_pagos';

    protected $fillable = [
        'metodo_pago',
        'activo',
        'configuracion',
        'comision_porcentaje',
        'comision_fija',
        'orden_visualizacion',
        'descripcion',
        'icono',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array',
        'comision_porcentaje' => 'decimal:2',
        'comision_fija' => 'decimal:2',
        'orden_visualizacion' => 'integer',
    ];

    /**
     * Métodos de pago disponibles
     */
    const METODO_PAYPAL = 'paypal';
    const METODO_TRANSFERENCIA = 'transferencia';
    const METODO_WEBPAY = 'webpay';

    /**
     * Configuraciones por defecto para cada método
     */
    const CONFIGURACIONES_DEFAULT = [
        self::METODO_PAYPAL => [
            'client_id' => '',
            'client_secret' => '',
            'sandbox' => true,
            'moneda_default' => 'USD',
            'webhook_url' => '',
        ],
        self::METODO_TRANSFERENCIA => [
            'banco_destino' => 'bbva_bancomer',
            'numero_cuenta' => '',
            'tipo_cuenta' => 'corriente',
            'rfc_titular' => '',
            'nombre_titular' => '',
            'email_notificacion' => '',
            'verificacion_automatica' => false,
            'tiempo_expiracion_horas' => 72,
        ],
        self::METODO_WEBPAY => [
            'commerce_code' => '',
            'api_key' => '',
            'environment' => 'integration',
            'return_url' => '',
            'final_url' => '',
            'timeout_minutes' => 10,
        ],
    ];

    /**
     * Scope para métodos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para ordenar por visualización
     */
    public function scopeOrdenadosPorVisualizacion($query)
    {
        return $query->orderBy('orden_visualizacion', 'asc');
    }

    /**
     * Scope para filtrar por método
     */
    public function scopePorMetodo($query, $metodo)
    {
        return $query->where('metodo_pago', $metodo);
    }

    /**
     * Obtiene la configuración de un método específico
     */
    public static function obtenerConfiguracion(string $metodo): ?self
    {
        return self::porMetodo($metodo)->first();
    }

    /**
     * Obtiene todos los métodos activos ordenados
     */
    public static function obtenerMetodosActivos(): \Illuminate\Database\Eloquent\Collection
    {
        return self::activos()->ordenadosPorVisualizacion()->get();
    }

    /**
     * Verifica si un método está activo
     */
    public static function metodoEstaActivo(string $metodo): bool
    {
        $config = self::obtenerConfiguracion($metodo);
        return $config && $config->activo;
    }

    /**
     * Calcula la comisión total para un monto
     */
    public function calcularComision(float $monto): float
    {
        $comisionPorcentaje = ($monto * $this->comision_porcentaje) / 100;
        return $comisionPorcentaje + $this->comision_fija;
    }

    /**
     * Calcula el monto total incluyendo comisión
     */
    public function calcularMontoTotal(float $monto): float
    {
        return $monto + $this->calcularComision($monto);
    }

    /**
     * Obtiene el nombre legible del método de pago
     */
    public function getNombreMetodoAttribute(): string
    {
        $nombres = [
            self::METODO_PAYPAL => 'PayPal',
            self::METODO_TRANSFERENCIA => 'Transferencia Bancaria',
            self::METODO_WEBPAY => 'WebPay Plus',
        ];
        
        return $nombres[$this->metodo_pago] ?? ucfirst($this->metodo_pago);
    }

    /**
     * Obtiene la URL del icono
     */
    public function getUrlIconoAttribute(): ?string
    {
        if (!$this->icono) {
            return null;
        }
        
        // Si es una URL completa, devolverla tal como está
        if (filter_var($this->icono, FILTER_VALIDATE_URL)) {
            return $this->icono;
        }
        
        // Si es un archivo local, generar la URL
        return Storage::url($this->icono);
    }

    /**
     * Obtiene un valor específico de la configuración
     */
    public function getConfigValue(string $key, $default = null)
    {
        return $this->configuracion[$key] ?? $default;
    }

    /**
     * Establece un valor específico en la configuración
     */
    public function setConfigValue(string $key, $value): void
    {
        $config = $this->configuracion ?? [];
        $config[$key] = $value;
        $this->configuracion = $config;
    }

    /**
     * Valida la configuración del método
     */
    public function validarConfiguracion(): array
    {
        $errores = [];
        $config = $this->configuracion ?? [];
        
        switch ($this->metodo_pago) {
            case self::METODO_PAYPAL:
                if (empty($config['client_id'])) {
                    $errores[] = 'Client ID de PayPal es requerido';
                }
                if (empty($config['client_secret'])) {
                    $errores[] = 'Client Secret de PayPal es requerido';
                }
                break;
                
            case self::METODO_TRANSFERENCIA:
                if (empty($config['numero_cuenta'])) {
                    $errores[] = 'Número de cuenta es requerido';
                }
                if (empty($config['rfc_titular'])) {
                    $errores[] = 'RFC del titular es requerido';
                }
                if (empty($config['nombre_titular'])) {
                    $errores[] = 'Nombre del titular es requerido';
                }
                break;
                
            case self::METODO_WEBPAY:
                if (empty($config['commerce_code'])) {
                    $errores[] = 'Código de comercio de WebPay es requerido';
                }
                if (empty($config['api_key'])) {
                    $errores[] = 'API Key de WebPay es requerida';
                }
                if (empty($config['return_url'])) {
                    $errores[] = 'URL de retorno es requerida';
                }
                break;
        }
        
        return $errores;
    }

    /**
     * Verifica si la configuración es válida
     */
    public function configuracionEsValida(): bool
    {
        return empty($this->validarConfiguracion());
    }

    /**
     * Inicializa la configuración por defecto
     */
    public function inicializarConfiguracionDefault(): void
    {
        $this->configuracion = self::CONFIGURACIONES_DEFAULT[$this->metodo_pago] ?? [];
    }

    /**
     * Obtiene todos los métodos de pago disponibles
     */
    public static function getMetodosDisponibles(): array
    {
        return [
            self::METODO_PAYPAL => 'PayPal',
            self::METODO_TRANSFERENCIA => 'Transferencia Bancaria',
            self::METODO_WEBPAY => 'WebPay Plus',
        ];
    }

    /**
     * Crea o actualiza la configuración de un método
     */
    public static function configurarMetodo(string $metodo, array $datos): self
    {
        $config = self::firstOrNew(['metodo_pago' => $metodo]);
        
        $config->fill($datos);
        
        // Si es nuevo, inicializar configuración por defecto
        if (!$config->exists) {
            $config->inicializarConfiguracionDefault();
        }
        
        $config->save();
        
        return $config;
    }

    /**
     * Obtiene estadísticas de uso de métodos de pago
     */
    public static function getEstadisticasUso(array $filtros = []): array
    {
        $estadisticas = [];
        
        // Contar pagos por método
        $estadisticas['paypal'] = PagoPaypal::count();
        $estadisticas['transferencia'] = PagoTransferencia::count();
        $estadisticas['webpay'] = PagoWebpay::count();
        
        // Calcular totales por método
        $estadisticas['totales'] = [
            'paypal' => PagoPaypal::completados()->sum('monto'),
            'transferencia' => PagoTransferencia::completados()->sum('monto'),
            'webpay' => PagoWebpay::completados()->sum('monto'),
        ];
        
        // Calcular comisiones generadas
        $configuraciones = self::all()->keyBy('metodo_pago');
        $estadisticas['comisiones'] = [];
        
        foreach ($configuraciones as $metodo => $config) {
            $total = $estadisticas['totales'][$metodo] ?? 0;
            $estadisticas['comisiones'][$metodo] = $config->calcularComision($total);
        }
        
        return $estadisticas;
    }
}