<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionTaller extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_talleres';

    protected $fillable = [
        'usuario_id',
        'taller_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'taller_id');
    }
}