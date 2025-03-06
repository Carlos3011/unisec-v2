<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema extends Model
{
    use SoftDeletes;

    protected $table = 'temas';
    
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $dates = ['deleted_at'];
}