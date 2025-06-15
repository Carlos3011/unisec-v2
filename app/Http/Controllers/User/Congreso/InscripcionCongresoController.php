<?php

namespace App\Http\Controllers\User\Congreso;

use App\Http\Controllers\Controller;
use App\Models\InscripcionCongreso;
use App\Models\Congreso;
use App\Models\ConvocatoriaCongreso;
use App\Models\PagoInscripcionCongreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InscripcionCongresoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', InscripcionCongreso::class);
        $inscripciones = InscripcionCongreso::with('congreso')
            ->where('usuario_id', Auth::id())
            ->latest()
            ->paginate(10);

        $convocatoria = ConvocatoriaCongreso::whereHas('congreso', function($query) {
            $query->where('estado', 'activo');
        })->first();
        
        return view('user.congresos.inscripciones.index', compact('inscripciones', 'convocatoria'));
    }

    public function create($convocatoria)
    {
        $convocatoria = ConvocatoriaCongreso::findOrFail($convocatoria);
        $congreso = $convocatoria->congreso;
        $congresos = collect([$congreso]);
        
        $user = Auth::user();

        return view('user.congresos.inscripciones.create', compact('congresos', 'convocatoria', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'congreso_id' => 'required|exists:congresos,id',
            'tipo_participante' => 'required|string|in:ponente,asistente',
            'institucion' => 'required|string|max:255',
            'comprobante_estudiante' => 'required_if:tipo_participante,asistente|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'articulo_id' => 'required_if:tipo_participante,ponente|exists:articulos_congreso,id'
        ]);

        // Verificar si el usuario ya tiene una inscripción activa para este congreso
        $existingInscripcion = InscripcionCongreso::where('usuario_id', Auth::id())
            ->where('congreso_id', $request->congreso_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingInscripcion) {
            return redirect()->route('user.congresos.inscripciones.index')
                ->with('error', 'Ya tienes una inscripción para este congreso.');
        }

        // Validar pago confirmado
        $pagoConfirmado = PagoInscripcionCongreso::where('usuario_id', Auth::id())
            ->where('congreso_id', $request->congreso_id)
            ->where('estado_pago', 'pagado')
            ->first();

        if (!$pagoConfirmado) {
            return redirect()->back()
                ->with('error', 'Debe tener un pago confirmado para realizar la inscripción');
        }

        // Crear la inscripción
        $inscripcion = InscripcionCongreso::create([
            'usuario_id' => Auth::id(),
            'congreso_id' => $request->congreso_id,
            'convocatoria_congreso_id' => $request->convocatoria_id,
            'tipo_participante' => $request->tipo_participante,
            'institucion' => $request->institucion,
            'articulo_id' => $request->articulo_id,
            'pago_inscripcion_id' => $pagoConfirmado->id,
            'comprobante_estudiante' => $request->hasFile('comprobante_estudiante') 
                ? $this->storeFile($request->file('comprobante_estudiante')) 
                : null
        ]);

        return redirect()->route('user.congresos.inscripciones.index')
            ->with('success', 'Inscripción creada exitosamente');
    }

    public function show(InscripcionCongreso $inscripcion)
    {
        $this->authorize('view', $inscripcion);
        $inscripcion->load('congreso', 'articulo');
        
        return view('user.congresos.inscripciones.show', compact('inscripcion'));
    }

    public function edit(InscripcionCongreso $inscripcion)
    {
        $this->authorize('update', $inscripcion);
        $inscripcion->load('congreso', 'articulo');
        
        return view('user.congresos.inscripciones.edit', compact('inscripcion'));
    }

    public function update(Request $request, InscripcionCongreso $inscripcion)
    {
        $this->authorize('update', $inscripcion);

        $request->validate([
            'tipo_participante' => 'required|string|in:ponente,asistente',
            'institucion' => 'required|string|max:255',
            'comprobante_estudiante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'articulo_id' => 'required_if:tipo_participante,ponente|exists:articulos_congreso,id'
        ]);

        $updateData = [
            'tipo_participante' => $request->tipo_participante,
            'institucion' => $request->institucion,
            'articulo_id' => $request->articulo_id
        ];

        if ($request->hasFile('comprobante_estudiante')) {
            if ($inscripcion->comprobante_estudiante) {
                Storage::delete($inscripcion->comprobante_estudiante);
            }
            $updateData['comprobante_estudiante'] = $this->storeFile($request->file('comprobante_estudiante'));
        }

        $inscripcion->update($updateData);

        return redirect()->route('user.congresos.inscripciones.show', $inscripcion)
            ->with('success', 'Inscripción actualizada exitosamente');
    }

    public function factura(InscripcionCongreso $inscripcion)
    {
        $this->authorize('view', $inscripcion);
        
        $pago = PagoInscripcionCongreso::with(['usuario', 'congreso'])
            ->findOrFail($inscripcion->pago_inscripcion_id);

        $detalles = json_decode($pago->detalles_transaccion, true);

        $datosFactura = [
            'id' => $pago->id,
            'usuario' => $pago->usuario->name,
            'email' => $pago->usuario->email,
            'congreso' => $pago->congreso->titulo,
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

        $pdf = PDF::loadView('factura', ['datos' => $datosFactura]);
        return $pdf->download('ticket_'.$pago->id.'.pdf');
    }

    private function storeFile($file)
    {
        if (!$file) {
            return null;
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/comprobantes_estudiante'), $fileName);
        return 'images/comprobantes_estudiante/' . $fileName;
    }

    public function downloadComprobante(InscripcionCongreso $inscripcion)
    {
        $this->authorize('view', $inscripcion);

        if (!$inscripcion->comprobante_estudiante) {
            return back()->with('error', 'No hay comprobante disponible.');
        }

        return response()->download(public_path($inscripcion->comprobante_estudiante));
    }
} 