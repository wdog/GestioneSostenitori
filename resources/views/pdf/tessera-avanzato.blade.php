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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            padding: 15px;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            text-align: center;
            border-top: 4px solid #11998e;
        }
        .badge {
            display: inline-block;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .association {
            font-size: 14px;
            font-weight: bold;
            color: #11998e;
            margin-bottom: 8px;
        }
        .member-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 15px 0;
        }
        .code-box {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 8px;
            padding: 12px;
            margin: 10px 0;
        }
        .code-label {
            font-size: 8px;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            color: white;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
        }
        .year {
            display: inline-block;
            background: #e8f5e9;
            color: #11998e;
            padding: 6px 20px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
        .level {
            font-size: 10px;
            color: #999;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">Avanzato</div>
        <div class="association">{{ $nomeAssociazione }}</div>
        <div class="member-name">{{ $socio->nome }} {{ $socio->cognome }}</div>
        <div class="code-box">
            <div class="code-label">Codice Tessera</div>
            <div class="code">{{ $adesione->codice_tessera }}</div>
        </div>
        <div class="year">{{ $adesione->anno }}</div>
        <div class="level">Livello {{ $livello->nome }}</div>
    </div>
</body>
</html>
