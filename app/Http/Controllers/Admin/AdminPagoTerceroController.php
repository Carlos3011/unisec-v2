<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoTerceroTransferenciaConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPagoTerceroController extends Controller
{
    public function index(Request $request)
    {
        $query = PagoTerceroTransferenciaConcurso::query();

        // Aplicar filtros si existen
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('concurso')) {
            $query->where('concurso_id', $request->concurso);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pagos = $query->paginate(10);
        return view('admin.pagos.index', compact('pagos'));
    }

    public function show($id)
    {
        $pago = PagoTerceroTransferenciaConcurso::findOrFail($id);
        return view('admin.pagos.show', compact('pago'));
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => ['required', 'in:validado,rechazado'],
            'observacion' => ['nullable', 'string', 'max:255']
        ]);

        $pago = PagoTerceroTransferenciaConcurso::findOrFail($id);
        $pago->update([
            'estado' => $request->estado,
            'observacion' => $request->observacion,
            'fecha_validacion' => now()
        ]);

        return redirect()->route('admin.pagos.show', $pago)
            ->with('success', 'Estado del pago actualizado exitosamente.');
    }

    /**
     * Genera un código único para el pago
     */
    protected function generarCodigo()
    {
        $year = date('Y');
        $prefix = 'UNIV-' . $year . '-';
        $uniqueString = strtoupper(Str::random(6));
        
        return $prefix . $uniqueString;
    }
}