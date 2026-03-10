<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planilla de Control de Salón #{{ $control->id }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #2b2b2b;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #e15c26;
            padding-bottom: 15px;
        }
        h1 {
            color: #e15c26;
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-weight: bold;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th {
            text-align: left;
            background-color: #f3f4f6;
            padding: 8px 10px;
            border: 1px solid #ccc;
            width: 20%;
            text-transform: uppercase;
            font-size: 10px;
            color: #555;
        }
        .info-table td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            font-weight: bold;
            width: 30%;
        }
        .section-title {
            background-color: #374151;
            color: white;
            font-weight: bold;
            padding: 6px 10px;
            margin-top: 15px;
            border: 1px solid #374151;
            border-bottom: none;
            text-transform: uppercase;
            font-size: 11px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ccc;
            padding: 6px 10px;
        }
        .items-table th {
            background-color: #f9fafb;
            text-align: center;
            color: #444;
            font-size: 9px;
            text-transform: uppercase;
        }
        .items-table td:nth-child(1) {
            width: 40%;
            color: #111;
        }
        .items-table td:nth-child(2) {
            width: 20%;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        .items-table td:nth-child(3) {
            width: 40%;
            color: #444;
        }
        .observations {
            margin-top: 25px;
            border: 1px solid #ccc;
            page-break-inside: avoid;
        }
        .observations-header {
            background-color: #f3f4f6;
            font-weight: bold;
            padding: 8px 10px;
            border-bottom: 1px solid #ccc;
            text-transform: uppercase;
            font-size: 10px;
        }
        .observations-body {
            padding: 15px;
            min-height: 40px;
            font-style: italic;
        }
        .footer-section {
            margin-top: 30px;
            display: table;
            width: 100%;
            page-break-inside: avoid;
        }
        .footer-left {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
            font-style: italic;
            color: #888;
            font-weight: bold;
        }
        .footer-right {
            display: table-cell;
            width: 50%;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            width: 250px;
            border-bottom: 2px solid #000;
            text-align: center;
            font-weight: bold;
            padding-bottom: 5px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Planilla de Control de Salón – Panetto</h1>
        <p>Reporte interno #{{ $control->id }}</p>
    </div>

    <table class="info-table">
        <tr>
            <th>Sucursal:</th>
            <td>{{ $control->branch }}</td>
            <th>Registrada el:</th>
            <td>{{ $control->created_at->setTimezone('America/Argentina/Buenos_Aires')->format('d/m/Y - H:i') }} hs</td>
        </tr>
        <tr>
            <th>Turno:</th>
            <td>{{ $control->shift }}</td>
            <th>Encargado:</th>
            <td>{{ $control->manager }}</td>
        </tr>
    </table>

    @php
        $itemsData = is_array($control->items_data) ? $control->items_data : json_decode($control->items_data, true);
        if ($itemsData) {
            uksort($itemsData, function ($a, $b) {
                return intval($a) - intval($b);
            });
        }
    @endphp

    @if($itemsData)
        @foreach($itemsData as $sectionName => $items)
            <div class="section-title">
                {{ $sectionName }}
            </div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Control a realizar</th>
                        <th>Calificación (1-10)</th>
                        <th>Observaciones específicas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $itemName => $itemValues)
                        <tr>
                            <td>{{ $itemName }}</td>
                            <td>{{ $itemValues['rating'] ?? 0 }} / 10</td>
                            <td>{{ $itemValues['obs'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif

    <div class="observations">
        <div class="observations-header">Observaciones Generales</div>
        <div class="observations-body">
            {{ $control->general_observations ?: 'Sin observaciones generales u ocurrencias registradas durante este turno.' }}
        </div>
    </div>

    <div class="footer-section">
        <div class="footer-left">
            "Excelencia que inspira, servicio que honra."
        </div>
        <div class="footer-right">
            <div class="signature-line">
                {{ $control->signature }}
            </div>
            <div style="margin-top: 5px; color: #666; font-size: 10px; font-weight: bold; text-transform: uppercase;">
                Firma del Encargado
            </div>
        </div>
    </div>

</body>
</html>
