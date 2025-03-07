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
        'fecha_fin'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'costo' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'inscripciones')
            ->withPivot('estado', 'fecha_inscripcion')
            ->withTimestamps();
    }
}