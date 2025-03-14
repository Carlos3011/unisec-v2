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
        'tema_id',
        'ponente_id',
        'costo',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date',
        'costo' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function ponente()
    {
        return $this->belongsTo(Ponente::class);
    }
}