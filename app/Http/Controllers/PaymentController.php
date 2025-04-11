<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $amount = $request->input('amount');
            
            // Crear un nuevo registro de pago
            $pago = new Pago();
            $pago->user_id = Auth::id();
            $pago->monto = $amount;
            $pago->estado = 'pendiente';
            $pago->save();
            
            return response()->json([
                'id' => $pago->id,
                'amount' => $amount
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function captureOrder(Request $request)
    {
        try {
            $orderId = $request->input('orderID');
            $paypalTransactionId = $request->input('paypalTransactionId');
            $pagoId = $request->input('pagoId');

            // Actualizar el estado del pago
            $pago = Pago::find($pagoId);
            if ($pago) {
                $pago->estado = 'completado';
                $pago->paypal_order_id = $orderId;
                $pago->paypal_transaction_id = $paypalTransactionId;
                $pago->fecha_pago = now();
                $pago->save();

                // Procesar el pre-registro si existe en la sesión
                if (session()->has('pre_registro_data')) {
                    $preRegistroData = session('pre_registro_data');
                    $preRegistro = PreRegistroConcurso::create($preRegistroData);
                    session()->forget('pre_registro_data');
                }

                return response()->json(['status' => 'success']);
            }

            return response()->json(['error' => 'Pago no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancelOrder(Request $request)
    {
        try {
            $pagoId = $request->input('pagoId');
            
            // Actualizar el estado del pago a cancelado
            $pago = Pago::find($pagoId);
            if ($pago) {
                $pago->estado = 'cancelado';
                $pago->save();
                
                return response()->json(['status' => 'success']);
            }

            return response()->json(['error' => 'Pago no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}