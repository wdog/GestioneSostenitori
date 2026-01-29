<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tessera Associativa</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">Associazione Trasimeno</h1>
        <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 14px;">Tessera Associativa {{ $anno }}</p>
    </div>

    <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px;">
        <p style="font-size: 18px; margin-bottom: 20px;">
            Gentile <strong>{{ $sostenitore->nome }} {{ $sostenitore->cognome }}</strong>,
        </p>

        <p>
            Ti ringraziamo per aver rinnovato la tua adesione all'Associazione Trasimeno per l'anno <strong>{{ $anno }}</strong>.
        </p>

        <div style="background: white; padding: 20px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #667eea;">
            <p style="margin: 0 0 10px 0;"><strong>Livello:</strong> {{ $livello->nome }}</p>
            <p style="margin: 0;"><strong>Anno:</strong> {{ $anno }}</p>
        </div>

        <p>
            In allegato trovi la tua tessera associativa in formato PDF che potrai stampare e conservare.
        </p>

        <p>
            Il tuo sostegno è fondamentale per le attività dell'associazione. Grazie per essere parte della nostra comunità!
        </p>

        <p style="margin-top: 30px;">
            Cordiali saluti,<br>
            <strong>Il Team dell'Associazione Trasimeno</strong>
        </p>
    </div>

    <div style="text-align: center; padding: 20px; color: #999; font-size: 12px;">
        <p>Questa email è stata inviata automaticamente. Per informazioni contattaci rispondendo a questa email.</p>
    </div>
</body>
</html>
