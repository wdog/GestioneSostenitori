<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Tessera Socio</title>

    <style>
        @page {
            size: 210mm 148mm;
            /* A5 orizzontale per test */
            margin: 0;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            background: #f2f4f7;
            color: #111;
        }

        .card {
            width: 85.6mm;
            height: 54mm;
            position: ;
            margin: 40mm 50mm;
            padding: 0;
            border-radius: 3mm;
            background: #ffffff;
            border: 1px solid #cfd6de;
            box-sizing: border-box;
            overflow: hidden;
        }

        /* HEADER COLORATO */
        .card-header {
            background: #1e88e5;
            color: #fff;
            padding: 3mm;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
        }

        .card-body {
            padding: 3mm 4mm;
            font-size: 9px;
        }

        .row {
            margin-bottom: 2mm;
        }

        .label {
            font-size: 7.5px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .value {
            font-weight: bold;
            font-size: 10px;
            color: #111827;
        }

        .code {
            font-family: monospace;
            letter-spacing: 0.5px;
            color: #1e88e5;
        }

        /* BADGE ANNO */
        .badge {
            display: inline-block;
            padding: 1mm 2mm;
            background: #e3f2fd;
            color: #1e88e5;
            font-size: 8px;
            font-weight: bold;
            border-radius: 2mm;
        }

        /* FOOTER */
        .card-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.5mm 4mm;
            font-size: 7px;
            text-align: right;
            color: #6b7280;
        }
    </style>
</head>

<body>

    <table class="page">
        <tr>
            <td align="center" valign="middle">

                <div class="card">

                    {{-- HEADER --}}
                    <div class="card-header">
                        {{ $ente['nome'] ?? 'ASSOCIAZIONE SPORTIVA' }}
                    </div>

                    {{-- BODY --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="label">Nome e Cognome</div>
                            <div class="value">
                                {{ $socio['nome'] }} {{ $socio['cognome'] }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Codice Socio</div>
                            <div class="value code">
                                {{ $socio['codice'] }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Anno di iscrizione</div>
                            <div class="value">
                                <span class="badge">
                                    {{ $socio['anno_iscrizione'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer">
                        Tessera personale – non cedibile
                    </div>

                </div>

            </td>
        </tr>
    </table>

</body>

</html>
