<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoPreRegistro;
use App\Models\User;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class PagoPreRegistroController extends Controller
{
    public function index(Request $request)
    {
        $query = PagoPreRegistro::with(['usuario', 'concurso'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->has('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $query->whereBetween('fecha_pago', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        $pagos = $query->get()->map(function ($pago) {
            $detalles = json_decode($pago->detalles_transaccion, true);
            return [
                'id' => $pago->id,
                'usuario' => $pago->usuario->name,
                'concurso' => $pago->concurso->nombre,
                'monto' => $pago->monto,
                'metodo_pago' => $pago->metodo_pago,
                'referencia_paypal' => $pago->referencia_paypal,
                'estado_pago' => $pago->estado_pago,
                'fecha_pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : null,
                'payer_email' => $detalles ? ($detalles['payer']['email_address'] ?? null) : null,
                'payer_name' => $detalles ? ($detalles['payer']['name']['given_name'] . ' ' . $detalles['payer']['name']['surname']) : null,
            ];
        });

        return view('admin.pagos.index', compact('pagos'));
    }

    public function show($id)
    {
        $pago = PagoPreRegistro::with(['usuario', 'concurso'])->findOrFail($id);
        $detalles = json_decode($pago->detalles_transaccion, true);

        return view('admin.pagos.show', compact('pago', 'detalles'));
    }

    public function generarFactura($id)
    {
        $pago = PagoPreRegistro::with(['usuario', 'concurso'])->findOrFail($id);
        $detalles = json_decode($pago->detalles_transaccion, true);

        // Aquí iría la lógica para generar la factura en PDF
        // Puedes usar paquetes como DomPDF o TCPDF

        // Ejemplo básico de respuesta
        return response()->json([
            'mensaje' => 'Funcionalidad de generación de factura en desarrollo',
            'pago_id' => $id
        ]);
    }

    public function exportarPagos(Request $request)
    {
        $pagos = PagoPreRegistro::with(['usuario', 'concurso'])
            ->when($request->estado_pago, function($query, $estado) {
                return $query->where('estado_pago', $estado);
            })
            ->when($request->fecha_inicio && $request->fecha_fin, function($query) use ($request) {
                return $query->whereBetween('fecha_pago', [
                    Carbon::parse($request->fecha_inicio)->startOfDay(),
                    Carbon::parse($request->fecha_fin)->endOfDay()
                ]);
            })
            ->get()
            ->map(function ($pago) {
                return [
                    'ID' => $pago->id,
                    'Usuario' => $pago->usuario->name,
                    'Concurso' => $pago->concurso->nombre,
                    'Monto' => $pago->monto,
                    'Método de Pago' => $pago->metodo_pago,
                    'Referencia PayPal' => $pago->referencia_paypal,
                    'Estado' => $pago->estado_pago,
                    'Fecha de Pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : '',
                ];
            });

        // Crear archivo CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pagos-' . Carbon::now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($pagos) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys($pagos->first()));

            foreach ($pagos as $pago) {
                fputcsv($file, $pago);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}