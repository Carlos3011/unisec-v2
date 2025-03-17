<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionCongreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_congresos';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function congreso()
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }
}