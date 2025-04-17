<?php

namespace App\Http\Controllers;

use App\Models\PagoPreRegistro;
use App\Models\PreRegistroConcurso;
use App\Models\ConvocatoriaConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PayPalController extends Controller
{
    public function createOrder(Request $request)
    {
        $convocatoria = ConvocatoriaConcurso::findOrFail($request->convocatoria_id);
        
        // Crear registro de pago inicial
        $pago = PagoPreRegistro::create([
            'usuario_id' => auth()->id(),
            'concurso_id' => $convocatoria->concurso_id,
            'monto' => $convocatoria->costo_pre_registro,
            'metodo_pago' => 'paypal',
            'estado_pago' => 'pendiente'
        ]);

        return response()->json([
            'id' => $pago->id,
            'amount' => $convocatoria->costo_pre_registro
        ]);
    }

    public function captureOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $pago = PagoPreRegistro::findOrFail($request->pago_id);
            
            // Actualizar el registro con la información de PayPal
            $pago->update([
                'paypal_order_id' => $request->orderID,
                'referencia_paypal' => $request->paymentID,
                'estado_pago' => 'pagado',
                'fecha_pago' => now(),
                'detalles_transaccion' => json_encode($request->details)
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'convocatoria_id' => $pago->concurso_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
}