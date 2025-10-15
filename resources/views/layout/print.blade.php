<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Imprimir' }} - {{ config('app.name', 'JR2 System') }}</title>
    
    <!-- Estilos específicos para impresión -->
    <style>
        /* Reset y configuración base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }
        
        /* Configuración de página */
        @page {
            size: A4;
            margin: 1cm;
        }
        
        /* Contenedor principal */
        .print-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
        }
        
        /* Header de impresión */
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-logo {
            max-width: 120px;
            max-height: 80px;
            object-fit: contain;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .company-details {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }
        
        .document-info {
            text-align: right;
            flex: 1;
        }
        
        .document-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .document-details {
            font-size: 10px;
            color: #666;
        }
        
        /* Contenido principal */
        .print-content {
            margin: 20px 0;
        }
        
        /* Tablas */
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .print-table th,
        .print-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        .print-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        
        .print-table .text-right {
            text-align: right;
        }
        
        .print-table .text-center {
            text-align: center;
        }
        
        /* Totales */
        .totals-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 5px;
        }
        
        .total-label {
            width: 120px;
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
        }
        
        .total-value {
            width: 100px;
            text-align: right;
            border-bottom: 1px solid #333;
        }
        
        .grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 5px;
            margin-top: 10px;
        }
        
        /* Footer */
        .print-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
            text-align: center;
        }
        
        /* Información adicional */
        .additional-info {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #333;
        }
        
        .info-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        /* Cliente */
        .client-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 4px;
        }
        
        .client-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        /* Ocultar elementos no necesarios para impresión */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .print-container {
                box-shadow: none;
            }
        }
        
        /* Estilos para pantalla (vista previa) */
        @media screen {
            body {
                background-color: #f5f5f5;
                padding: 20px;
            }
            
            .print-container {
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                padding: 20px;
                max-width: 210mm;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Header con logo y datos de empresa -->
        <div class="print-header">
            <div class="company-info">
                @if(isset($company_logo) && $company_logo)
                    <img src="{{ $company_logo }}" alt="Logo" class="company-logo">
                @endif
                <div class="company-name">{{ $company_name ?? 'JR2 System' }}</div>
                <div class="company-details">
                    {{ $company_address ?? 'Dirección de la empresa' }}<br>
                    Tel: {{ $company_phone ?? 'Teléfono' }} | Email: {{ $company_email ?? 'email@empresa.com' }}
                </div>
            </div>
            <div class="document-info">
                <div class="document-title">{{ $document_title ?? 'VENTA' }}</div>
                <div class="document-details">
                    @if(isset($document_number))
                        <strong>N°:</strong> {{ $document_number }}<br>
                    @endif
                    <strong>Fecha:</strong> {{ $document_date ?? now()->format('d/m/Y') }}<br>
                    <strong>Hora:</strong> {{ $document_time ?? now()->format('H:i') }}
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="print-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="print-footer">
            <div>{{ $company_name ?? 'JR2 System' }} - Sistema de Gestión</div>
            <div>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</div>
        </div>
        
        <!-- Controles de impresión (solo visible en pantalla) -->
        <div class="no-print" style="text-align: center; margin-top: 20px; padding: 25px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 10px; border: 3px solid #007cba; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 20px;">
                <h3 style="color: #007cba; margin: 0; font-size: 18px; font-weight: bold;">🖨️ Vista de Impresión</h3>
                <p style="margin: 8px 0 0 0; font-size: 14px; color: #666;">
                    Revisa el documento y decide qué hacer
                </p>
            </div>
            
            <div style="margin-bottom: 20px;">
                <button onclick="window.print()" style="background: #059669; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; margin: 8px; box-shadow: 0 2px 8px rgba(5,150,105,0.3); transition: all 0.2s;">
                    🖨️ Imprimir Documento
                </button>
                <button onclick="window.location.href='/ventas'" style="background: #6b7280; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; margin: 8px; box-shadow: 0 2px 8px rgba(107,114,128,0.3); transition: all 0.2s;">
                    🚪 Cerrar Sin Imprimir
                </button>
            </div>
            
            <div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px; padding: 12px; margin-top: 15px;">
                <p style="margin: 0; font-size: 13px; color: #1e40af; line-height: 1.4;">
                    <strong>📋 Instrucciones:</strong><br>
                    1. Revisa el documento arriba<br>
                    2. Haz clic en "Imprimir Documento" para abrir el diálogo de impresión<br>
                    3. Después de imprimir, guardar como PDF o cancelar, regresarás al historial de ventas<br>
                    4. O haz clic en "Cerrar Sin Imprimir" para regresar al historial ahora
                </p>
            </div>
        </div>
        
    </div>

    <!-- Script simplificado y robusto -->
    <script>
        let isClosing = false;
        
        // Función para cerrar ventana de forma segura
        function safeClose() {
            if (isClosing) return;
            isClosing = true;
            
            // Redirigir al historial de ventas
            window.location.href = '/ventas';
        }
        
        // NO imprimir automáticamente - mostrar la vista primero
        window.onload = function() {
            // Solo mostrar la vista, no imprimir automáticamente
            console.log('Vista de impresión cargada - lista para imprimir');
        };
        
        // Cerrar después de imprimir - SOLUCIÓN SIMPLE
        window.onafterprint = function() {
            setTimeout(function() {
                window.location.href = '/ventas';
            }, 1000);
        };
        
        // Detectar si el usuario cancela múltiples veces
        let cancelCount = 0;
        window.addEventListener('focus', function() {
            cancelCount++;
            if (cancelCount >= 2) {
                setTimeout(function() {
                    window.location.href = '/ventas';
                }, 500);
            }
        });
        
        // Función global para el botón manual
        window.safeClose = safeClose;
    </script>
</body>
</html>
