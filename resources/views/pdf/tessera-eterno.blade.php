<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #F9A825 0%, #FDD835 50%, #F9A825 100%);
            padding: 15px;
        }
        .card {
            background: linear-gradient(145deg, #1a1a1a 0%, #2d2d2d 100%);
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            text-align: center;
            color: white;
            border: 2px solid #F9A825;
        }
        .crown {
            font-size: 20px;
            margin-bottom: 5px;
        }
        .association {
            font-size: 14px;
            font-weight: bold;
            color: #F9A825;
            margin-bottom: 8px;
        }
        .member-name {
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin: 12px 0;
        }
        .code-box {
            background: linear-gradient(135deg, #F9A825 0%, #FDD835 100%);
            border-radius: 8px;
            padding: 12px;
            margin: 10px 0;
        }
        .code-label {
            font-size: 8px;
            color: rgba(0,0,0,0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            color: #1a1a1a;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
        }
        .year {
            display: inline-block;
            background: linear-gradient(135deg, #F9A825 0%, #FDD835 100%);
            color: #1a1a1a;
            padding: 6px 20px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
        }
        .lifetime {
            font-size: 9px;
            color: #F9A825;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="crown">&#9819;</div>
        <div class="association">{{ $nomeAssociazione }}</div>
        <div class="member-name">{{ $socio->nome }} {{ $socio->cognome }}</div>
        <div class="code-box">
            <div class="code-label">Codice Tessera</div>
            <div class="code">{{ $adesione->codice_tessera }}</div>
        </div>
        <div class="year">{{ $adesione->anno }}</div>
        <div class="lifetime">Socio a Vita</div>
    </div>
</body>
</html>
