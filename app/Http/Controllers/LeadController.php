<?php

namespace App\Http\Controllers;

use App\Mail\NewLeadNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        // Validazione con messaggi personalizzati
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:100',
            'email' => 'required|email:rfc,dns|max:100',
            'telefono' => 'nullable|string|max:20|regex:/^[\d\s\-\+]+$/',
            'oggetto' => 'required|string|in:informazioni,distributore,feedback,altro',
            'messaggio' => 'required|string|min:10|max:2000',
            'accettazione_privacy' => 'required|accepted'
        ], [
            'nome.required' => 'Il campo nome è obbligatorio',
            'email.required' => 'Il campo email è obbligatorio',
            'email.email' => 'Inserisci un indirizzo email valido',
            'telefono.regex' => 'Formato telefono non valido (es. +39 012 3456789)',
            'oggetto.required' => 'Seleziona un oggetto per il messaggio',
            'oggetto.in' => 'Oggetto selezionato non valido',
            'messaggio.required' => 'Il messaggio è obbligatorio',
            'messaggio.min' => 'Il messaggio deve contenere almeno 10 caratteri',
            'accettazione_privacy.required' => 'Devi accettare la privacy policy',
            'accettazione_privacy.accepted' => 'Devi accettare la privacy policy'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $new_lead = new Lead();
            $new_lead->fill($data);
            $new_lead->save();

            Mail::to('info@lamolisana.it')
                ->send(new NewLeadNotification($new_lead));

            return redirect()
                ->back()
                ->with('success', 'Grazie per averci contattato! Ti risponderemo al più presto.');
        } catch (\Exception $e) {
            Log::error('Errore durante il salvataggio del lead: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Si è verificato un errore durante l\'invio. Riprova più tardi.')
                ->withInput();
        }
    }
}
