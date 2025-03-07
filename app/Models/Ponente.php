<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ponente extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'ponentes';
    
    protected $fillable = [
        'nombre',
        'bio',
        'especialidad'
    ];

    protected $dates = ['deleted_at'];

    // Relación con cursos
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    // Relación con talleres
    public function talleres()
    {
        return $this->hasMany(Taller::class);
    }

    // Relación con ponencias
    public function ponencias()
    {
        return $this->hasMany(Ponencia::class);
    }
}