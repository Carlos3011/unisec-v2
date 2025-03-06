<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsistenciaEvento extends Model
{
    use SoftDeletes;

    protected $table = 'asistencias_eventos';
    
    protected $fillable = [
        'usuario_id',
        'evento_id',
        'estado_asistencia'
    ];

    protected $dates = ['deleted_at'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(EventoCongreso::class, 'evento_id');
    }
}