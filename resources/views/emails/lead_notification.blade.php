{{-- resources/views/emails/lead_notification.blade.php --}}
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Contatto da {{ config('app.name') }}</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --text-color: #333333;
            --light-bg: #f8f9fa;
            --border-radius: 6px;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f7f7f7;
        }

        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: var(--primary-color);
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 25px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .message-container {
            background-color: var(--light-bg);
            padding: 20px;
            border-radius: var(--border-radius);
            margin: 20px 0;
            border-left: 4px solid var(--accent-color);
        }

        .privacy-notice {
            font-size: 12px;
            color: #7f8c8d;
            padding: 12px;
            background-color: #f0f3f5;
            border-radius: var(--border-radius);
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: var(--secondary-color);
            color: #ffffff;
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-align: center;
            margin: 20px auto;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #7f8c8d;
            background-color: #ecf0f1;
        }

        @media (max-width: 480px) {
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Nuovo Contatto da {{ config('app.name') }}</h1>
        </div>

        <div class="content">
            <div class="detail-grid">
                <div class="detail-label">Nome:</div>
                <div>{{ $lead->nome }}</div>

                <div class="detail-label">Email:</div>
                <div><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></div>

                @if($lead->telefono)
                <div class="detail-label">Telefono:</div>
                <div>{{ $lead->telefono }}</div>
                @endif

                <div class="detail-label">Oggetto:</div>
                <div>{{ ucfirst($lead->oggetto) }}</div>
            </div>

            <div class="message-container">
                <h3 style="margin-top: 0; color: var(--accent-color);">Messaggio:</h3>
                <p style="white-space: pre-line;">{{ $lead->messaggio }}</p>
            </div>

            <div class="privacy-notice">
                <strong>Nota sulla privacy:</strong> L'utente ha accettato l'informativa privacy.
            </div>

            <a href="mailto:{{ $lead->email }}?subject=Risposta: {{ $lead->oggetto }}&cc={{ config('mail.from.address') }}"
               class="button"
               style="display: block; width: fit-content;">
               ✉️ Rispondi al contatto
            </a>
        </div>

        <div class="footer">
            <p>Ricevuto il {{ $lead->created_at->translatedFormat('j F Y \a\l\l\e H:i') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p>
        </div>
    </div>
</body>
</html>
