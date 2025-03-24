<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'noticias';

    protected $fillable = [
        'seccion_noticias_id',
        'titulo',
        'descripcion',
        'contenido',
        'autor_noticia',
        'imagen',
        'descripcion_imagen',
        'autor_imagen',
        'fecha_publicacion'
    ];

    protected $casts = [
        'fecha_publicacion' => 'date'
    ];

    public function seccionNoticia()
    {
        return $this->belongsTo(SeccionNoticia::class, 'seccion_noticias_id');
    }
}