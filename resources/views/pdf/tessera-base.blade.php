<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Tessera Socio</title>

    <style>
        @page {
            /* size: 85.6mm 54mm; */
            size: 210mm 148mm;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #111;
        }

        .card {
            margin: 20% auto;
            width: 85.6mm;
            height: 54mm;
            padding: 4mm;
            box-sizing: border-box;
            border-radius: 3mm;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 4mm;
        }

        .content {
            font-size: 9px;
        }

        .row {
            margin-bottom: 2mm;
        }

        .label {
            font-size: 8px;
            color: #555;
            text-transform: uppercase;
        }

        .value {
            font-weight: bold;
            font-size: 10px;
        }

        .footer {
            position: absolute;
            bottom: 4mm;
            left: 4mm;
            right: 4mm;
            font-size: 7.5px;
            text-align: right;
            color: #666;
        }

        .code {
            font-family: monospace;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="card">
    {{-- HEADER --}}
    <div class="header">
        {{ $ente['nome'] ?? 'ASSOCIAZIONE SPORTIVA' }}
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <div class="row">
            <div class="label">Nome e Cognome</div>
            <div class="value">{{ $socio['nome'] }} {{ $socio['cognome'] }}</div>
        </div>

        <div class="row">
            <div class="label">Codice Socio</div>
            <div class="value code">{{ $socio['codice'] }}</div>
        </div>

        <div class="row">
            <div class="label">Anno di iscrizione</div>
            <div class="value">{{ $socio['anno_iscrizione'] }}</div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Tessera personale – non cedibile
    </div>
</div>

</body>
</html>
