<?php

namespace App\Http\Controllers\Admin\Congreso;

use App\Http\Controllers\Controller;
use App\Models\InscripcionCongreso;
use App\Models\PagoInscripcionCongreso;
use App\Models\ArticuloCongreso;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InscripcionCongresoController extends Controller
{
    public function index(Request $request)
    {
        $query = InscripcionCongreso::with([
            'usuario',
            'congreso',
            'articulo',
            'convocatoria',
            'pagoInscripcion',
            'pagosCongreso'
        ]);

        // Aplicar filtros
        if ($request->has('tipo_participante')) {
            $query->where('tipo_participante', $request->tipo_participante);
        }

        if ($request->has('estado_pago')) {
            $query->whereHas('pagosCongreso', function($q) use ($request) {
                $q->where('estado_pago', $request->estado_pago);
            });
        }

        if ($request->has('estado_articulo')) {
            $query->whereHas('articulo', function($q) use ($request) {
                $q->where('estado_articulo', $request->estado_articulo);
            });
        }

        $inscripciones = $query->latest()->get();

        return view('admin.congresos.inscripciones.index', compact('inscripciones'));
    }

    public function show(InscripcionCongreso $inscripcion)
    {
        $inscripcion->load([
            'usuario',
            'congreso',
            'articulo',
            'convocatoria',
            'pagoInscripcion',
            'pagosCongreso'
        ]);

        return view('admin.congresos.inscripciones.show', compact('inscripcion'));
    }

    public function evaluarArticulo(Request $request, InscripcionCongreso $inscripcion)
    {
        $request->validate([
            'estado_articulo' => 'required|in:pendiente,en_revision,aceptado,rechazado',
            'comentarios_articulo' => 'required|string',
        ]);

        $articulo = $inscripcion->articulo;
        $articulo->update([
            'estado_articulo' => $request->estado_articulo,
            'comentarios_articulo' => $request->comentarios_articulo
        ]);

        return redirect()->route('admin.congresos.inscripciones.show', $inscripcion)
            ->with('success', 'La evaluación del artículo ha sido actualizada exitosamente.');
    }

    public function evaluarExtenso(Request $request, InscripcionCongreso $inscripcion)
    {
        $request->validate([
            'estado_extenso' => 'required|in:pendiente,en_revision,aceptado,rechazado',
            'comentarios_extenso' => 'required|string',
        ]);

        $articulo = $inscripcion->articulo;
        $articulo->update([
            'estado_extenso' => $request->estado_extenso,
            'comentarios_extenso' => $request->comentarios_extenso
        ]);

        return redirect()->route('admin.congresos.inscripciones.show', $inscripcion)
            ->with('success', 'La evaluación del extenso ha sido actualizada exitosamente.');
    }

    public function actualizarEstadoPago(Request $request, InscripcionCongreso $inscripcion)
    {
        $request->validate([
            'estado_pago' => 'required|in:pendiente,pagado,rechazado',
            'detalles_transaccion' => 'nullable|string',
        ]);

        $pago = $inscripcion->ultimoPago();
        
        if (!$pago) {
            return redirect()->route('admin.congresos.inscripciones.show', $inscripcion)
                ->with('error', 'No se encontró ningún pago asociado a esta inscripción.');
        }

        $pago->update([
            'estado_pago' => $request->estado_pago,
            'detalles_transaccion' => $request->detalles_transaccion,
            'fecha_pago' => $request->estado_pago === 'pagado' ? now() : null
        ]);

        return redirect()->route('admin.congresos.inscripciones.show', $inscripcion)
            ->with('success', 'El estado del pago ha sido actualizado exitosamente.');
    }

    public function destroy(InscripcionCongreso $inscripcion)
    {
        $inscripcion->delete();

        return redirect()->route('admin.congresos.inscripciones.index')
            ->with('success', 'La inscripción ha sido eliminada exitosamente.');
    }
}