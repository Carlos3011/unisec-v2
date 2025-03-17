<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria_id',
        'tema_id',
        'ponente_id',
        'costo',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];


    protected $casts = [
        'estado' => 'string',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'costo' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function tema(){
        return $this->belongsTo(Tema::class);
    }
    public function ponente(){
        return $this->belongsTo(Ponente::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(InscripcionCurso::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'inscripciones')
            ->withPivot('estado', 'fecha_inscripcion')
            ->withTimestamps();
    }
}