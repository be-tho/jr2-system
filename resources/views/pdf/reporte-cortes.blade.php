<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Cortes - {{ date('d/m/Y') }}</title>
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
        
        .estado-cortado {
            background-color: #fef3cd;
            color: #856404;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        
        .estado-costurando {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        
        .estado-entregado {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
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
        <h1>Reporte de Cortes</h1>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
        <p>Sistema JR2 - Gestión de Cortes</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="section">
        <h3>Estadísticas Generales</h3>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['total_cortes'] ?? 0) }}</div>
                    <div class="stat-label">Total Cortes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['pendientes'] ?? 0) }}</div>
                    <div class="stat-label">Pendientes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['entregados'] ?? 0) }}</div>
                    <div class="stat-label">Entregados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['total_articulos'] ?? 0) }}</div>
                    <div class="stat-label">Total Artículos</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resúmenes por Estado y Mes -->
    <div class="section">
        <h3>Resúmenes</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <h4 style="margin: 0 0 10px 0; font-size: 12px;">Por Estado</h4>
                    @foreach($porEstado as $estado => $data)
                    <div class="summary-item">
                        <span class="summary-label">{{ is_string($data['estado']) ? $data['estado'] : 'Desconocido' }}</span>
                        <span class="summary-value">{{ number_format($data['cantidad'] ?? 0) }} cortes</span>
                    </div>
                    @endforeach
                </div>
                <div class="summary-cell">
                    <h4 style="margin: 0 0 10px 0; font-size: 12px;">Por Mes</h4>
                    @foreach($porMes as $mes => $data)
                    <div class="summary-item">
                        <span class="summary-label">{{ is_string($mes) ? $mes : 'Sin fecha' }}</span>
                        <span class="summary-value">{{ number_format($data['cantidad'] ?? 0) }} cortes</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Cortes -->
    <div class="section">
        <h3>Lista de Cortes</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Tipo Tela</th>
                    <th class="text-center">Cantidad</th>
                    <th>Artículos</th>
                    <th>Fecha</th>
                    <th class="text-center">Estado</th>
                    <th>Colores</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cortes as $corte)
                <tr>
                    <td>{{ $corte->numero_corte ?? 'N/A' }}</td>
                    <td>{{ is_string($corte->descripcion) ? $corte->descripcion : 'Sin descripción' }}</td>
                    <td>{{ is_string($corte->tipo_tela) ? $corte->tipo_tela : 'Sin tipo de tela' }}</td>
                    <td class="text-center">{{ number_format($corte->cantidad_total ?? 0) }}</td>
                    <td>{{ is_string($corte->articulos) ? Str::limit($corte->articulos, 30) : (is_array($corte->articulos) ? implode(', ', $corte->articulos) : 'No disponible') }}</td>
                    <td>{{ $corte->fecha ? \Carbon\Carbon::parse($corte->fecha)->format('d/m/Y') : 'No disponible' }}</td>
                    <td class="text-center">
                        @if($corte->estado == 0)
                            <span class="estado-cortado">Cortado</span>
                        @elseif($corte->estado == 1)
                            <span class="estado-costurando">Costurando</span>
                        @elseif($corte->estado == 2)
                            <span class="estado-entregado">Entregado</span>
                        @else
                            <span class="estado-cortado">Desconocido</span>
                        @endif
                    </td>
                    <td>{{ is_string($corte->colores) ? $corte->colores : 'No especificado' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron cortes con los filtros aplicados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema JR2</p>
        <p>Página 1 de 1 - Total de registros: {{ $cortes->count() }}</p>
    </div>
</body>
</html>
