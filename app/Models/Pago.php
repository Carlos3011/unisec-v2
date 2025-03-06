<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pago extends Model
{
    use SoftDeletes;

    protected $table = 'pagos';
    
    protected $fillable = [
        'usuario_id',
        'curso_id',
        'monto',
        'metodo_pago',
        'estado',
        'fecha'
    ];

    protected $dates = ['deleted_at', 'fecha'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function factura(): HasOne
    {
        return $this->hasOne(Factura::class, 'pago_id');
    }
}