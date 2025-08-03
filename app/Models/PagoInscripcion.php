<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoInscripcion extends Model
{
    use HasFactory;

    protected $table = 'pagos_inscripcion';

    protected $fillable = [
        'pre_registro_id',
        'usuario_id',
        'concurso_id',
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
        'detalles_transaccion' => 'json'
    ];

    protected $attributes = [
        'metodo_pago' => 'paypal',
        'estado_pago' => 'pendiente'
    ];

    public function preRegistro()
    {
        return $this->belongsTo(PreRegistroConcurso::class, 'pre_registro_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function concurso()
    {
        return $this->belongsTo(Concurso::class);
    }

    public function inscripcion()
    {
        return $this->hasOne(InscripcionConcurso::class);
    }
}