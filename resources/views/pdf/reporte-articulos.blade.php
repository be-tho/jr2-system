<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Artículos - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section h3 {
            background-color: #333;
            color: white;
            padding: 8px 12px;
            margin: 0 0 15px 0;
            font-size: 14px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
            background-color: #f9f9f9;
            margin-bottom: 2px;
        }
        
        .summary-label {
            font-weight: bold;
        }
        
        .summary-value {
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        
        td {
            font-size: 10px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Reporte de Artículos</h1>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
        <p>Sistema JR2 - Gestión de Inventario</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="section">
        <h3>Estadísticas Generales</h3>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['total_articulos']) }}</div>
                    <div class="stat-label">Total Artículos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['articulos_sin_stock']) }}</div>
                    <div class="stat-label">Sin Stock</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['articulos_stock_bajo']) }}</div>
                    <div class="stat-label">Stock Bajo</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${{ number_format($stats['valor_total']) }}</div>
                    <div class="stat-label">Valor Total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resúmenes por Categoría y Temporada -->
    <div class="section">
        <h3>Resúmenes</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <h4 style="margin: 0 0 10px 0; font-size: 12px;">Por Categoría</h4>
                    @foreach($porCategoria as $categoria => $data)
                    <div class="summary-item">
                        <span class="summary-label">{{ $categoria ?: 'Sin categoría' }}</span>
                        <span class="summary-value">{{ number_format($data['cantidad']) }} artículos - ${{ number_format($data['valor_total']) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="summary-cell">
                    <h4 style="margin: 0 0 10px 0; font-size: 12px;">Por Temporada</h4>
                    @foreach($porTemporada as $temporada => $data)
                    <div class="summary-item">
                        <span class="summary-label">{{ $temporada ?: 'Sin temporada' }}</span>
                        <span class="summary-value">{{ number_format($data['cantidad']) }} artículos - ${{ number_format($data['valor_total']) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Artículos -->
    <div class="section">
        <h3>Lista de Artículos</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Temporada</th>
                    <th class="text-right">Precio</th>
                    <th class="text-center">Stock</th>
                    <th class="text-right">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articulos as $articulo)
                <tr>
                    <td>{{ $articulo->id }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $articulo->temporada->nombre ?? 'Sin temporada' }}</td>
                    <td class="text-right">${{ number_format($articulo->precio) }}</td>
                    <td class="text-center">{{ number_format($articulo->stock) }}</td>
                    <td class="text-right">${{ number_format($articulo->precio * $articulo->stock) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No se encontraron artículos con los filtros aplicados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema JR2</p>
        <p>Página 1 de 1 - Total de registros: {{ $articulos->count() }}</p>
    </div>
</body>
</html>
