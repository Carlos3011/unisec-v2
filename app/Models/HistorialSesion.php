<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialSesion extends Model
{
    use SoftDeletes;

    protected $table = 'historial_sesiones';
    
    protected $fillable = [
        'usuario_id',
        'fecha_hora',
        'ip',
        'dispositivo',
        'estado_sesion'
    ];

    protected $dates = ['deleted_at', 'fecha_hora'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}