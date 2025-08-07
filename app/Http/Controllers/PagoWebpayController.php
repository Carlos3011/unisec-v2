<?php

namespace App\Http\Controllers;

use App\Models\PagoWebpay;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PagoWebpayController extends Controller
{
    /**
     * Muestra el formulario de pago.
     */
    public function crear(int $cursoId)
    {
        $curso = Curso::findOrFail($cursoId);

        return view('pagos.webpay.formulario', compact('curso'));
    }

    /**
     * Inicia el proceso de pago WebPay.
     */
    public function iniciarPago(Request $request, int $cursoId)
    {
        $curso = Curso::findOrFail($cursoId);

        $request->validate([
            'monto' => 'required|numeric|min:10',
        ]);

        // Generar orden de compra
        $buyOrder = PagoWebpay::generarBuyOrder();
        $pago = PagoWebpay::create([
            'usuario_id' => Auth::id(),
            'curso_id' => $curso->id,
            'monto' => $request->monto,
            'moneda' => 'MXN',
            'webpay_token' => null, 
            'webpay_buy_order' => $buyOrder,
            'estado' => PagoWebpay::ESTADO_PENDIENTE,
            'descripcion' => "Pago para el curso: {$curso->titulo}",
        ]);

        $pago->webpay_token = 'simulated-token-' . uniqid();
        $pago->save();

        return redirect()->route('pagos.webpay.mostrar', $pago->id);
    }

    /**
     * Muestra el estado del pago.
     */
    public function mostrar($id)
    {
        $pago = PagoWebpay::with('curso')->findOrFail($id);

        return view('pagos.webpay.detalle', compact('pago'));
    }

    /**
     * Procesa la respuesta de WebPay (callback).
     */
    public function respuestaWebpay(Request $request)
    {
        $token = $request->input('token_ws');

        $pago = PagoWebpay::where('webpay_token', $token)->firstOrFail();

        $respuesta = [
            'status' => 'AUTHORIZED',
            'authorization_code' => 'ABC123',
            'transaction_date' => now()->toDateTimeString(),
            'card_detail' => [
                'card_type' => 'VI',
                'card_number' => '1234',
            ],
            'installments_number' => 1,
        ];

        $pago->procesarRespuestaWebpay($respuesta);

        return redirect()->route('pagos.webpay.mostrar', $pago->id)
                         ->with('mensaje', 'Pago procesado correctamente.');
    }
}
