<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\Concurso;
use App\Models\ConvocatoriaConcurso;
use App\Models\PagoTerceroTransferenciaConcurso;
use App\Models\PreRegistroConcurso;
use App\Models\InscripcionConcurso;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PagoTerceroController extends Controller
{
    public function index()
    {
        $pagos = PagoTerceroTransferenciaConcurso::where('usuario_id', Auth::id())
            ->with('concurso')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.concursos.pagos-terceros.index', compact('pagos'));
    }

    public function show($id)
    {
        $pago = PagoTerceroTransferenciaConcurso::where('usuario_id', Auth::id())
            ->with('concurso')
            ->findOrFail($id);

        return view('user.concursos.pagos-terceros.show', compact('pago'));
    }

    public function create()
    {
        $concursos = Concurso::with('convocatorias')
            ->where('estado', 'activo')
            ->get();
        return view('user.concursos.pagos-terceros.create', compact('concursos'));
    }

    public function validarForm()
    {
        $concursos = Concurso::with('convocatorias')
            ->where('estado', 'activo')
            ->get();
        return view('user.concursos.pagos-terceros.validar', compact('concursos'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo_tercero' => 'required|in:universidad,empresa,persona_fisica',
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:13',
                'contacto' => 'required|string|max:255',
                'correo' => 'required|email',
                'concurso_id' => 'required|exists:concursos,id',
                'cubre_pre_registro' => 'required|in:0,1',
                'cubre_inscripcion' => 'required|in:0,1',
                'numero_pagos' => 'required|integer|min:1',
                'comprobante' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            $concurso = Concurso::with('convocatorias')->findOrFail($request->concurso_id);
            $convocatoria = $concurso->convocatorias->first();

            if (!$convocatoria) {
                return response()->json(['message' => 'No hay convocatoria activa para este concurso'], 422);
            }

            $montoTotal = 0;
            if ($request->cubre_pre_registro == '1') {
                $montoTotal += $convocatoria->costo_pre_registro * $request->numero_pagos;
            }
            if ($request->cubre_inscripcion == '1') {
                $montoTotal += $convocatoria->costo_inscripcion * $request->numero_pagos;
            }

            if ($montoTotal == 0) {
                return response()->json(['message' => 'Debe seleccionar al menos un tipo de cobertura'], 422);
            }

            $codigoValidacion = Str::uuid();
            $comprobantePath = $request->file('comprobante')->store('comprobantes_pago_terceros', 'public');

            $pagoTercero = new PagoTerceroTransferenciaConcurso([
                'usuario_id' => Auth::id(),
                'tipo_tercero' => $request->tipo_tercero,
                'nombre_tercero' => $request->nombre,
                'rfc_tercero' => $request->rfc,
                'contacto_tercero' => $request->contacto,
                'correo_tercero' => $request->correo,
                'concurso_id' => $request->concurso_id,
                'cubre_pre_registro' => $request->cubre_pre_registro == '1',
                'cubre_inscripcion' => $request->cubre_inscripcion == '1',
                'numero_pagos' => $request->numero_pagos,
                'monto_total' => $montoTotal,
                'codigo_validacion_unico' => $codigoValidacion,
                'comprobante_pago' => $comprobantePath,
                'estado_pago' => 'pendiente'
            ]);

            $pagoTercero->save();

            return response()->json([
                'message' => 'Pago registrado exitosamente',
                'codigo_validacion' => $codigoValidacion
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar el pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function validarCodigo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string',
            'concurso_id' => 'required|exists:concursos,id',
            'tipo_uso' => 'required|in:pre_registro,inscripcion'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pagoTercero = PagoTerceroTransferenciaConcurso::where('codigo_validacion', $request->codigo)
            ->where('concurso_id', $request->concurso_id)
            ->where('estado', 'validado')
            ->first();

        if (!$pagoTercero) {
            return response()->json(['error' => 'Código inválido o no encontrado'], 404);
        }

        $usosActuales = $this->contarUsosCodigo($pagoTercero->id);
        if ($usosActuales >= $pagoTercero->numero_pagos) {
            return response()->json(['error' => 'El código ha alcanzado el límite de usos permitidos'], 400);
        }

        if ($request->tipo_uso === 'pre_registro' && !$pagoTercero->cubre_pre_registro) {
            return response()->json(['error' => 'El código no cubre pre-registro'], 400);
        }

        if ($request->tipo_uso === 'inscripcion' && !$pagoTercero->cubre_inscripcion) {
            return response()->json(['error' => 'El código no cubre inscripción'], 400);
        }

        return response()->json(['valid' => true, 'pago_tercero' => $pagoTercero]);
    }

    public function usarCodigoEnPreRegistro($codigo, $preRegistroId)
    {
        $preRegistro = PreRegistroConcurso::findOrFail($preRegistroId);
        $pagoTercero = PagoTerceroTransferenciaConcurso::where('codigo_validacion', $codigo)
            ->where('concurso_id', $preRegistro->concurso_id)
            ->where('estado', 'validado')
            ->first();

        if (!$pagoTercero || !$pagoTercero->cubre_pre_registro) {
            return false;
        }

        $usosActuales = $this->contarUsosCodigo($pagoTercero->id);
        if ($usosActuales >= $pagoTercero->numero_pagos) {
            return false;
        }

        $preRegistro->update(['codigo_pago_terceros' => $codigo]);
        return true;
    }

    public function usarCodigoEnInscripcion($codigo, $inscripcionId)
    {
        $inscripcion = InscripcionConcurso::findOrFail($inscripcionId);
        $pagoTercero = PagoTerceroTransferenciaConcurso::where('codigo_validacion', $codigo)
            ->where('concurso_id', $inscripcion->concurso_id)
            ->where('estado', 'validado')
            ->first();

        if (!$pagoTercero || !$pagoTercero->cubre_inscripcion) {
            return false;
        }

        $usosActuales = $this->contarUsosCodigo($pagoTercero->id);
        if ($usosActuales >= $pagoTercero->numero_pagos) {
            return false;
        }

        $inscripcion->update(['codigo_pago_terceros' => $codigo]);
        return true;
    }

    private function calcularMontoTotal($concurso, $cubrePreRegistro, $cubreInscripcion, $numeroPagos)
    {
        $montoTotal = 0;
        if ($cubrePreRegistro) {
            $montoTotal += $concurso->costo_pre_registro * $numeroPagos;
        }
        if ($cubreInscripcion) {
            $montoTotal += $concurso->costo_inscripcion * $numeroPagos;
        }
        return $montoTotal;
    }

    private function contarUsosCodigo($pagoTerceroId)
    {
        $usosPreRegistro = PreRegistroConcurso::where('codigo_pago_terceros', $pagoTerceroId)->count();
        $usosInscripcion = InscripcionConcurso::where('codigo_pago_terceros', $pagoTerceroId)->count();
        return $usosPreRegistro + $usosInscripcion;
    }
}