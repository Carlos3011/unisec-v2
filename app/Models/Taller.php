<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taller extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'talleres';

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria_id',
    
        'ponente_id',
        'costo',
        'fecha',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    protected $casts = [
        'estado' => 'string',
        'fecha' => 'date',
        'costo' => 'decimal:2',
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
        return $this->hasMany(InscripcionTaller::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'inscripciones')
            ->withPivot('estado', 'fecha_inscripcion')
            ->withTimestamps();
    }
}