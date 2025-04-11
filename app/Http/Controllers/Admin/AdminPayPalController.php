<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pago;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class AdminPayPalController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }

    public function showTransactions()
    {
        $pagos = Pago::with('usuario')->latest()->paginate(10);
        return view('admin.pagos-facturacion.index', compact('pagos'));
    }

    public function handlePaymentStatus(Request $request)
    {
        $response = $this->provider->capturePaymentOrder($request->token);
        
        if ($response['status'] === 'COMPLETED') {
            Pago::where('paypal_id', $response['id'])
                ->update(['estado' => 'aprobado']);
        }

        return redirect()->route('admin.pagos.index');
    }

    public function handleWebhook(Request $request)
    {
        $webhookContent = json_decode($request->getContent(), true);
        
        if ($webhookContent['event_type'] === 'PAYMENT.CAPTURE.COMPLETED') {
            Pago::where('paypal_id', $webhookContent['resource']['id'])
                ->update(['estado' => 'completado']);
        }

        return response()->json(['status' => 'success']);
    }
}