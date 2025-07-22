<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma ricezione messaggio</title>
</head>
<body>
    <h1>Grazie per aver contattato La Molisana!</h1>

    <p>Ciao {{ $lead->nome }},</p>

    <p>Abbiamo ricevuto il tuo messaggio con oggetto: <strong>{{ $lead->oggetto }}</strong></p>

    <p>Il nostro team ti risponderà al più presto.</p>

    <p>Ecco una copia del tuo messaggio:</p>
    <blockquote>{{ $lead->messaggio }}</blockquote>

    <p>Grazie,<br>
    Il Team La Molisana</p>

    <hr>
    <small>
        Questo è un messaggio automatico. Per informazioni:
        <a href="mailto:info@lamolisana.it">info@lamolisana.it</a>
    </small>
</body>
</html>
