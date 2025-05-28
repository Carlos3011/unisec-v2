<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoTerceroTransferenciaConcurso;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminPagoTerceroController extends Controller
{
    public function index(Request $request)
    {
        $query = PagoTerceroTransferenciaConcurso::query()->with(['concurso', 'usuario']);

        // Aplicar filtros si existen
        if ($request->filled('tipo_tercero')) {
            $query->where('tipo_tercero', $request->tipo_tercero);
        }

        if ($request->filled('concurso')) {
            $query->where('concurso_id', $request->concurso);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pagos = $query->latest()->paginate(10);
        $concursos = Concurso::where('estado', 'activo')->get();
        return view('admin.pagos-terceros.index', compact('pagos', 'concursos'));
    }

    public function show($id)
    {
        $pago = PagoTerceroTransferenciaConcurso::findOrFail($id);
        return view('admin.pagos-terceros.show', compact('pago'));
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => ['required', 'in:validado,rechazado'],
            'observacion' => ['nullable', 'string', 'max:255']
        ]);

        $pago = PagoTerceroTransferenciaConcurso::findOrFail($id);

        if ($pago->estado_pago !== 'pendiente') {
            return redirect()->back()->with('error', 'Este pago ya ha sido procesado anteriormente.');
        }

        $pago->update([
            'estado_pago' => $request->estado,
            'observacion' => $request->observacion,
            'fecha_validacion' => now()
        ]);

        $mensaje = $request->estado === 'validado' 
            ? 'Pago validado exitosamente.' 
            : 'Pago rechazado exitosamente.';

        return redirect()->route('admin.pagos-terceros.show', $pago)
            ->with('success', $mensaje);
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