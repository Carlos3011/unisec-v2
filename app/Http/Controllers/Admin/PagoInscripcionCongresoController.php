<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\PagoInscripcionCongreso;
use App\Models\User;
use App\Models\Congreso;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class PagoInscripcionCongresoController extends Controller
{
    public function index(Request $request)
    {
        $query = PagoInscripcionCongreso::with(['usuario', 'congreso'])
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
                'congreso' => $pago->congreso->nombre,
                'monto' => $pago->monto,
                'metodo_pago' => $pago->metodo_pago,
                'referencia_paypal' => $pago->referencia_paypal,
                'estado_pago' => $pago->estado_pago,
                'fecha_pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : null,
                'paypal_order_id' => $detalles['id'] ?? null,
                'paypal_status' => $detalles['status'] ?? null,
                'paypal_intent' => $detalles['intent'] ?? null,
                'payee' => [
                    'email_address' => $detalles['purchase_units'][0]['payee']['email_address'] ?? null,
                    'merchant_id' => $detalles['purchase_units'][0]['payee']['merchant_id'] ?? null
                ],
                'description' => $detalles['purchase_units'][0]['description'] ?? null,
                'soft_descriptor' => $detalles['purchase_units'][0]['soft_descriptor'] ?? null,
                'shipping' => [
                    'name' => $detalles['purchase_units'][0]['shipping']['name']['full_name'] ?? null,
                    'address' => [
                        'address_line_1' => $detalles['purchase_units'][0]['shipping']['address']['address_line_1'] ?? null,
                        'address_line_2' => $detalles['purchase_units'][0]['shipping']['address']['address_line_2'] ?? null,
                        'admin_area_2' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_2'] ?? null,
                        'admin_area_1' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_1'] ?? null,
                        'postal_code' => $detalles['purchase_units'][0]['shipping']['address']['postal_code'] ?? null,
                        'country_code' => $detalles['purchase_units'][0]['shipping']['address']['country_code'] ?? null
                    ]
                ],
                'payer' => [
                    'name' => [
                        'given_name' => $detalles['payer']['name']['given_name'] ?? null,
                        'surname' => $detalles['payer']['name']['surname'] ?? null
                    ],
                    'email_address' => $detalles['payer']['email_address'] ?? null,
                    'payer_id' => $detalles['payer']['payer_id'] ?? null,
                    'country_code' => $detalles['payer']['address']['country_code'] ?? null
                ],
                'payment_capture' => [
                    'id' => $detalles['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                    'status' => $detalles['purchase_units'][0]['payments']['captures'][0]['status'] ?? null,
                    'amount' => [
                        'currency_code' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? null,
                        'value' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? null
                    ],
                    'create_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['create_time'] ?? null,
                    'update_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['update_time'] ?? null
                ],
                'create_time' => $detalles['create_time'] ?? null,
                'update_time' => $detalles['update_time'] ?? null
            ];
        });

        return view('admin.congresos.pagos.index', compact('pagos'));
    }

    public function show($id)
    {
        $pago = PagoInscripcionCongreso::with(['usuario', 'congreso'])->findOrFail($id);
        $detalles = json_decode($pago->detalles_transaccion, true);

        $datosPago = [
            'id' => $pago->id,
            'usuario' => $pago->usuario->name,
            'email' => $pago->usuario->email, 
            'congreso' => $pago->congreso->nombre,
            'monto' => $pago->monto,
            'metodo_pago' => $pago->metodo_pago,
            'referencia_paypal' => $pago->referencia_paypal,
            'estado_pago' => $pago->estado_pago,
            'fecha_pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : null,
            'paypal_order_id' => $detalles['id'] ?? null,
            'paypal_status' => $detalles['status'] ?? null,
            'paypal_intent' => $detalles['intent'] ?? null,
            'payee' => [
                'email_address' => $detalles['purchase_units'][0]['payee']['email_address'] ?? null,
                'merchant_id' => $detalles['purchase_units'][0]['payee']['merchant_id'] ?? null
            ],
            'description' => $detalles['purchase_units'][0]['description'] ?? null,
            'soft_descriptor' => $detalles['purchase_units'][0]['soft_descriptor'] ?? null,
            'shipping' => [
                'name' => $detalles['purchase_units'][0]['shipping']['name']['full_name'] ?? null,
                'address' => [
                    'address_line_1' => $detalles['purchase_units'][0]['shipping']['address']['address_line_1'] ?? null,
                    'address_line_2' => $detalles['purchase_units'][0]['shipping']['address']['address_line_2'] ?? null,
                    'admin_area_2' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_2'] ?? null,
                    'admin_area_1' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_1'] ?? null,
                    'postal_code' => $detalles['purchase_units'][0]['shipping']['address']['postal_code'] ?? null,
                    'country_code' => $detalles['purchase_units'][0]['shipping']['address']['country_code'] ?? null
                ]
            ],
            'payer' => [
                'name' => [
                    'given_name' => $detalles['payer']['name']['given_name'] ?? null,
                    'surname' => $detalles['payer']['name']['surname'] ?? null
                ],
                'email_address' => $detalles['payer']['email_address'] ?? null,
                'payer_id' => $detalles['payer']['payer_id'] ?? null,
                'country_code' => $detalles['payer']['address']['country_code'] ?? null
            ],
            'payment_capture' => [
                'id' => $detalles['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                'status' => $detalles['purchase_units'][0]['payments']['captures'][0]['status'] ?? null,
                'amount' => [
                    'currency_code' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? null,
                    'value' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? null
                ],
                'create_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['create_time'] ?? null,
                'update_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['update_time'] ?? null
            ],
            'create_time' => $detalles['create_time'] ?? null,
            'update_time' => $detalles['update_time'] ?? null
        ];

        return view('admin.congresos.pagos.show', compact('datosPago'));
    }

    public function generarFactura($id)
    {
        $pago = PagoInscripcionCongreso::with(['usuario', 'congreso'])->findOrFail($id);
        $detalles = json_decode($pago->detalles_transaccion, true);

        $datosFactura = [
            'id' => $pago->id,
            'usuario' => $pago->usuario->name,
            'email' => $pago->usuario->email, 
            'congreso' => $pago->congreso->nombre,
            'monto' => $pago->monto,
            'metodo_pago' => $pago->metodo_pago,
            'referencia_paypal' => $pago->referencia_paypal,
            'estado_pago' => $pago->estado_pago,
            'fecha_pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : null,
            'paypal_order_id' => $detalles['id'] ?? null,
            'paypal_status' => $detalles['status'] ?? null,
            'paypal_intent' => $detalles['intent'] ?? null,
            'payee' => [
                'email_address' => $detalles['purchase_units'][0]['payee']['email_address'] ?? null,
                'merchant_id' => $detalles['purchase_units'][0]['payee']['merchant_id'] ?? null
            ],
            'description' => $detalles['purchase_units'][0]['description'] ?? null,
            'soft_descriptor' => $detalles['purchase_units'][0]['soft_descriptor'] ?? null,
            'shipping' => [
                'name' => $detalles['purchase_units'][0]['shipping']['name']['full_name'] ?? null,
                'address' => [
                    'address_line_1' => $detalles['purchase_units'][0]['shipping']['address']['address_line_1'] ?? null,
                    'address_line_2' => $detalles['purchase_units'][0]['shipping']['address']['address_line_2'] ?? null,
                    'admin_area_2' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_2'] ?? null,
                    'admin_area_1' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_1'] ?? null,
                    'postal_code' => $detalles['purchase_units'][0]['shipping']['address']['postal_code'] ?? null,
                    'country_code' => $detalles['purchase_units'][0]['shipping']['address']['country_code'] ?? null
                ]
            ],
            'payer' => [
                'name' => [
                    'given_name' => $detalles['payer']['name']['given_name'] ?? null,
                    'surname' => $detalles['payer']['name']['surname'] ?? null
                ],
                'email_address' => $detalles['payer']['email_address'] ?? null,
                'payer_id' => $detalles['payer']['payer_id'] ?? null,
                'country_code' => $detalles['payer']['address']['country_code'] ?? null
            ],
            'payment_capture' => [
                'id' => $detalles['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                'status' => $detalles['purchase_units'][0]['payments']['captures'][0]['status'] ?? null,
                'amount' => [
                    'currency_code' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? null,
                    'value' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? null
                ],
                'create_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['create_time'] ?? null,
                'update_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['update_time'] ?? null
            ],
            'create_time' => $detalles['create_time'] ?? null,
            'update_time' => $detalles['update_time'] ?? null
        ];

        $pdf = PDF::loadView('factura-congreso', ['datos' => $datosFactura]);
        return $pdf->download('ticket_congreso_'.$pago->id.'.pdf');
    }

    public function exportarPagos(Request $request)
    {
        $pagos = PagoInscripcionCongreso::with(['usuario', 'congreso'])
            ->when($request->estado_pago, function ($query, $estado) {
                return $query->where('estado_pago', $estado);
            })
            ->when($request->fecha_inicio && $request->fecha_fin, function ($query) use ($request) {
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
                    'Congreso' => $pago->congreso->nombre,
                    'Monto' => $pago->monto,
                    'Método de Pago' => $pago->metodo_pago,
                    'Referencia PayPal' => $pago->referencia_paypal,
                    'Estado' => $pago->estado_pago,
                    'Fecha de Pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : ''
                ];
            });

        // Crear archivo CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pagos-congreso-' . Carbon::now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($pagos) {
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