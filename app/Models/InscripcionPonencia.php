<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionPonencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_ponencias';

    protected $fillable = [
        'usuario_id',
        'ponencia_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function ponencia()
    {
        return $this->belongsTo(Ponencia::class, 'ponencia_id');
    }
}