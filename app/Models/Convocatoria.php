<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convocatoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'convocatorias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'archivo_pdf',
        'evento_id',
        'evento_type'
    ];

    public function evento()
    {
        return $this->morphTo();
    }

    public function curso()
    {
        return $this->morphTo('evento', 'evento_type', 'evento_id')->where('evento_type', Curso::class);
    }

    public function taller()
    {
        return $this->morphTo('evento', 'evento_type', 'evento_id')->where('evento_type', Taller::class);
    }

    public function congreso()
    {
        return $this->morphTo('evento', 'evento_type', 'evento_id')->where('evento_type', Congreso::class);
    }

    public function concurso()
    {
        return $this->morphTo('evento', 'evento_type', 'evento_id')->where('evento_type', Concurso::class);
    }

    public function fechasImportantes()
    {
        return $this->hasMany(FechaImportante::class);
    }
}