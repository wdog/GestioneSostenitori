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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 15px;
        }
        .card {
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            text-align: center;
            color: white;
        }
        .badge {
            font-size: 10px;
            color: #f5576c;
            margin-bottom: 5px;
        }
        .association {
            font-size: 14px;
            font-weight: bold;
            color: #f5576c;
            margin-bottom: 8px;
        }
        .member-name {
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin: 15px 0;
        }
        .code-box {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            background: rgba(255,255,255,0.1);
            color: #f5576c;
            padding: 6px 20px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            border: 1px solid #f5576c;
        }
        .level {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">&#9733; PRO &#9733;</div>
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
