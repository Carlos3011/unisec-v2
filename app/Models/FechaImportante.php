<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FechaImportante extends Model
{
    use HasFactory;

    protected $table = 'fechas_importantes';

    protected $fillable = [
        'convocatoria_id',
        'titulo',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    /**
     * Get the convocatoria that owns this fecha importante.
     */
    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::class);
    }
}