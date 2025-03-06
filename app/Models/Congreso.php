<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Congreso extends Model
{
    use SoftDeletes;

    protected $table = 'congresos';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $dates = ['deleted_at', 'fecha_inicio', 'fecha_fin'];

    public function eventos(): HasMany
    {
        return $this->hasMany(EventoCongreso::class, 'congreso_id');
    }
}