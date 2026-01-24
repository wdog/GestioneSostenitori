<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Tessera Socio</title>

    <style>
        :root {
            --primary: {{ $palette['primary'] }};
            --secondary: {{ $palette['secondary'] }};
            --accent: {{ $palette['accent'] }};
            --label: {{ $palette['label'] }};
        }

        @page {
            size: 210mm 148mm;
            /* A5 orizzontale per test */
            margin: 0;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
            color: #111;
        }

        /* contenitore per centratura PDF-safe */

        .card {
            position: relative;
            width: 85.6mm;
            height: 54mm;
            padding: 0;
            margin: 40mm 50mm;
            border-radius: 3mm;
            background: var(--secondary);
            border: 1px solid var(--primary);
            box-sizing: border-box;
            overflow: hidden;
        }

        /* HEADER COLORATO */
        .card-header {
            background: var(--primary);
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
            margin-bottom: 1mm;
            color: var(--label);
            text-transform: uppercase;
        }

        .value {
            font-weight: bold;
            font-size: 10px;
            color: var(--accent);
        }

        .code {
            font-family: monospace;
            letter-spacing: 0.5px;
            color: var(--accent);
        }

        .name {
            font-size: 14px;
        }

        /* BADGE ANNO */
        .badge {
            display: inline-block;
            padding: 1mm 2mm;
            background: var(--accent);
            color: var(--secondary);
            font-size: 8px;
            font-weight: bold;
            border-radius: 2mm;
        }

        /* FOOTER */
        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            border-top: 1px solid var(--primary);
            font-size: 7px;
            align-items: flex-end;
            justify-content: end;
            flex-direction: row;

            display: flex;
            background: var(--primary);
            color: var(--secondary);
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
                            <div class="value name">
                                {{ $socio['nome'] }} {{ $socio['cognome'] }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Codice</div>
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
                        <p>
                            {{ $livello->nome ?? '' }}
                            {{ $livello->descrizione ?? '' }}
                        </p>

                    </div>

                </div>

            </td>
        </tr>
    </table>

</body>

</html>
