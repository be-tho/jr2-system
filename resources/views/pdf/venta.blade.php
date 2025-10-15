@extends('layout.print')

@section('content')
    <!-- Información del cliente y vendedor -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        @if($venta->cliente_nombre)
            <div class="client-info" style="flex: 1; margin-right: 20px;">
                <div class="client-title">Cliente:</div>
                <div>{{ $venta->cliente_nombre }}</div>
            </div>
        @endif
        
        <div class="client-info" style="flex: 1;">
            <div class="client-title">Vendedor:</div>
            <div>{{ $venta->user->name ?? 'Sistema' }}</div>
        </div>
    </div>

    <!-- Detalles de los artículos -->
    <table class="print-table">
        <thead>
            <tr>
                <th style="width: 8%;">Código</th>
                <th style="width: 40%;">Descripción</th>
                <th style="width: 10%;" class="text-center">Cantidad</th>
                <th style="width: 15%;" class="text-right">Precio Unit.</th>
                <th style="width: 15%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($venta->items as $item)
                <tr>
                    <td>{{ $item->articulo->codigo ?? 'N/A' }}</td>
                    <td>{{ $item->detalle ?? $item->articulo->nombre ?? 'Artículo' }}</td>
                    <td class="text-center">{{ $item->cantidad }}</td>
                    <td class="text-right">${{ number_format($item->precio_unitario, 2, '.', ',') }}</td>
                    <td class="text-right">${{ number_format($item->cantidad * $item->precio_unitario, 2, '.', ',') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay artículos en esta venta</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totales -->
    <div class="totals-section">
        <div class="total-row">
            <div class="total-label">Subtotal:</div>
            <div class="total-value">${{ number_format($venta->total, 2, '.', ',') }}</div>
        </div>
        
        @if($venta->impuestos > 0)
            <div class="total-row">
                <div class="total-label">Impuestos:</div>
                <div class="total-value">${{ number_format($venta->impuestos, 2, '.', ',') }}</div>
            </div>
        @endif
        
        <div class="total-row grand-total">
            <div class="total-label">TOTAL:</div>
            <div class="total-value">${{ number_format($venta->total, 2, '.', ',') }}</div>
        </div>
    </div>

    <!-- Notas adicionales -->
    @if($venta->notas)
        <div class="additional-info">
            <div class="info-title">Observaciones:</div>
            <div>{{ $venta->notas }}</div>
        </div>
    @endif

    <!-- Información adicional -->
    <div class="additional-info">
        <div class="info-title">Información de la venta:</div>
        <div>
            <strong>Método de pago:</strong> {{ $venta->metodo_pago ?? 'No especificado' }}<br>
            <strong>Estado:</strong> {{ ucfirst($venta->estado ?? 'completada') }}<br>
            <strong>Fecha de venta:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}
        </div>
    </div>
@endsection
