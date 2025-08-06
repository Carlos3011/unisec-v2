<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class PagoTransferencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_transferencia';

    protected $fillable = [
        'usuario_id',
        'pagable_type',
        'pagable_id',
        'monto',
        'moneda',
        'numero_transferencia',
        'banco_origen',
        'banco_destino',
        'cuenta_origen',
        'cuenta_destino',
        'rut_titular_origen',
        'nombre_titular_origen',
        'rut_titular_destino',
        'nombre_titular_destino',
        'estado',
        'fecha_transferencia',
        'fecha_verificacion',
        'comprobante_archivo',
        'observaciones',
        'motivo_rechazo',
        'verificado_por',
        'numero_factura',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_transferencia' => 'datetime',
        'fecha_verificacion' => 'datetime',
    ];

    protected $dates = [
        'fecha_transferencia',
        'fecha_verificacion',
        'deleted_at',
    ];

    /**
     * Estados disponibles para el pago
     */
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_VERIFICANDO = 'verificando';
    const ESTADO_COMPLETADO = 'completado';
    const ESTADO_RECHAZADO = 'rechazado';
    const ESTADO_REEMBOLSADO = 'reembolsado';

    /**
     * Bancos disponibles en México
     */
    const BANCOS_MEXICO = [
        'bbva_bancomer' => 'BBVA México',
        'santander' => 'Banco Santander México',
        'banamex' => 'Citibanamex',
        'banorte' => 'Banorte',
        'hsbc' => 'HSBC México',
        'scotiabank' => 'Scotiabank México',
        'inbursa' => 'Banco Inbursa',
        'azteca' => 'Banco Azteca',
        'bancoppel' => 'BanCoppel',
        'banco_del_bajio' => 'Banco del Bajío',
        'afirme' => 'Banco Afirme',
        'banregio' => 'Banregio',
        'banbajio' => 'BanBajío',
        'banco_azteca' => 'Banco Azteca',
        'otro' => 'Otro',
    ];
    
    // Alias para compatibilidad con código existente
    const BANCOS_CHILE = self::BANCOS_MEXICO;

    /**
     * Relación con el usuario que realizó el pago
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el usuario que verificó el pago
     */
    public function verificador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verificado_por');
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
     * Scope para pagos en verificación
     */
    public function scopeVerificando($query)
    {
        return $query->where('estado', self::ESTADO_VERIFICANDO);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_transferencia', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope para pagos que requieren verificación
     */
    public function scopeRequierenVerificacion($query)
    {
        return $query->whereIn('estado', [self::ESTADO_PENDIENTE, self::ESTADO_VERIFICANDO]);
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
     * Verifica si el pago está en verificación
     */
    public function estaVerificando(): bool
    {
        return $this->estado === self::ESTADO_VERIFICANDO;
    }

    /**
     * Verifica si el pago fue rechazado
     */
    public function fueRechazado(): bool
    {
        return $this->estado === self::ESTADO_RECHAZADO;
    }

    /**
     * Obtiene el monto formateado con la moneda
     */
    public function getMontoFormateadoAttribute(): string
    {
        return number_format($this->monto, 0, ',', '.') . ' ' . $this->moneda;
    }

    /**
     * Obtiene la cuenta origen enmascarada
     */
    public function getCuentaOrigenEnmascaradaAttribute(): string
    {
        if (!$this->cuenta_origen) {
            return 'No especificada';
        }
        
        $longitud = strlen($this->cuenta_origen);
        if ($longitud <= 4) {
            return $this->cuenta_origen;
        }
        
        return str_repeat('*', $longitud - 4) . substr($this->cuenta_origen, -4);
    }

    /**
     * Obtiene el nombre del banco origen
     */
    public function getNombreBancoOrigenAttribute(): string
    {
        return self::BANCOS_MEXICO[$this->banco_origen] ?? $this->banco_origen;
    }

    /**
     * Obtiene el nombre del banco destino
     */
    public function getNombreBancoDestinoAttribute(): string
    {
        return self::BANCOS_MEXICO[$this->banco_destino] ?? $this->banco_destino;
    }

    /**
     * Obtiene la URL del comprobante
     */
    public function getUrlComprobanteAttribute(): ?string
    {
        if (!$this->comprobante_archivo) {
            return null;
        }
        
        return Storage::url($this->comprobante_archivo);
    }

    /**
     * Verifica si tiene comprobante
     */
    public function tieneComprobante(): bool
    {
        return !empty($this->comprobante_archivo) && Storage::exists($this->comprobante_archivo);
    }

    /**
     * Cambia el estado del pago y registra en el historial
     */
    public function cambiarEstado(string $nuevoEstado, string $motivo = null, int $usuarioCambio = null): bool
    {
        $estadoAnterior = $this->estado;
        
        $this->estado = $nuevoEstado;
        
        if ($nuevoEstado === self::ESTADO_COMPLETADO && !$this->fecha_verificacion) {
            $this->fecha_verificacion = now();
            $this->verificado_por = $usuarioCambio;
        }
        
        if ($nuevoEstado === self::ESTADO_RECHAZADO && $motivo) {
            $this->motivo_rechazo = $motivo;
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
     * Aprobar el pago
     */
    public function aprobar(int $usuarioVerificador, string $observaciones = null): bool
    {
        return $this->cambiarEstado(
            self::ESTADO_COMPLETADO,
            $observaciones ?? 'Pago aprobado tras verificación',
            $usuarioVerificador
        );
    }

    /**
     * Rechazar el pago
     */
    public function rechazar(string $motivo, int $usuarioVerificador): bool
    {
        return $this->cambiarEstado(
            self::ESTADO_RECHAZADO,
            $motivo,
            $usuarioVerificador
        );
    }

    /**
     * Obtiene todos los estados disponibles
     */
    public static function getEstadosDisponibles(): array
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_VERIFICANDO => 'En Verificación',
            self::ESTADO_COMPLETADO => 'Completado',
            self::ESTADO_RECHAZADO => 'Rechazado',
            self::ESTADO_REEMBOLSADO => 'Reembolsado',
        ];
    }

    public static function getBancosDisponibles(): array
    {
        return self::BANCOS_MEXICO;
    }

    /**
     * Valida si un RFC mexicano tiene el formato correcto
     * 
     * Formato para personas físicas: AAAA######XXX
     * Formato para personas morales: AAA######XXX
     * Donde:
     * - A: Letras del nombre o razón social
     * - #: Fecha de nacimiento o constitución (AAMMDD)
     * - X: Homoclave
     */
    public static function validarRFC(string $rfc): bool
    {
        // Eliminar espacios y guiones
        $rfc = str_replace([' ', '-'], '', $rfc);
        
        // Convertir a mayúsculas
        $rfc = strtoupper($rfc);
        
        // Validar longitud (13 para personas físicas, 12 para personas morales)
        if (strlen($rfc) != 13 && strlen($rfc) != 12) {
            return false;
        }
        
        // Validar formato usando expresión regular
        // Personas físicas: 4 letras + 6 dígitos + 3 alfanuméricos
        // Personas morales: 3 letras + 6 dígitos + 3 alfanuméricos
        $patron = '/^[A-Z]{3,4}[0-9]{6}[A-Z0-9]{3}$/i';
        
        return preg_match($patron, $rfc) === 1;
    }
    
    /**
     * Valida si un CURP mexicano tiene el formato correcto
     */
    public static function validarCURP(string $curp): bool
    {
        // Eliminar espacios y guiones
        $curp = str_replace([' ', '-'], '', $curp);
        
        // Convertir a mayúsculas
        $curp = strtoupper($curp);
        
        // Validar longitud (18 caracteres)
        if (strlen($curp) != 18) {
            return false;
        }
        
        // Validar formato usando expresión regular
        $patron = '/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A-Z]{2}$/i';
        
        return preg_match($patron, $curp) === 1;
    }
    
    /**
     * Método de compatibilidad para código existente
     * @deprecated Usar validarRFC en su lugar
     */
    public static function validarRut(string $rut): bool
    {
        // Intentar validar como RFC si parece un RFC mexicano
        if (strlen($rut) >= 12) {
            return self::validarRFC($rut);
        }
        
        // Fallback para compatibilidad
        return false;
    }
}