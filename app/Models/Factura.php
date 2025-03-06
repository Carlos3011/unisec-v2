<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    use SoftDeletes;

    protected $table = 'facturas';
    
    protected $fillable = [
        'usuario_id',
        'pago_id',
        'total',
        'estado',
        'fecha_emision'
    ];

    protected $dates = ['deleted_at', 'fecha_emision'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}