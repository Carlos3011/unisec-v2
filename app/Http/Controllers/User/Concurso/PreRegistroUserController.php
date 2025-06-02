<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\PreRegistroConcurso;
use App\Models\Concurso;
use App\Models\ConvocatoriaConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\PagoPreRegistro;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PreRegistroUserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', PreRegistroConcurso::class);
        $preRegistros = PreRegistroConcurso::with('concurso')
            ->where('usuario_id', Auth::id())
            ->latest()
            ->paginate(10);

        $convocatoria = ConvocatoriaConcurso::whereHas('concurso', function($query) {
            $query->where('estado', 'activo');
        })->first();
        
        return view('user.concursos.pre-registros.index', compact('preRegistros', 'convocatoria'));
    }

    public function create($convocatoria)
    {
        $this->authorize('create', PreRegistroConcurso::class);
        $convocatoria = ConvocatoriaConcurso::findOrFail($convocatoria);
        $concurso = $convocatoria->concurso;
        $concursos = collect([$concurso]);
        
        // Obtener el usuario autenticado para pre-llenar el formulario
        $user = Auth::user();

        return view('user.concursos.pre-registros.create', compact('concursos', 'convocatoria', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1|max:5',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'estado_pdr' => 'nullable|string',
            'archivo_pdr' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'integrantes_data' => 'required|array|min:1',
            'integrantes_data.*.nombre_completo' => 'required|string|max:255',
            'integrantes_data.*.matricula' => 'required|string|max:50',
            'integrantes_data.*.carrera' => 'required|string|max:255',
            'integrantes_data.*.correo_institucional' => 'required|email|max:255',
            'integrantes_data.*.periodo_academico' => 'required|integer|min:1',
            'integrantes_data.*.tipo_periodo' => 'required|in:semestre,cuatrimestre,trimestre'
        ]);

        // Verificar si el usuario ya tiene un pre-registro activo para este concurso
        $existingPreRegistro = PreRegistroConcurso::where('usuario_id', Auth::id())
            ->where('concurso_id', $request->concurso_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingPreRegistro) {
            return redirect()->route('user.concursos.pre-registros.index')
                ->with('error', 'Ya tienes un pre-registro para este concurso.');
        }

        // Validar pago confirmado
        $pagoConfirmado = PagoPreRegistro::where('usuario_id', Auth::id())
            ->where('concurso_id', $request->concurso_id)
            ->where('estado_pago', 'pagado')
            ->first();

        if (!$pagoConfirmado) {
            return redirect()->back()
                ->with('error', 'Debe tener un pago confirmado para realizar el pre-registro');
        }

        // Crear el pre-registro
        $preRegistro = PreRegistroConcurso::create([
            'usuario_id' => Auth::id(),
            'concurso_id' => $request->concurso_id,
            'pago_pre_registro_id' => $pagoConfirmado->id,
            'nombre_equipo' => $request->nombre_equipo,
            'integrantes' => count($request->integrantes_data),
            'asesor' => $request->asesor,
            'institucion' => $request->institucion,
            'comentarios' => $request->comentarios,
            'estado_pdr' => 'pendiente',
            'estado' => 'pendiente',
            'archivo_pdr' => $this->storeFile($request->file('archivo_pdr')),
            'integrantes_data' => $request->integrantes_data
        ]);

        return redirect()->route('user.concursos.pre-registros.index')
            ->with('success', 'Pre-registro creado exitosamente');
    }

    public function show(PreRegistroConcurso $preRegistro)
    {
        $this->authorize('view', $preRegistro);
        $preRegistro->load('concurso');
        
        return view('user.concursos.pre-registros.show', compact('preRegistro'));
    }


    public function edit(PreRegistroConcurso $preRegistro)
    {
        $this->authorize('update', $preRegistro);
        $preRegistro->load('concurso');
        
        return view('user.concursos.pre-registros.edit', compact('preRegistro'));
    }

    public function factura(PreRegistroConcurso $preRegistro)
    {
        $this->authorize('view', $preRegistro);
        
        $pago = PagoPreRegistro::with(['usuario', 'concurso'])
            ->findOrFail($preRegistro->pago_pre_registro_id);

        $detalles = json_decode($pago->detalles_transaccion, true);

        $datosFactura = [
            'id' => $pago->id,
            'usuario' => $pago->usuario->name,
            'email' => $pago->usuario->email, 
            'concurso' => $pago->concurso->titulo,
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

    public function update(Request $request, PreRegistroConcurso $preRegistro)
    {
        $this->authorize('update', $preRegistro);

        $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1|max:5',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string',
            'estado_pdr' => 'nullable|string',
            'archivo_pdr' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'integrantes_data' => 'required|array|min:1',
            'integrantes_data.*.nombre_completo' => 'required|string|max:255',
            'integrantes_data.*.matricula' => 'required|string|max:50',
            'integrantes_data.*.carrera' => 'required|string|max:255',
            'integrantes_data.*.correo_institucional' => 'required|email|max:255',
            'integrantes_data.*.periodo_academico' => 'required|integer|min:1',
            'integrantes_data.*.tipo_periodo' => 'required|in:semestre,cuatrimestre,trimestre'
        ]);

        $updateData = [
            'nombre_equipo' => $request->nombre_equipo,
            'integrantes' => count($request->integrantes_data),
            'asesor' => $request->asesor,
            'institucion' => $request->institucion,
            'integrantes_data' => $request->integrantes_data
        ];

        // Mantener el estado_pdr actual si no se proporciona uno nuevo
        if ($request->has('estado_pdr')) {
            $updateData['estado_pdr'] = $request->estado_pdr;
        }

        // Manejar la actualización del archivo PDR
        if ($request->hasFile('archivo_pdr')) {
            // Eliminar el archivo anterior si existe
            if ($preRegistro->archivo_pdr) {
                Storage::disk('public')->delete($preRegistro->archivo_pdr);
            }
            // Almacenar el nuevo archivo
            $updateData['archivo_pdr'] = $this->storeFile($request->file('archivo_pdr'));
        }

        $preRegistro->update($updateData);

        return redirect()->route('user.concursos.pre-registros.show', $preRegistro)
            ->with('success', 'Pre-registro actualizado exitosamente');
    }

    /**
     * Almacena un archivo en el sistema de archivos.
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @return string|null
     */
    private function storeFile($file)
    {
        if (!$file) {
            return null;
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/comprobantes_pago'), $fileName);
        return 'images/comprobantes_pago/' . $fileName;
    }

    /**
     * Descarga el archivo PDR.
     *
     * @param PreRegistroConcurso $preRegistro
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadPDR(PreRegistroConcurso $preRegistro)
    {
        $this->authorize('view', $preRegistro);

        if (!$preRegistro->archivo_pdr) {
            return back()->with('error', 'No hay archivo PDR disponible.');
        }

        return Storage::disk('public')->download($preRegistro->archivo_pdr);
    }
}