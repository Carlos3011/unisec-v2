<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_concursos';

    protected $fillable = [
        'inscripcion_concurso_id',
        'monto',
        'metodo_pago',
        'referencia',
        'estado_pago',
        'fecha_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2'
    ];

    public function inscripcionConcurso()
    {
        return $this->belongsTo(InscripcionConcurso::class, 'inscripcion_concurso_id');
    }
}