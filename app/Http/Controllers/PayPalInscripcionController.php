<?php

namespace App\Http\Controllers;

use App\Models\PagoInscripcionCongreso;
use App\Models\InscripcionCongreso;
use App\Models\ConvocatoriaCongreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayPalInscripcionController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            Log::info('Iniciando creación de orden PayPal', [
                'request_data' => $request->all(),
                'user_id' => auth()->id()
            ]);

            if (!$request->convocatoria_id) {
                Log::warning('Falta convocatoria_id en la petición');
                return response()->json([
                    'error' => 'El ID de la convocatoria es requerido'
                ], 422);
            }

            if ($request->tipo_participante === null || $request->tipo_participante === '') {
                Log::warning('Falta tipo_participante en la petición');
                return response()->json([
                    'error' => 'El tipo de participante es requerido'
                ], 422);
            }

            $convocatoria = ConvocatoriaCongreso::findOrFail($request->convocatoria_id);
            Log::info('Convocatoria encontrada', ['convocatoria' => $convocatoria->toArray()]);
            
            // Validar que el tipo de participante existe en las cuotas
            $cuotas = is_array($convocatoria->cuotas_inscripcion)
            ? $convocatoria->cuotas_inscripcion
            : json_decode($convocatoria->cuotas_inscripcion, true);
            Log::info('Cuotas de inscripción', ['cuotas' => $cuotas]);

            if (!isset($cuotas[$request->tipo_participante])) {
                Log::warning('Tipo de participante no válido', [
                    'tipo_participante' => $request->tipo_participante,
                    'cuotas_disponibles' => array_keys($cuotas)
                ]);
                return response()->json([
                    'error' => 'El tipo de participante seleccionado no es válido'
                ], 422);
            }

            // Crear registro de pago inicial
            $pago = PagoInscripcionCongreso::create([
                'usuario_id' => auth()->id(),
                'congreso_id' => $convocatoria->congreso_id,
                'monto' => $cuotas[$request->tipo_participante]['monto'],
                'metodo_pago' => 'paypal',
                'estado_pago' => 'pendiente'
            ]);

            Log::info('Pago creado exitosamente', ['pago' => $pago->toArray()]);

            return response()->json([
                'id' => $pago->id,
                'amount' => $pago->monto
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear orden de PayPal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'error' => 'Error al crear la orden: ' . $e->getMessage()
            ], 500);
        }
    }

    public function captureOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            Log::info('Iniciando captura de orden PayPal', [
                'request_data' => $request->all()
            ]);

            if (!$request->pago_id) {
                Log::warning('Falta pago_id en la petición');
                return response()->json([
                    'error' => 'El ID del pago es requerido'
                ], 422);
            }

            $pago = PagoInscripcionCongreso::findOrFail($request->pago_id);
            
            // Actualizar el registro con la información de PayPal
            $pago->update([
                'paypal_order_id' => $request->orderID,
                'referencia_paypal' => $request->paymentID,
                'estado_pago' => 'pagado',
                'fecha_pago' => now(),
                'detalles_transaccion' => json_encode($request->details)
            ]);

            DB::commit();
            Log::info('Pago actualizado exitosamente', ['pago' => $pago->toArray()]);

            return response()->json([
                'success' => true,
                'convocatoria_id' => $pago->congreso_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al capturar pago de PayPal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
} 