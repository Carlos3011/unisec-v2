<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeccionNoticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'seccion_noticias';

    protected $fillable = [
        'titulo'
    ];

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'seccion_noticias_id');
    }
}