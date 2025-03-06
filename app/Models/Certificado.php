<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificado extends Model
{
    use SoftDeletes;

    protected $table = 'certificados';
    
    protected $fillable = [
        'usuario_id',
        'curso_id',
        'codigo_validacion',
        'fecha_emision',
        'estado'
    ];

    protected $dates = ['deleted_at', 'fecha_emision'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}