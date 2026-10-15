<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    protected const METODOS = ['EFECTIVO', 'TRANSFERENCIA', 'TARJETA', 'DEPOSITO', 'OTRO'];

    protected function reglas(): array
    {
        return [
            'orden_id' => 'required|exists:ordenes_servicio,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|in:' . implode(',', self::METODOS),
            'referencia' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ];
    }

    protected function errorSaldo(OrdenServicio $orden, float $monto, ?int $ignorarPagoId = null): ?string
    {
        if ($orden->costo_total <= 0) {
            return null;
        }

        $pagado = $orden->pagos()
            ->when($ignorarPagoId, fn ($q) => $q->where('id', '!=', $ignorarPagoId))
            ->sum('monto');

        $saldo = round($orden->costo_total - $pagado, 2);

        if ($monto > $saldo + 0.009) {
            return 'El monto excede el saldo pendiente de la orden ($' . number_format(max($saldo, 0), 2) . ').';
        }

        return null;
    }

    public function index()
    {
        $pagos = Pago::with(['orden.cliente', 'usuario'])
            ->orderByDesc('fecha')
            ->paginate(15);

        return view('finanzas.pagos.index', compact('pagos'));
    }

    public function create(Request $request)
    {
        $ordenes = OrdenServicio::with('cliente')
            ->withSum('pagos', 'monto')
            ->where('estado', '!=', 'CANCELADO')
            ->orderByDesc('id')
            ->get();

        return view('finanzas.pagos.create', [
            'ordenes' => $ordenes,
            'ordenSeleccionada' => $request->input('orden_id'),
            'metodos' => self::METODOS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->reglas());

        $orden = OrdenServicio::findOrFail($validated['orden_id']);

        if ($error = $this->errorSaldo($orden, (float) $validated['monto'])) {
            return back()->withErrors(['monto' => $error])->withInput();
        }

        Pago::create(array_merge($validated, ['usuario_id' => Auth::id()]));

        return redirect()
            ->route('finanzas.pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function edit(string $id)
    {
        $pago = Pago::with('usuario')->findOrFail($id);

        $ordenes = OrdenServicio::with('cliente')
            ->withSum('pagos', 'monto')
            ->where('estado', '!=', 'CANCELADO')
            ->orWhere('id', $pago->orden_id)
            ->orderByDesc('id')
            ->get();

        return view('finanzas.pagos.edit', [
            'pago' => $pago,
            'ordenes' => $ordenes,
            'metodos' => self::METODOS,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);

        $validated = $request->validate($this->reglas());

        $orden = OrdenServicio::findOrFail($validated['orden_id']);

        if ($error = $this->errorSaldo($orden, (float) $validated['monto'], $pago->id)) {
            return back()->withErrors(['monto' => $error])->withInput();
        }

        $pago->update($validated);

        return redirect()
            ->route('finanzas.pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }
}