<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte anual {{ $anio }} - Funeraria San José</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 24px; }
        .reporte-wrap { max-width: 800px; margin: 0 auto; }
        .reporte-header {
            background: linear-gradient(135deg, #5C0E2B 0%, #3d0a1e 100%);
            color: #fff;
            padding: 24px 28px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .reporte-header .icono { font-size: 28px; color: #FFD700; margin-bottom: 6px; }
        .reporte-header .nombre { font-size: 11px; letter-spacing: 3px; color: #FFD700; text-transform: uppercase; margin: 0; }
        .reporte-header h1 { font-size: 22px; font-weight: 600; margin: 4px 0 0 0; letter-spacing: 1px; }
        .reporte-header .subtitulo { font-size: 11px; color: rgba(255,255,255,0.9); margin: 6px 0 0 0; }
        .reporte-body { padding: 24px 28px; border: 1px solid #e5e7eb; border-top: none; }
        .reporte-periodo { font-size: 13px; color: #5C0E2B; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #FFD700; }
        h2 { font-size: 14px; color: #5C0E2B; margin: 20px 0 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; }
        th { background: #5C0E2B; color: #fff; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        tr:nth-child(even) { background: #f9fafb; }
        .text-right { text-align: right; }
        .total { font-weight: bold; background: #f3f4f6 !important; }
        .reporte-footer {
            margin-top: 28px;
            padding: 16px 28px;
            border: 1px solid #e5e7eb;
            border-top: 2px solid #FFD700;
            border-radius: 0 0 8px 8px;
            font-size: 10px; color: #6b7280;
            text-align: center;
        }
        @media print {
            body { padding: 12px; }
            .reporte-header { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="reporte-wrap">
        <header class="reporte-header">
            <div class="icono" aria-hidden="true">&#10013;</div>
            <p class="nombre">Funeraria</p>
            <h1>San José</h1>
            <p class="subtitulo">Servicios exequiales con dignidad y respeto</p>
        </header>

        <div class="reporte-body">
            <p class="reporte-periodo">Reporte anual de entradas — Año {{ $anio }}</p>

            <h2>Resumen por mes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th class="text-right">Cantidad de pagos</th>
                        <th class="text-right">Total ($)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesesData as $row)
                        <tr>
                            <td>{{ $row['nombre'] }}</td>
                            <td class="text-right">{{ $row['cantidad'] }}</td>
                            <td class="text-right">${{ number_format($row['total'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td>Total año {{ $anio }}</td>
                        <td class="text-right">{{ collect($mesesData)->sum('cantidad') }}</td>
                        <td class="text-right">${{ number_format($totalAnual, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <footer class="reporte-footer">
                <p style="margin:0;">Documento generado el {{ now()->format('d/m/Y H:i') }}. Uso interno. Confidencial.</p>
                <p style="margin:4px 0 0 0;">Funeraria San José. Para guardar como PDF: Archivo → Imprimir → Guardar como PDF.</p>
            </footer>
        </div>
    </div>

    @if(request()->get('imprimir'))
        <script>window.onload = function() { window.print(); }</script>
    @endif
</body>
</html>
