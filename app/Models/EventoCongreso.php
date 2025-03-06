<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventoCongreso extends Model
{
    use SoftDeletes;

    protected $table = 'eventos_congreso';
    
    protected $fillable = [
        'congreso_id',
        'tipo',
        'titulo',
        'fecha'
    ];

    protected $dates = ['deleted_at', 'fecha'];

    public function congreso(): BelongsTo
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(AsistenciaEvento::class, 'evento_id');
    }
}