<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ponencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ponencias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria_id',

        'ponente_id',
        'fecha',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    protected $casts = [
        'estado' => 'string',
        'fecha' => 'date'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }



    public function ponente()
    {
        return $this->belongsTo(Ponente::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(InscripcionPonencia::class);
    }
}