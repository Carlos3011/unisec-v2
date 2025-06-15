<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionCongreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'articulo_id',
        'convocatoria_congreso_id',
        'tipo_participante',
        'institucion',
        'comprobante_estudiante',
        'pago_inscripcion_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'tipo_participante' => 'string'
    ];

    // Tipos de participante posibles
    const TIPO_ESTUDIANTE = 'estudiante';
    const TIPO_DOCENTE = 'docente';
    const TIPO_INVESTIGADOR = 'investigador';
    const TIPO_PROFESIONAL = 'profesional';

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el congreso
    public function congreso()
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    // Relación con el artículo
    public function articulo()
    {
        return $this->belongsTo(ArticuloCongreso::class, 'articulo_id');
    }

    // Relación con la convocatoria
    public function convocatoria()
    {
        return $this->belongsTo(ConvocatoriaCongreso::class, 'convocatoria_congreso_id');
    }

    // Relación con el pago de inscripción
    public function pagoInscripcion()
    {
        return $this->belongsTo(PagoInscripcionCongreso::class, 'pago_inscripcion_id');
    }

    // Relación con los pagos del congreso
    public function pagosCongreso()
    {
        return $this->hasMany(PagoInscripcionCongreso::class, 'usuario_id', 'usuario_id')
            ->where('congreso_id', $this->congreso_id);
    }

    // Método para verificar si la inscripción está pagada
    public function estaPagada()
    {
        return $this->pagosCongreso()
            ->where('estado_pago', 'pagado')
            ->exists();
    }

    public function ultimoPago()
    {
        return $this->pagosCongreso()
            ->latest('fecha_pago')
            ->first();
    }
}