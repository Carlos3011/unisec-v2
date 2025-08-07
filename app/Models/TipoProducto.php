<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoProducto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_base',
        'activo'
    ];

    protected $casts = [
        'precio_base' => 'decimal:2',
        'activo' => 'boolean'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relación con pagos unificados
     */
    public function pagosUnificados(): HasMany
    {
        return $this->hasMany(PagoUnificado::class, 'tipo_producto_id');
    }

    /**
     * Scope para tipos de productos activos
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
     * Obtener precio formateado
     */
    public function getPrecioFormateadoAttribute(): string
    {
        return number_format($this->precio_base, 0, ',', '.') . ' CLP';
    }

    /**
     * Verificar si es un tipo de concurso
     */
    public function esConcurso(): bool
    {
        return str_contains($this->nombre, 'concurso');
    }

    /**
     * Verificar si es un tipo de congreso
     */
    public function esCongreso(): bool
    {
        return str_contains($this->nombre, 'congreso');
    }

    /**
     * Verificar si es un tipo de curso
     */
    public function esCurso(): bool
    {
        return str_contains($this->nombre, 'curso');
    }

    /**
     * Obtener tipos de productos por categoría
     */
    public static function porCategoria($categoria)
    {
        return static::activos()->where('nombre', 'like', $categoria . '%')->get();
    }
}